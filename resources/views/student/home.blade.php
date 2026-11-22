@extends('layouts.app')
@section('title', 'Check-in')
@section('content')
<div class="narrow stack">
    <section class="stack">
        <p class="eyebrow">Hello, {{ auth()->user()->name }}</p>
        <h1>How have you been feeling these last two weeks?</h1>
        <p class="muted">Answer a few short questions in private. You'll see your results straight away, with ideas that may help, and you can ask the {{ \App\Models\Setting::value('office_name') }} to reach out if you'd like support.</p>
    </section>
    <div class="choices">
        <a class="choice rec" href="{{ route('student.screenings.create', ['kind' => 'both']) }}"><b>Full check-in</b><span>Mood and anxiety · 17 questions · about 3 minutes</span></a>
        <a class="choice" href="{{ route('student.screenings.create', ['kind' => 'phq9']) }}"><b>Mood only</b><span>PHQ-9 · 9 questions</span></a>
        <a class="choice" href="{{ route('student.screenings.create', ['kind' => 'gad7']) }}"><b>Anxiety only</b><span>GAD-7 · 7 questions</span></a>
    </div>
    <div class="card stack">
        <h3>What happens to your answers</h3>
        <p class="muted">Your answers and scores are saved to your account and only you can see them. The counseling office sees anonymous totals without names. Your name and contact details are shared only if you choose to request a referral.</p>
    </div>
    @include('partials.disclaimer')
    <p class="small muted">If you are in danger right now, <b>call Dr.Sharif Muyingo - Head of Psychotherapy services MUBS Healthcentre on 0752988221.</b></p>
</div>
@endsection
