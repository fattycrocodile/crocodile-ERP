<?php

namespace App\Modules\StoreInventory\Models;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded=[];

    public function product()
    {
        return $this->hasMany(Product::class);
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
