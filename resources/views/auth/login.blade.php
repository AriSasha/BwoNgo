@extends('layouts.app')
@section('title', 'Sign in')
@section('content')
<div class="auth stack">
    <div class="row">@include('partials.logo', ['class' => 'logo-big'])</div>
    <h2>Sign in to BwoNgo</h2>
    <form method="POST" action="{{ route('login') }}" class="card stack">
        @csrf
        <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"></div>
        <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" required autocomplete="current-password"></div>
        <label class="check"><input type="checkbox" name="remember" value="1"><span>Keep me signed in</span></label>
        @error('email')<p class="err" role="alert">{{ $message }}</p>@enderror
        <button class="btn primary" type="submit">Sign in</button>
    </form>
    <p class="small muted">New here? <a href="{{ route('register') }}">Create a student account</a>. Counselors get their account from the BwoNgo admin.</p>
</div>
@endsection
