<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'amount',
        'period',
        'daily_earning',
        'iamge',
        'status'
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function getDepositCountAttribute()
    {
        return Deposit::where('plan_id', $this->id)->where('status', 'active')->count();
    }
}
