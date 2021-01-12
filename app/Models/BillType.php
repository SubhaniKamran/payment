<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillType extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'admin_transaction_fee',
        'logo'
    ];

    /**
     * Get the payments for the bill type.
     */
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * Get the merchantServices for the bill type.
     */
    public function merchantServices()
    {
        return $this->hasMany('App\Models\MerchantService');
    }
}
