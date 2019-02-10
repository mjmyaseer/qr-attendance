<?php

namespace App\Http\Controllers\Customer;

use App\Http\Models\Customer;
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

    public function __construct(
        CustomerInterface $customer,
        OTPInterface $otp
    )
    {
        $this->customer = $customer;
        $this->otp = $otp;
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
        $data = $customer[0];
        $otp = mt_rand(1023, 9999);

        if (isset($data->customer_id)) {
            $data->otp = $otp;

            $this->sendSms($data);
        } else {
            return $customer['status'] = [
                'status' => 'FAILED',
                'code' => 403,
                'error' => Config::get('custom_messages.INVALID_NIC'),
                'message' => 'Invalid User'
            ];
        }

        // TODO remove otp from response
        return \response()->json($customer[0]);
    }

    private function sendSms($data)
    {
        $this->otp->saveOTP($data);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->all();

        dd($data);
    }
}