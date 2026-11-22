<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BwoNgo') · BwoNgo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/bwongo.css') }}">
</head>
<body>
<header class="top">
    <div class="wrap">
        <a class="brand" href="{{ route('welcome') }}">
            @include('partials.logo')
            <div><b>BwoNgo</b><span>Mental health check-in &amp; referral · MUBS</span></div>
        </a>
        <nav aria-label="Main">
            @auth
                @if (auth()->user()->isStudent())
                    @php($unread = auth()->user()->conversation?->unreadByStudent())
                    <a href="{{ route('student.home') }}" class="{{ request()->routeIs('student.home', 'student.screenings.*') ? 'on' : '' }}">Check-in</a>
                    <a href="{{ route('student.messages') }}" class="{{ request()->routeIs('student.messages') ? 'on' : '' }}">Talk to a counselor @if($unread)<span class="dot" aria-label="new reply"></span>@endif</a>
                    <a href="{{ route('student.history') }}" class="{{ request()->routeIs('student.history') ? 'on' : '' }}">My results</a>
                @else
                    @php($newRefs = \App\Models\Referral::where('status', 'new')->count())
                    @php($unreadThreads = \App\Models\Conversation::whereNotNull('last_student_message_at')->where(fn ($q) => $q->whereNull('office_read_at')->orWhereColumn('last_student_message_at', '>', 'office_read_at'))->count())
                    <a href="{{ route('office.referrals.index') }}" class="{{ request()->routeIs('office.referrals.*') ? 'on' : '' }}">Referrals @if($newRefs)<span class="dot" aria-label="{{ $newRefs }} new"></span>@endif</a>
                    <a href="{{ route('office.messages.index') }}" class="{{ request()->routeIs('office.messages.*') ? 'on' : '' }}">Messages @if($unreadThreads)<span class="dot" aria-label="unread"></span>@endif</a>
                    <a href="{{ route('office.overview') }}" class="{{ request()->routeIs('office.overview') ? 'on' : '' }}">Overview</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('office.settings') }}" class="{{ request()->routeIs('office.settings') ? 'on' : '' }}">Settings</a>
                    @endif
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Sign out</button></form>
            @else
                <a href="{{ route('login') }}">Sign in</a>
                <a href="{{ route('register') }}">Create account</a>
            @endauth
        </nav>
    </div>
</header>
<main class="wrap">
    @if (session('status'))
        <div class="notice narrow" role="status" style="margin-bottom:16px">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>
@stack('scripts')
</body>
</html>
