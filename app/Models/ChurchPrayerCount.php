<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchPrayerCount extends Model
{
    protected $fillable = [
        'user_id',
        'church_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }
}
