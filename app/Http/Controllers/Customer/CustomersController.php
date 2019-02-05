<?php

namespace App\Http\Controllers\Customer;

use App\Http\Models\Customer;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repo\Contracts\CustomerInterface;

class CustomersController extends Controller
{
    private $customer;

    public function __construct(CustomerInterface $customer)
    {
        $this->customer = $customer;
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
        }else{
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

    public function getCustomer($nic)
    {
        $customer = $this->customer->getCustomer($nic);

        dd($customer);
        return \response()->json($customer);
    }
}