<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierAggregator extends Model
{
    protected $fillable = [
        'name',
        'account_name',
        'api_key',
        'api_secret',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
