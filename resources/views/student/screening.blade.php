@extends('layouts.app')
@section('title', \App\Support\Screening::KINDS[$kind])
@php($S = \App\Support\Screening::class)
@section('content')
<form method="POST" action="{{ route('student.screenings.store') }}" id="checkin" class="narrow stack">
    @csrf
    <input type="hidden" name="kind" value="{{ $kind }}">
    <div>
        <p class="eyebrow">{{ $S::KINDS[$kind] }}</p>
        <h2>{{ $S::STEM }}</h2>
    </div>
    <div class="progress"><div class="bar"><i></i></div><p class="small muted" id="progress-label"></p></div>
    @if ($errors->any())<div class="alert" role="alert">Please answer every question before seeing your results.</div>@endif

    @if ($S::includesPhq9($kind))
        <div class="section-head"><h3>Mood</h3><span class="small muted">PHQ-9</span></div>
        @foreach ($S::PHQ9 as $i => $q)
            @include('student.partials.question', ['name' => "phq9[$i]", 'n' => $i + 1, 'text' => $q, 'labels' => $S::OPTIONS, 'old' => old("phq9.$i")])
            @if ($i === 8)
                @include('partials.crisis', ['id' => 'crisis-inline', 'hidden' => old('phq9.8', '0') === '0', 'heading' => "Thank you for telling us. You don't have to carry this alone."])
            @endif
        @endforeach
        @include('student.partials.question', ['name' => 'difficulty', 'n' => 10, 'text' => $S::DIFFICULTY_QUESTION, 'labels' => $S::DIFFICULTY, 'old' => old('difficulty'), 'unscored' => true])
    @endif

    @if ($S::includesGad7($kind))
        <div class="section-head"><h3>Anxiety</h3><span class="small muted">GAD-7</span></div>
        @foreach ($S::GAD7 as $i => $q)
            @include('student.partials.question', ['name' => "gad7[$i]", 'n' => $i + 1, 'text' => $q, 'labels' => $S::OPTIONS, 'old' => old("gad7.$i")])
        @endforeach
    @endif

    @include('partials.disclaimer')
    <div class="row"><button class="btn primary" type="submit">See my results</button><a class="btn ghost" href="{{ route('student.home') }}">Cancel</a></div>
</form>
@endsection
@push('scripts')<script src="{{ asset('js/checkin.js') }}"></script>@endpush
