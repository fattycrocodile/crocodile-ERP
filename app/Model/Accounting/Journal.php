<?php

namespace App\Model\Accounting;

use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded=[];

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
