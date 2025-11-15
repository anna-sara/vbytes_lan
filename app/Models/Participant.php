<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Version;

class Participant extends Model
{
    protected $fillable = [
        'member',
        'lan_id',
        'first_name',
        'surname',
        'grade',
        'phone',
        'email',
        'guardian_name',
        'guardian_phone',
        'guardian_email',
        'is_visiting',
        'gdpr',
        'friends',
        'special_diet',
        'status',
        'emailed',
        'comment',
        'paid'
    ];

    protected static function booted()
    {
        static::created(function ($post) {
            $latest_version = Version::where('table', 'participants')->latest()->first();

            if($latest_version) {
                Version::create([
                    'table' => 'participants',
                    'version' => $latest_version->version + 1,
                ]);
            } else {
                Version::create([
                    'table' => 'participants',
                    'version' => 1,
                ]);
            }
        });
        static::updated(function ($post) {
            $latest_version = Version::where('table', 'participants')->latest()->first();

            if($latest_version) {
                Version::create([
                    'table' => 'participants',
                    'version' => $latest_version->version + 1,
                ]);
            } else {
                Version::create([
                    'table' => 'participants',
                    'version' => 1,
                ]);
            }
        });
        static::deleted(function ($post) {
            $latest_version = Version::where('table', 'participants')->latest()->first();

        if($latest_version) {
            Version::create([
                'table' => 'participants',
                'version' => $latest_version->version + 1,
            ]);
        } else {
              Version::create([
                'table' => 'participants',
                'version' => 1,
            ]);
        }
        });
    }
}
