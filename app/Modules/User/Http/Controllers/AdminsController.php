<?php

namespace App\Modules\User\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Modules\StoreInventory\Models\Stores;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminsController extends BaseController
{
    public function index(AdminsDataTable $dataTable)
    {
        $this->setPageTitle('Admins', 'List of all admins');
        return $dataTable->render('User::admins.index');
    }

    public function create()
    {
        $stores = Stores::all();
        $roles = Role::all();
        $this->setPageTitle('Create Admin', 'create new admin');
        return view('User::admins.create', compact('stores', 'roles'));
    }

    public function store(Request $request)
    {
        //validate Form Data
        $request->validate([
            'name' => "required|min:3",
            'email' => "required|unique:users",
            'password' => "required|min:8",
        ]);

        $admin = new \App\Model\User\User();

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->password = bcrypt($request->password);
        $admin->store_id = $request->store_id;


        if ($admin->save()) {
            if ($request->roles) {
                $admin->assignRole($request->roles);
                return $this->responseRedirect('users.admins.index', 'Admin added successfully', 'success', false, false);
            }
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while creating Admin.', 'error', true, true);
        }
    }

    public function edit($id)
    {
        $admin = \App\Model\User\User::find($id);
        $stores = Stores::all();
        $roles = Role::all();
        $this->setPageTitle('Edit Role', 'Edit selected Role');
        return view('User::admins.edit', compact('stores', 'roles','admin'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'name' => "required|min:3",
            'email' => "required",
            'password' => "required|min:8",
        ]);

        $admin = \App\Model\User\User::find($id);

        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->username = $req->username;
        $admin->password = bcrypt($req->password);
        $admin->store_id = $req->store_id;

        //save all data to customer table
        if ($admin->update()) {
            if ($req->roles) {
                $admin->assignRole($req->roles);
                return $this->responseRedirect('users.admins.index', 'Admin edited successfully', 'success', false, false);
            }
        } else {
            //redirect to create customer page with previous input
            return $this->responseRedirectBack('Error occurred while updating Admin.', 'error', true, true);
        }

    }

    public function delete($id)
    {
        $data = \App\Model\User\User::find($id);
        if ($data->delete()) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Record has been deleted successfully!',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status_code' => 200,
                'message' => 'Please try again!',
            ]);
        }
    }


}
