<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\DataTables\PurchaseReturnDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\StoreInventory\Models\PurchaseReturn;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Http\Request;

class PurchaseReturnController extends BaseController
{
    public $model;
    public $store;

    public function __construct(PurchaseReturn $model)
    {
        $this->model = $model;
        $this->store = new Stores();
    }

    public function index(PurchaseReturnDataTable $dataTable)
    {
        $this->setPageTitle('Purchase Return', 'List of all Purchase Return');
        return $dataTable->render('StoreInventory::purchaseReturn.index');
    }

    public function create()
    {
        $stores = $this->store->treeList();
        $this->setPageTitle('Create Purchase Return', 'Create Purchase Return');
        return view('StoreInventory::purchaseReturn.create', compact('stores'));
    }


}
