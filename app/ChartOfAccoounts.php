<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccoounts extends Model
{
    protected $guarded=[];

    public function journalDetails()
    {
        return $this->hasMany(JournalDetails::class);
    }
}
