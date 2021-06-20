<?php

namespace App\Modules\SupplyChain\Models;

use App\Modules\Hr\Models\Employees;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Territory extends Model
{
    public $table = 'territory';
    protected $guarded = [];

    public static function getTerritoryNameById($territory_id)
    {
        $data = DB::table('territory')
            ->select(DB::raw('name'))
            ->where('id','=',$territory_id)
            ->first();
        return $data ? $data->name : 'N/A';
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }


    public function employee()
    {
        return $this->belongsTo(Employees::class);
    }
}
