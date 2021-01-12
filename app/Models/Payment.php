<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'bill_type_id',
        'status',
        'paid_at',
        'amount_received',
        'customer_name',
        'bill_account_number',
        'admin_commission',
        'merchant_commission',
        'invoice'
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    /**
     * Get the billType that owns the payment.
     */
    public function billType()
    {
        return $this->belongsTo('App\Models\BillType')->withTrashed();
    }
}
