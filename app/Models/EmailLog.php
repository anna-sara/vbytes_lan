<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'participant_id',
        'lan_id',
        'guardian_email',
        'mailtemplate_id',
        'smstemplate_id',
        'error',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function mailtemplate()
    {
        return $this->belongsTo(Mailtemplate::class);
    }

    public function smstemplate()
    {
        return $this->belongsTo(Smstemplate::class);
    }
}
