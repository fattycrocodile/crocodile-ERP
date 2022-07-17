<?php

namespace App\Modules\Config\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lookup extends Model
{
    protected $table = 'lookups';
    protected $guarded = [];

    const CASH = 1;
    const CREDIT = 2;

    const PAYMENT_CASH = 1;
    const PAYMENT_BKASH = 2;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_OTHERS = 3;

    const MARTIAL_SINGLE = 1;
    const MARTIAL_MARRIED = 2;
    const MARTIAL_SEPARATED = 3;

    const RELIGION_ISLAM = 1;


    private static $_items = array();
    private static $_names = array();

    public static function items($type)
    {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        return self::$_items[$type];
    }

    public static function names($name)
    {
        if (!isset(self::$_names[$name]))
            self::loadNames($name);
        return self::$_names[$name];
    }

    public static function item($type, $code)
    {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }

    private static function loadItems($type)
    {
        self::$_items[$type] = array();
        $models = self::query()->where('type', '=', $type)->orderBy('name')->get();

        foreach ($models as $model)
            self::$_items[$type][$model->code] = $model->name;
    }

    private static function loadNames($name)
    {
        self::$_names[$name] = array();
        $models = self::query()->where('name', '=', $name)->orderBy('name')->get();
        foreach ($models as $model)
            self::$_names[$name][$model->code] = $model->name;
    }

    public static function typeList()
    {
        $types = self::query()->select(DB::raw('DISTINCT type'))->orderBy('type','asc')->get();
        return $types;
    }

}
