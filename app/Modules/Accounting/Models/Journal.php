<?php

namespace App\Modules\Accounting\Models;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    public function maxSlNo()
    {
        $maxSn = $this->max('max_sl_no');
        return $maxSn ? $maxSn + 1 : 1;
    }

    public function journalDetails()
    {
        return $this->hasMany(JournalDetails::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class);
    }
}
