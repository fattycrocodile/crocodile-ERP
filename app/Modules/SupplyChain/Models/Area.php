<?php

namespace App\Modules\SupplyChain\Models;

use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $guarded = [];

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }
}
