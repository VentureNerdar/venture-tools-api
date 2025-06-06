<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrayerPrompt extends Model
{
    protected $fillable = [
        'prompt_text',
        'user_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
