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

}
