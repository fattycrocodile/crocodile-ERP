<?php

namespace App\Modules\Hr\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HolidaySetup extends Model
{
    protected $table = 'holiday_setups';
    protected $guarded = [];

    const ACTIVE = 1;
    const INACTIVE = 2;

    public static function isHoliday($date)
    {
        $data = new HolidaySetup();
        $data = $data->where('date', '=', $date);
        $data = $data->first();
        return $data ? 1 : 0;
    }
    public static function totalHolidayInDateRange($dateFrom, $dateTo)
    {
        $data = new HolidaySetup();
        $data = $data->select(DB::raw('count(*) as total'));
        $data = $data->where('date', '>=', $dateFrom);
        $data = $data->where('date', '<=', $dateTo);
        $data = $data->first();
        return $data ? $data->total : 0;
    }
}
