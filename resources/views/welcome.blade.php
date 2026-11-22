@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="stack">
    <section class="hero">
        <div class="stack">
            <p class="eyebrow">Makerere University Business School</p>
            <h1>A private check-in on how you've been feeling</h1>
            <p class="lead">BwoNgo helps MUBS students check their mood and anxiety in a few minutes, see what their answers suggest, and reach the counseling office when they want support.</p>
            <div class="row">
                <a class="btn primary" href="{{ route('register') }}">Create a student account</a>
                <a class="btn" href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
        @include('partials.logo', ['class' => 'logo-big'])
    </section>
    <div class="features">
        <div class="card stack"><h3>Check in</h3><p class="muted">The PHQ-9 and GAD-7 questionnaires, scored straight away.</p></div>
        <div class="card stack"><h3>Get support</h3><p class="muted">Ask the counseling office to contact you. Your details are shared only with your consent.</p></div>
        <div class="card stack"><h3>Talk anonymously</h3><p class="muted">Message a counselor without giving your name.</p></div>
    </div>
    @include('partials.disclaimer')
     <p class="small muted">If you are in danger right now, <b>call Dr.Sharif Muyingo - Head of Psychotherapy services MUBS Healthcentre on 0752988221.</b></p>
</div>
@endsection
