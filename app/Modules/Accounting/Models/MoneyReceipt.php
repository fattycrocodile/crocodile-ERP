<?php

namespace App\Modules\Accounting\Models;

use App\Modules\StoreInventory\Models\Stores;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class MoneyReceipt extends Model
{
    protected $guarded=[];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }
}
