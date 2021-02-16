<?php

namespace App\Modules\Commercial\Http\Controllers;


use App\DataTables\InvoiceDataTable;
use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\BaseController;
use App\Modules\Commercial\Models\Purchase;
use App\Modules\Commercial\Models\Suppliers;
use App\Modules\Config\Models\Lookup;
use App\Modules\StoreInventory\Models\Product;
use App\Traits\UploadAble;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends BaseController
{
    use UploadAble;

    public $model;
    public $supplier;
    public $products;
    public $lookup;

    public function __construct(Purchase $model)
    {
        $this->model = $model;
        $this->supplier = new Suppliers();
        $this->products = new Product();
        $this->lookup = new Lookup();
    }

    /**
     * @param PurchaseDataTable $dataTable
     * @return Factory|View
     */
    public function index(PurchaseDataTable $dataTable)
    {
        $this->setPageTitle('Purchase', 'List of all purchases');
        return $dataTable->render('Commercial::purchases.index');
    }

    public function create()
    {
        $payment_type = Lookup::items('payment_method');
        $cash_credit = Lookup::items('cash_credit');
        $bank = Lookup::items('bank');
        $this->setPageTitle('Create Purchase', 'Create Purchase');
        return view('Commercial::purchases.create', compact( 'payment_type', 'cash_credit', 'bank'));
    }
}
