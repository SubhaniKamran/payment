<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantService extends Model
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
        'commission'
    ];

    /**
     * Get the user that owns the MerchantService.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

    /**
     * Get the billType that owns the MerchantService.
     */
    public function billType()
    {
        return $this->belongsTo('App\Models\BillType')->withTrashed();
    }
}
