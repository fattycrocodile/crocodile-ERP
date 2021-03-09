<?php

namespace App\Modules\Hr\Models;


use Illuminate\Database\Eloquent\Model;

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
}
