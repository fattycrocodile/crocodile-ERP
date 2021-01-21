<?php

namespace App\Model\Accounting;

use Illuminate\Database\Eloquent\Model;

class JournalDetails extends Model
{
    protected $guarded=[];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccounts::class);
    }
}
