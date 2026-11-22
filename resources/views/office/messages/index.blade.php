@extends('layouts.app')
@section('title', 'Messages')
@section('content')
<div class="stack">
    <h2>Anonymous messages</h2>
    <div class="bench">
        <div class="list">
            @forelse ($conversations as $c)
                @php($last = $c->messages->last())
                <a class="item {{ $current?->id === $c->id ? 'on' : '' }}" href="{{ route('office.messages.show', $c) }}">
                    <span class="stripe fill-ok" style="opacity: {{ $c->unreadByOffice() ? 1 : 0 }}"></span>
                    <div><span class="who">{{ $c->user->alias() }}@if($c->unreadByOffice())<span class="dot" aria-label="unread"></span>@endif</span><span class="meta">{{ $last->sender === 'office' ? 'You: ' : '' }}{{ $last->body }}</span></div>
                    <span class="small muted">{{ $c->lastActivity()?->diffForHumans(short: true) }}</span>
                </a>
            @empty
                <div class="empty">No messages yet. Students can write to the office anonymously from "Talk to a counselor".</div>
            @endforelse
        </div>
        <div>
            @if ($current)
                <div class="stack">
                    <div class="row between">
                        <h3>{{ $current->user->alias() }}</h3>
                        @if ($current->user->referrals->isNotEmpty())
                            <span class="chip bg-mild">{{ $current->user->referrals->count() }} referral(s) on file</span>
                        @else
                            <span class="chip bg-neutral">Anonymous</span>
                        @endif
                    </div>
                    <div class="chat" id="chat">
                        @foreach ($current->messages as $m)
                            <div class="bubble {{ $m->sender === 'office' ? 'me' : 'them' }}">{{ $m->body }}<small>{{ $m->sender === 'office' ? 'Office' : 'Student' }} · {{ $m->created_at->format('j M, H:i') }}</small></div>
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('office.messages.reply', $current) }}" class="composer">
                        @csrf
                        <textarea name="body" aria-label="Reply" placeholder="Write a reply…" required></textarea>
                        <button class="btn primary" type="submit">Reply</button>
                    </form>
                </div>
            @else
                <div class="card empty">Select a conversation.</div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')<script>const c=document.getElementById('chat');if(c)c.scrollTop=c.scrollHeight;</script>@endpush
