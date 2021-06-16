<?php

namespace App\Modules\SupplyChain\Models;

use App\Modules\Hr\Models\Employees;
use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    public $table = 'territory';
    protected $guarded = [];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }


    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}
