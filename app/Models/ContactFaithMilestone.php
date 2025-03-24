<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactFaithMilestone extends Model
{
    protected $fillable = ['contact_id', 'faith_milestone_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function faithMilestone()
    {
        return $this->belongsTo(FaithMilestone::class);
    }
}
