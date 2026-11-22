<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_id', 'last_student_message_at', 'last_office_message_at', 'office_read_at', 'student_read_at',
    ];

    protected function casts(): array
    {
        return [
            'last_student_message_at' => 'datetime',
            'last_office_message_at' => 'datetime',
            'office_read_at' => 'datetime',
            'student_read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at')->orderBy('id');
    }

    public function unreadByOffice(): bool
    {
        return $this->last_student_message_at
            && (! $this->office_read_at || $this->last_student_message_at->gt($this->office_read_at));
    }

    public function unreadByStudent(): bool
    {
        return $this->last_office_message_at
            && (! $this->student_read_at || $this->last_office_message_at->gt($this->student_read_at));
    }

    public function lastActivity()
    {
        return collect([$this->last_student_message_at, $this->last_office_message_at])->filter()->max();
    }
}
