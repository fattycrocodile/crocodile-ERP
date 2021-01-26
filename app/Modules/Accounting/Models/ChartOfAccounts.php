<?php

namespace App\Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccounts extends Model
{
    protected $guarded=[];

    public function journalDetails()
    {
        return $this->hasMany(JournalDetails::class);
    }

    public function children()
    {
        return $this->hasMany(ChartOfAccounts::class,'root_id');
    }

    public  function parent()
    {
        return $this->belongsTo(ChartOfAccounts::class,'root_id');
    }


}
