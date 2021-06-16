<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\User\User;
use App\Modules\Accounting\Models\MoneyReceipt;
use App\Modules\Crm\Models\Customers;
use App\Modules\Crm\Models\Invoice;
use App\Modules\Crm\Models\InvoiceReturn;
use App\Modules\Crm\Models\SellOrder;
use App\Modules\Hr\Models\Employees;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TypiCMS\NestableTrait;

class Stores extends Model
{
    use NestableTrait;

    protected $table = 'stores';
    protected $guarded=[];

    const DEFAULT_WAREHOUSE = 1;
    const ACTIVE = 1;
    const IN_ACTIVE = 0;

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

    public static function totalStores()
    {
        $data = new Stores();
        $data = $data->select(DB::raw('count(*) as total'));
        $data = $data->where('status', '=', self::ACTIVE);
        $data = $data->first();
        return $data ? $data->total : 0;
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
