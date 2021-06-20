<?php

namespace App\Modules\SupplyChain\Models;

use App\Modules\Hr\Models\Employees;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Area extends Model
{
    protected $table = 'areas';
    protected $guarded = [];

    public static function getAreaNameById($area_id)
    {
        $data = DB::table('areas')
            ->select(DB::raw('name'))
            ->where('id','=',$area_id)
            ->first();
        return $data ? $data->name : 'N/A';
    }

    public function store()
    {
        return $this->belongsTo(Stores::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}
