<?php

namespace App\Modules\Accounting\Http\Controllers;


use App\DataTables\ChartOfAcDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Accounting\Models\ChartOfAccounts;
use Illuminate\Http\Request;

class ChartOfAccountsController extends BaseController
{
    public function index(ChartOfAcDataTable $dataTable)
    {
        $this->setPageTitle('Chart Of Accounts','List Of Chart Of Accounts');
        return $dataTable->render('Accounting::chartofac.index');
    }

    public function create()
    {
        $chartofacs = ChartOfAccounts::all();
        $this->setPageTitle('Create Chart Of Accounts','Create a New Chart Of Accounts');
        return view('Accounting::chartofac.create',compact('chartofacs'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'root_id'=>'required',
        ]);

        $COA = new ChartOfAccounts();
        $COA->name = $req->name;
        $maxCd = $COA->max('code');
        //Generate new Max SN no
        $Max_cd = $maxCd ? $maxCd + 1 : 1;
        $COA->root_id = $req->root_id;
        $COA->code = str_pad($Max_cd, 4, '0', STR_PAD_LEFT);
        $COA->created_by = auth()->user()->id;
        $COA->updated_by = auth()->user()->id;

        if (!$COA->save()) {
            return $this->responseRedirectBack('Error occurred while creating Chart Of Accounts.', 'error', true, true);
        }
        return $this->responseRedirect('accounting.chartofaccounts.index', 'Chart Of Accounts added successfully', 'success', false, false);


    }

    public function edit($id)
    {
        $chartofacs = ChartOfAccounts::find($id);
        $this->setPageTitle('Edit Chart Of Accounts','Edit a Chart Of Accounts');
        return view('Accounting::chartofac.edit',compact('chartofacs'));
    }

    public function update(Request $req,$id)
    {

    }

    public function Delete(Request $req)
    {

    }

}
