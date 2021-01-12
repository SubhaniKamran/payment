<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripePaymentTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount'
    ];

     /**
     * Get the user that owns the StripePaymentTransaction.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
}
