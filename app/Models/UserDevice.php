<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'device_id',
        'device_type',
        'device_name',
        'notification_token',
        'last_ip_address',
        'last_active_at'
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];

    /**
     * Get the user that owns the device.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
