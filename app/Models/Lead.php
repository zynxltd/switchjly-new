<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'email',
        'name',
        'postcode',
        'source',
        'esp_synced_at',
        'esp_error',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'esp_synced_at' => 'datetime',
            'meta' => 'array',
        ];
    }
}
