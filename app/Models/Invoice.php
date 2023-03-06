<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'reference',
        'trx_id',
        'status',
        'payment_channel',
        'paid_at'
    ];

    protected $appends = [
        'user_name',
        'plan_name'
    ];

    public function getUserNameAttribute()
    {
        return User::where('id', $this->user_id)->first()->name ?? "NA";
    }

    public function getPlanNameAttribute()
    {
        return Plan::where('id', $this->plan_id)->first()->name ?? "NA";
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
