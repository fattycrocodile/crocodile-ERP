<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceReturnDetails extends Model
{
    protected $guarded=[];

    public function invoiceReturn()
    {
        return $this->belongsTo(InvoiceReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
