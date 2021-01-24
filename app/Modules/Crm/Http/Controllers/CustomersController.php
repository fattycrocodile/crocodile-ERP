<?php

namespace App\Modules\Crm\Http\Controllers;


use App\Http\Controllers\BaseController;
use App\Model\User\User;
use App\Modules\Crm\Models\Customers;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Http\Request;

class CustomersController extends BaseController
{
    public function index()
    {
        $customers = Customers::all();
        $this->setPageTitle('Customers', 'List of all customers');
        return view('Crm::customers.index', compact('customers'));
    }

    public function create()
    {
        $stores = Stores::all();
        $this->setPageTitle('Create Customers', 'create new customers');
        return view('Crm::customers.create', compact('stores'));
    }

    public function store(Request $request)
    {
        //validate Form Data
        $request->validate([
            'name' => "required|min:3",
            'contact_no' => "required|min:11",
            'store_id' => "required",
            'address' => "required",
        ]);

        //Get store information by store id
        $store = Stores::find($request->store_id)->first();
        //include Customer model
        $customers = new Customers();
        //find max sn no from customer table
        $maxSn = $customers->where('store_id', '=', $request->store_id)->max('max_sn');
        //Generate new Max SN no
        $Max_sn = $maxSn ? $maxSn->max_sn + 1 : 1;
        //Assign new max_sn for user
        $customers->max_sn = $Max_sn;
        //Create and assign customer code
        $customers->code = $store->code . "-" . str_pad($Max_sn, 4, '0', STR_PAD_LEFT);
        //Assigning Form data to customer
        $customers->name = $request->name;
        $customers->contact_no = $request->contact_no;
        $customers->store_id = $request->store_id;
        $customers->address = $request->address;
        $customers->created_by = auth()->user()->id;

        //save all data to customer table
        if ($customers->save()) {
            //redirect to create customer page
            return redirect()->back();
        } else {
            //redirect to create customer page with previous input
            return redirect()->back()->withInput();
        }
    }
}
