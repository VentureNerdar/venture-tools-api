<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLanguageWord extends Model
{
    //
    protected $fillable = [
        'word',
    ];

    public function translations()
    {
        return $this->hasMany(SystemLanguageTranslation::class);
    }
}
