@extends('layouts.app')
@section('title', 'Create account')
@section('content')
<div class="auth stack">
    <h2>Create your student account</h2>
    <p class="muted">Your check-in answers stay private to your account. The counseling office only sees your name if you choose to request a referral.</p>
    <form method="POST" action="{{ route('register') }}" class="card stack">
        @csrf
        <div class="field"><label for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" required autocomplete="name"></div>
        <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"></div>
        <div class="field"><label for="student_number">Student number (optional)</label><input id="student_number" name="student_number" value="{{ old('student_number') }}" inputmode="numeric"></div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="new-password"></div>
        <div class="field"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"></div>
        @if ($errors->any())<div class="err" role="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>@endif
        <button class="btn primary" type="submit">Create account</button>
    </form>
</div>
@endsection
