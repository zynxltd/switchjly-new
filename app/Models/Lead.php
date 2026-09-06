<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'email',
        'name',
        'postcode',
        'source',
        'affiliate_id',
        'referral_code',
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

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }
}
