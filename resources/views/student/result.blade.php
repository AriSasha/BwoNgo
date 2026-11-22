@extends('layouts.app')
@section('title', 'Your results')
@php($S = \App\Support\Screening::class)
@section('content')
<div class="narrow stack">
    <div>
        <p class="eyebrow">Your results · {{ $s->created_at->format('j M Y, H:i') }}</p>
        <h2>{{ $s->referral_suggested ? 'It looks like things have been hard lately' : 'Thanks for checking in' }}</h2>
    </div>

    @if ($s->hasSelfHarmAnswer())
        @include('partials.crisis')
    @endif

    <div class="scores">
        @if ($s->phq9_score !== null)
            <div class="card score">
                <div class="row between"><span class="eyebrow">Mood · PHQ-9</span>@include('partials.band', ['band' => $s->phq9_band])</div>
                <div class="num">{{ $s->phq9_score }}<small> / 27</small></div>
                @include('partials.scale', ['score' => $s->phq9_score, 'max' => 27, 'segments' => [[0,4,'ok'],[5,9,'mild'],[10,14,'warn'],[15,19,'high'],[20,27,'high']]])
                <p class="small muted">{{ $S::interpretation('phq9', $s->phq9_band) }}</p>
            </div>
        @endif
        @if ($s->gad7_score !== null)
            <div class="card score">
                <div class="row between"><span class="eyebrow">Anxiety · GAD-7</span>@include('partials.band', ['band' => $s->gad7_band])</div>
                <div class="num">{{ $s->gad7_score }}<small> / 21</small></div>
                @include('partials.scale', ['score' => $s->gad7_score, 'max' => 21, 'segments' => [[0,4,'ok'],[5,9,'mild'],[10,14,'warn'],[15,21,'high']]])
                <p class="small muted">{{ $S::interpretation('gad7', $s->gad7_band) }}</p>
            </div>
        @endif
    </div>
    @if ($s->difficulty !== null)
        <p class="small muted">You said these problems made daily life <b>{{ strtolower($S::DIFFICULTY[$s->difficulty]) }}</b>.</p>
    @endif

    @if ($s->referral)
        <section class="ticket">
            <span class="eyebrow">Referral sent</span>
            <code>{{ $s->referral->ticket }}</code>
            <p>The {{ $settings['office_name'] }} has your request and will contact you by {{ strtolower($s->referral->contact_method) }}. Status: <span class="chip bg-neutral">{{ $s->referral->statusLabel() }}</span></p>
            @include('student.partials.office')
        </section>
    @elseif ($s->referral_suggested)
        <section class="card stack">
            <h3>Ask the counseling office to reach out</h3>
            <p class="muted">Your results are at a level where talking to a counselor can really help. Share how they can reach you and they will contact you. Nothing is sent until you press the button.</p>
            @include('student.partials.referral-form')
        </section>
    @else
        <section class="stack">
            <h3>Things that may help</h3>
            <div class="res">
                @foreach ($resources as $res)
                    <div class="card stack"><b>{{ $res->title }}</b><p class="small muted">{{ $res->body }}</p></div>
                @endforeach
            </div>
        </section>
        <details class="card" @if($errors->any()) open @endif>
            <summary style="cursor:pointer;font-weight:700">I'd still like to talk to a counselor</summary>
            <div class="stack" style="margin-top:14px">@include('student.partials.referral-form')</div>
        </details>
    @endif

    <div class="card row between">
        <div style="flex:1 1 260px;min-width:0"><b>Prefer to stay anonymous?</b><p class="small muted">Send a private message to the counseling office without giving your name.</p></div>
        <a class="btn" href="{{ route('student.messages') }}">Message anonymously</a>
    </div>
    @include('partials.disclaimer')
    <div class="row"><a class="btn ghost" href="{{ route('student.home') }}">Start a new check-in</a></div>
</div>
@endsection
