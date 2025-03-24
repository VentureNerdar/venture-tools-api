<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLanguageTranslation extends Model
{
    //
    protected $fillable = [
        'translation',
        'system_language_id',
        'system_language_word_id'
    ];

    public function language()
    {
        return $this->belongsTo(SystemLanguage::class);
    }

    public function word()
    {
        return $this->belongsTo(SystemLanguageWord::class);
    }
}
