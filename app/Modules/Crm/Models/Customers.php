<?php

namespace App\Modules\Crm\Models;

use App\Model\User\User;
use App\Modules\StoreInventory\Models\Stores;
use App\Modules\SupplyChain\Models\Territory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customers extends Model
{

    protected $table = 'customers';
    protected $guarded=[];

    public static function totalCustomerCount()
    {
        $data = DB::table('customers')
            ->select(DB::raw('count(*) as total'))->first();
        return $data ? $data->total : 0;
    }

    public function sellOrders()
    {
        return $this->hasMany(SellOrder::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoiceReturn()
    {
        return $this->hasMany(InvoiceReturn::class);
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
