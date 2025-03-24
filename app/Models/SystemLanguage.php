<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLanguage extends Model
{
    protected $fillable = [
        'name',
        'label',
        'locale',
        'is_enabled',
    ];

    public function translations()
    {
        return $this->hasMany(SystemLanguageTranslation::class);
    }
}
