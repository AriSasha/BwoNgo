<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Screening extends Model
{
    protected $fillable = [
        'user_id', 'kind', 'phq9_score', 'gad7_score', 'phq9_item9', 'difficulty',
        'phq9_band', 'gad7_band', 'referral_suggested', 'answers',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'referral_suggested' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referral(): HasOne
    {
        return $this->hasOne(Referral::class);
    }

    public function hasSelfHarmAnswer(): bool
    {
        return $this->phq9_item9 > 0;
    }
}
