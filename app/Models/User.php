<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'address',
        'phone',
        'status',
        'credit_limit',
        'credit_balance',
        'stire_customer_id',
        'stripe_card_id',
        'card_number',
        'card_exp_month',
        'card_cvc',
        'card_exp_year',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the payments for the user.
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * Get the merchantServices for the user.
     */
    public function merchantServices()
    {
        return $this->hasMany('App\Models\MerchantService');
    }

    /**
     * Get the stripePaymentTransactions for the user.
     */
    public function stripePaymentTransactions()
    {
        return $this->hasMany('App\Models\StripePaymentTransaction');
    }
}
