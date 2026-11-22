@extends('layouts.app')
@section('title', 'Referrals')
@php($tone = ['urgent' => 'high', 'high' => 'warn', 'routine' => 'neutral'])
@section('content')
<div class="stack">
    <div class="row between">
        <h2>Referrals</h2>
        <nav class="filters" aria-label="Filter by status">
            <a href="?status=open" class="{{ $filter === 'open' ? 'on' : '' }}">Open {{ $openCount }}</a>
            @foreach (\App\Models\Referral::STATUSES as $k => $label)
                <a href="?status={{ $k }}" class="{{ $filter === $k ? 'on' : '' }}">{{ $label }} {{ $counts[$k] ?? 0 }}</a>
            @endforeach
            <a href="?status=all" class="{{ $filter === 'all' ? 'on' : '' }}">All {{ $allCount }}</a>
        </nav>
    </div>
    @if ($referrals->isEmpty())
        <div class="card empty">{{ $allCount ? 'No referrals match this filter.' : 'No referrals yet. When a student asks to be contacted, their request appears here with their scores and contact details.' }}</div>
    @else
        <div class="card scroll-x" style="padding:0">
            <table class="data">
                <thead><tr><th>Priority</th><th>Student</th><th>Ticket</th><th>PHQ-9</th><th>GAD-7</th><th>Sent</th><th>Status</th></tr></thead>
                <tbody>
                @foreach ($referrals as $r)
                    <tr>
                        <td><span class="chip bg-{{ $tone[$r->urgency] }}">{{ ucfirst($r->urgency) }}</span></td>
                        <td><a href="{{ route('office.referrals.show', $r) }}"><b>{{ $r->full_name }}</b></a><br><span class="small muted">{{ $r->student_number }}</span></td>
                        <td><code>{{ $r->ticket }}</code></td>
                        <td>{{ $r->screening->phq9_score ?? '·' }}</td>
                        <td>{{ $r->screening->gad7_score ?? '·' }}</td>
                        <td>{{ $r->created_at->diffForHumans() }}</td>
                        <td>{{ $r->statusLabel() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($referrals->hasPages())
            <div class="pagination">
                @if ($referrals->previousPageUrl())<a class="btn" href="{{ $referrals->previousPageUrl() }}">Newer</a>@endif
                @if ($referrals->nextPageUrl())<a class="btn" href="{{ $referrals->nextPageUrl() }}">Older</a>@endif
            </div>
        @endif
    @endif
</div>
@endsection
