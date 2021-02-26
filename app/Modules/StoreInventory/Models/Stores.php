<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\User\User;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Crm\Models\Customers;
use App\Modules\Crm\Models\Invoice;
use App\Modules\Crm\Models\InvoiceReturn;
use App\Modules\Crm\Models\SellOrder;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;

class Stores extends Model
{
    use NestableTrait;

    protected $table = 'stores';
    protected $guarded=[];

    const DEFAULT_WAREHOUSE = 1;

    /**
     * @return mixed
     */
    public function treeList()
    {
        return Stores::orderByRaw('-name ASC')
            ->get()
            ->nest()
            ->listsFlattened('name');
    }

    public function sellOrder()
    {
        return $this->hasMany(SellOrder::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function InvoiceReturn()
    {
        return $this->hasMany(InvoiceReturn::class);
    }

    public function customer()
    {
        return $this->hasMany(Customers::class);
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function sendStore()
    {
        return $this->hasMany(StoreTransfer::class);
    }

    public function receiveStore()
    {
        return $this->hasMany(StoreTransfer::class);
    }

    public function purchaseReturn()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function moneyReceipt()
    {
        return $this->hasMany(MoneyReceipt::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
