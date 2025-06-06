<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrayerPrompt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prompt_text',
        'user_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
