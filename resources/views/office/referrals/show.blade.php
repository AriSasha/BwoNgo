@extends('layouts.app')
@section('title', $r->ticket)
@php($S = \App\Support\Screening::class)
@php($tone = ['urgent' => 'high', 'high' => 'warn', 'routine' => 'neutral'])
@section('content')
<div class="narrow stack">
    <a class="btn ghost" href="{{ route('office.referrals.index') }}" style="align-self:flex-start">← All referrals</a>
    <div class="card stack">
        <div class="row between">
            <div><p class="eyebrow">{{ $r->ticket }} · {{ $r->created_at->format('j M Y, H:i') }}</p><h2>{{ $r->full_name }}</h2></div>
            <span class="chip bg-{{ $tone[$r->urgency] }}">{{ ucfirst($r->urgency) }}</span>
        </div>
        @if ($r->screening->hasSelfHarmAnswer())
            <div class="alert"><b>Self-harm item answered:</b> PHQ-9 question 9 scored {{ $r->screening->phq9_item9 }} ({{ strtolower($S::OPTIONS[$r->screening->phq9_item9]) }}). Contact this student today.</div>
        @endif
        <dl class="kv">
            <dt>Student no.</dt><dd>{{ $r->student_number ?: 'Not given' }}</dd>
            <dt>Contact</dt><dd><b>{{ $r->contact }}</b> · {{ $r->contact_method }}</dd>
            <dt>Best time</dt><dd>{{ $r->preferred_time ?: 'Not given' }}</dd>
            <dt>PHQ-9</dt><dd>@if($r->screening->phq9_score !== null){{ $r->screening->phq9_score }} / 27 @include('partials.band', ['band' => $r->screening->phq9_band])@else Not taken @endif</dd>
            <dt>GAD-7</dt><dd>@if($r->screening->gad7_score !== null){{ $r->screening->gad7_score }} / 21 @include('partials.band', ['band' => $r->screening->gad7_band])@else Not taken @endif</dd>
            @if ($r->screening->difficulty !== null)<dt>Daily life</dt><dd>{{ $S::DIFFICULTY[$r->screening->difficulty] }}</dd>@endif
            <dt>Their note</dt><dd>{{ $r->note ?: 'None' }}</dd>
            @if ($r->user->conversation)
                <dt>Messages</dt><dd><a href="{{ route('office.messages.show', $r->user->conversation) }}">Open conversation with {{ $r->user->alias() }}</a></dd>
            @endif
        </dl>
    </div>

    <details class="card">
        <summary style="cursor:pointer;font-weight:700">Answers to each question</summary>
        <div class="scroll-x" style="margin-top:12px"><table class="data">
            <tbody>
            @foreach (['phq9' => $S::PHQ9, 'gad7' => $S::GAD7] as $scale => $questions)
                @foreach ($r->screening->answers[$scale] ?? [] as $i => $v)
                    <tr><td class="small muted">{{ $scale === 'phq9' ? 'PHQ-9' : 'GAD-7' }} Q{{ $i + 1 }}</td><td>{{ $questions[$i] }}</td><td>{{ $S::OPTIONS[$v] }}</td></tr>
                @endforeach
            @endforeach
            </tbody>
        </table></div>
    </details>

    <form method="POST" action="{{ route('office.referrals.update', $r) }}" class="card stack">
        @csrf @method('PUT')
        <div class="field"><label for="status">Status</label>
            <select id="status" name="status">
                @foreach (\App\Models\Referral::STATUSES as $k => $label)<option value="{{ $k }}" @selected($r->status === $k)>{{ $label }}</option>@endforeach
            </select>
        </div>
        <div class="field"><label for="counselor_notes">Office notes (never shown to the student)</label><textarea id="counselor_notes" name="counselor_notes">{{ old('counselor_notes', $r->counselor_notes) }}</textarea></div>
        <div class="row">
            <button class="btn primary" type="submit">Save</button>
            @if ($r->handler)<span class="small muted">Last updated by {{ $r->handler->name }} {{ $r->updated_at->diffForHumans() }}</span>@endif
        </div>
    </form>
</div>
@endsection
