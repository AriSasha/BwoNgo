@extends('layouts.app')
@section('title', 'Talk to a counselor')
@section('content')
<div class="narrow stack">
    <div><p class="eyebrow">Anonymous messages</p><h2>Talk to the {{ $settings['office_name'] }}</h2></div>
    <p class="muted">The office sees you as <b>{{ $alias }}</b>. Your name is not shared unless you write it. Counselors reply during office hours{{ $settings['office_hours'] ? ' ('.$settings['office_hours'].')' : '' }}, so this is not for emergencies.</p>
    <div class="chat" id="chat">
        @forelse ($messages as $m)
            <div class="bubble {{ $m->sender === 'student' ? 'me' : 'them' }}">{{ $m->body }}<small>{{ $m->sender === 'student' ? 'You' : 'Counselor' }} · {{ $m->created_at->format('j M, H:i') }}</small></div>
        @empty
            <div class="empty">No messages yet. Say what's on your mind, ask a question, or ask how to book a session.</div>
        @endforelse
    </div>
    <form method="POST" action="{{ route('student.messages.store') }}" class="composer">
        @csrf
        <textarea name="body" aria-label="Message" placeholder="Write a message…" required></textarea>
        <button class="btn primary" type="submit">Send</button>
    </form>
    @error('body')<p class="err">{{ $message }}</p>@enderror
    <p class="small muted">In danger right now? Call Dr.Sharif Muyingo on 0752988221, Head of Psychotherapy services MUBS Healthcentre.</p>
</div>
@endsection
@push('scripts')<script>const c=document.getElementById('chat');c.scrollTop=c.scrollHeight;</script>@endpush
