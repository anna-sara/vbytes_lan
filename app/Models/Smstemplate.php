<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smstemplate extends Model
{
    protected $fillable = [
        'title',
        'content',
        'type',
        'draft',
    ];
}
