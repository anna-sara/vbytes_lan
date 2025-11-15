<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Version;

class Volunteer extends Model
{
     protected $fillable = [
        'lan_id',
        'first_name',
        'surname',
        'phone',
        'email',
        'gdpr',
        'areas',
        'emailed',
        'comment'
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'areas' => 'array',
        ];
    }

     protected static function booted()
    {
        static::created(function ($post) {
             $latest_version = Version::where('table', 'volunteers')->latest()->first();

            if($latest_version) {
                Version::create([
                    'table' => 'volunteers',
                    'version' => $latest_version->version + 1,
                ]);
            } else {
                Version::create([
                    'table' => 'volunteers',
                    'version' => 1,
                ]);
            }
        });
        static::updated(function ($post) {
              $latest_version = Version::where('table', 'volunteers')->latest()->first();

            if($latest_version) {
                Version::create([
                    'table' => 'volunteers',
                    'version' => $latest_version->version + 1,
                ]);
            } else {
                Version::create([
                    'table' => 'volunteers',
                    'version' => 1,
                ]);
            }
        });
        static::deleted(function ($post) {
              $latest_version = Version::where('table', 'volunteers')->latest()->first();

            if($latest_version) {
                Version::create([
                    'table' => 'volunteers',
                    'version' => $latest_version->version + 1,
                ]);
            } else {
                Version::create([
                    'table' => 'volunteers',
                    'version' => 1,
                ]);
            }
        });
    }

   
}
