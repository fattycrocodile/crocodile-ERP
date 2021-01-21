<?php

namespace App\Model\Inventory;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class SellPrice extends Model
{
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
