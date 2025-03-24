<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchPlanter extends Model
{
    protected $fillable = [
        'church_id',
        'user_id',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
