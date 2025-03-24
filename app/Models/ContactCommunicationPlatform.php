<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCommunicationPlatform extends Model
{
    protected $table = 'contact_communication_platform';
    protected $fillable = ['contact_id', 'communication_platform_id', 'value'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function communicationPlatform()
    {
        return $this->belongsTo(CommunicationPlatform::class);
    }
}
