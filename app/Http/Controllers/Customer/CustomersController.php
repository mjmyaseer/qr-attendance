<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SMSController;
use App\Http\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Isurindu\LaravelSms\Facades\Sms;
use Repo\Contracts\CustomerInterface;
use Repo\Contracts\OTPInterface;

class CustomersController extends Controller
{
    private $customer;
    private $otp;
    /**
     * @var SMSController
     */
    private $SMSController;
    /**
     * @var LoginController
     */
    private $loginController;

    /**
     * CustomersController constructor.
     * @param CustomerInterface $customer
     * @param OTPInterface $otp
     * @param SMSController $SMSController
     * @param LoginController $loginController
     */
    public function __construct(
        CustomerInterface $customer,
        OTPInterface $otp,
        SMSController $SMSController,
        LoginController $loginController
    )
    {
        $this->customer = $customer;
        $this->otp = $otp;
        $this->SMSController = $SMSController;
        $this->loginController = $loginController;
    }

    public function index()
    {
        $customers = $this->customer->index();

        return view('customer.index')->with('customers', $customers);
    }

    public function addCustomer($id = null)
    {
        if (!$id == null) {
            $customers = $this->customer->index($id);

            return view('customer.add_customers')->with('customers', $customers);
        } else {
            return view('customer.add_customers');
        }

    }

    public function saveCustomer($id = null, Request $request)
    {
//        dd($request->all());
        $validationRules = [
            'customer_code' => 'required',
            'customer_name' => 'required',
            'customer_email' => 'required',
            'customer_telephone' => 'required',
            'customer_address' => 'required',
            'customer_nic' => 'required'
        ];
        if (!isset($id)) {

            $validationRules['customer_code'] = 'required|unique:' . Customer::TABLE . ',customer_code';
            $validationRules['customer_email'] = 'required|unique:' . Customer::TABLE . ',customer_email';
            $validationRules['customer_telephone'] = 'required|unique:' . Customer::TABLE . ',customer_telephone';
            $validationRules['customer_nic'] = 'required|unique:' . Customer::TABLE . ',customer_nic';
        }
        $this->validate($request, $validationRules);

        $customersStatus = $this->customer->saveCustomer($id, $request);
        $customers = $customersStatus['result'];

        if ($customersStatus['status']['code'] == 200) {
            flash()->success($customersStatus['status']['message']);
            return Redirect::to('secure/customers')->with('customers', $customers);

        } elseif ($customersStatus['status']['code'] == 422) {
            flash()->error($customersStatus['status']['message']);
        }

    }

    public function searchByCustomerName(Request $request)
    {
        $data = $request->all();

        $keyword['customer_name'] = $request->get('keyword');

        $customer = $this->customer->index($keyword);

        return \response()->json($customer);
    }

    public function getCustomer(Request $request)
    {

        $nic = $request->get('nic');
        $customer = $this->customer->getCustomer($nic);

        $otp = mt_rand(1023, 9999);

        if (isset($customer->customer_id)) {
            $customer->otp = $otp;


            $smsDetails = [];
            $smsDetails['phone'] = $customer->phone;
            $smsDetails['message'] = 'Please use the following OTP '.$customer->otp .' to complete your request';
            $this->saveOTP($customer);
            $this->SMSController->sendSMS($smsDetails);


            $results = [
                'customer_id'=>$customer->customer_id,
                'phone'=>$customer->phone,
            ];
        } else {
            return response()
                ->make(Config::get('custom_messages.INVALID_NIC'), 403);
        }

        return \response()->json($results);
    }

    private function saveOTP($data)
    {
        $this->otp->saveOTP($data);
    }

    public function verifyOtp(Request $request)
    {
        $results = $this->otp->verifyOTP($request);

        if (isset($results->id) && ($results->id != null)) {
            $customer = $this->customer->index($results->customer_id);

            $request->merge(['email' => $customer[0]->customer_email]);
            $request->merge(['nic' => $customer[0]->customer_nic]);

            $result = $this->loginController->doSession($request);
//            $return = []
            return \response()->json($result);
        } else {
            return response()
                ->make(Config::get('custom_messages.INVALID_OTP'), 403);
        }

    }
}