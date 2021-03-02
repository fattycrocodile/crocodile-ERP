<?php

namespace App\Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class JournalDetails extends Model
{
    protected $guarded=[];

    public $timestamps = false;

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class,'ca_id');
    }
}
