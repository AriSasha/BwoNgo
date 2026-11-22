<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Referral extends Model
{
    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'scheduled' => 'Appointment set',
        'closed' => 'Closed',
    ];

    public const CONTACT_METHODS = ['Phone call', 'WhatsApp', 'SMS', 'Email', "I'll come to the office"];

    protected $fillable = [
        'ticket', 'user_id', 'screening_id', 'full_name', 'student_number', 'contact',
        'contact_method', 'preferred_time', 'note', 'consent', 'urgency', 'status',
        'counselor_notes', 'handled_by', 'status_changed_at',
    ];

    protected function casts(): array
    {
        return [
            'consent' => 'boolean',
            'status_changed_at' => 'datetime',
        ];
    }

    public static function newTicket(): string
    {
        do {
            $ticket = 'BWN-'.now()->format('ymd').'-'.Str::upper(Str::random(4));
        } while (static::where('ticket', $ticket)->exists());

        return $ticket;
    }

    public static function urgencyFor(Screening $s): string
    {
        if ($s->phq9_item9 > 0) {
            return 'urgent';
        }

        return max((int) $s->phq9_score, (int) $s->gad7_score) >= 15 ? 'high' : 'routine';
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
