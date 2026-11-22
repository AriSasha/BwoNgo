@extends('layouts.app')
@section('title', 'Overview')
@php($phqBands = ['Minimal' => 'ok', 'Mild' => 'mild', 'Moderate' => 'warn', 'Moderately severe' => 'high', 'Severe' => 'high'])
@php($gadBands = ['Minimal' => 'ok', 'Mild' => 'mild', 'Moderate' => 'warn', 'Severe' => 'high'])
@section('content')
<div class="stack">
    <div><h2>Overview</h2><p class="small muted">Check-in figures are totals only. Names appear only on referrals, where the student gave consent.</p></div>
    <div class="tiles">
        <div class="tile"><b>{{ $total }}</b><span>Check-ins in total</span></div>
        <div class="tile"><b>{{ $lastWeek }}</b><span>In the last 7 days</span></div>
        <div class="tile"><b>{{ $referralRate }}</b><span>Reached the referral level</span></div>
        <div class="tile"><b>{{ $newReferrals }}</b><span>New referrals waiting</span></div>
        <div class="tile"><b class="{{ $selfHarm ? 't-high' : '' }}">{{ $selfHarm }}</b><span>Reported self-harm thoughts</span></div>
    </div>
    <div class="scores">
        @foreach ([['Mood · PHQ-9', $phq9, $phqBands], ['Anxiety · GAD-7', $gad7, $gadBands]] as [$title, $counts, $bands])
            @php($n = max(1, $counts->sum()))
            <div class="card stack">
                <h3>{{ $title }}</h3>
                <div class="bars">
                    @foreach ($bands as $band => $tone)
                        <div class="hbar"><span>{{ $band }}</span><span class="track"><i class="fill-{{ $tone }}" style="width: {{ round(($counts[$band] ?? 0) / $n * 100, 1) }}%"></i></span><span class="n">{{ $counts[$band] ?? 0 }}</span></div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @if (! $total)<p class="muted">Charts fill in as students complete check-ins.</p>@endif
</div>
@endsection
