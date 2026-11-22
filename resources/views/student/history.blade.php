@extends('layouts.app')
@section('title', 'My results')
@section('content')
<div class="narrow stack">
    <div><p class="eyebrow">Only you can see this page</p><h2>My results</h2></div>
    <section class="card stack">
        <h3>Referral requests</h3>
        @if ($referrals->isEmpty())
            <p class="muted">You haven't requested a referral.</p>
        @else
            <div class="scroll-x"><table class="data">
                <thead><tr><th>Ticket</th><th>Sent</th><th>Status</th></tr></thead>
                <tbody>
                @foreach ($referrals as $r)
                    <tr><td><code>{{ $r->ticket }}</code></td><td>{{ $r->created_at->format('j M Y') }}</td><td><span class="chip bg-neutral">{{ $r->statusLabel() }}</span></td></tr>
                @endforeach
                </tbody>
            </table></div>
        @endif
    </section>
    <section class="card stack">
        <h3>Past check-ins</h3>
        @if ($screenings->isEmpty())
            <p class="muted">Your check-ins will appear here so you can see how you're doing over time.</p>
        @else
            <div class="scroll-x"><table class="data">
                <thead><tr><th>Date</th><th>Mood (PHQ-9)</th><th>Anxiety (GAD-7)</th><th></th></tr></thead>
                <tbody>
                @foreach ($screenings as $s)
                    <tr>
                        <td>{{ $s->created_at->format('j M Y, H:i') }}</td>
                        <td>@if($s->phq9_score !== null){{ $s->phq9_score }} @include('partials.band', ['band' => $s->phq9_band])@else · @endif</td>
                        <td>@if($s->gad7_score !== null){{ $s->gad7_score }} @include('partials.band', ['band' => $s->gad7_band])@else · @endif</td>
                        <td><a href="{{ route('student.screenings.show', $s) }}">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
        @endif
    </section>
    <a class="btn primary" href="{{ route('student.home') }}" style="align-self:flex-start">Take a check-in</a>
</div>
@endsection
