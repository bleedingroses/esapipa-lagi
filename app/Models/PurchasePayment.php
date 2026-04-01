<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $guarded = [];
    
    function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_purchase_payment')->withPivot('amount');
    }

    function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
