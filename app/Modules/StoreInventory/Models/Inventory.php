<?php

namespace App\Modules\StoreInventory\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    const REF_INVOICE = 1;
    protected $table = 'inventories';
    protected $guarded=[];
}
