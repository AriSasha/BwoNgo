{{-- $score, $max, $segments: [[from, to, tone], ...] --}}
<div class="scale">
    @foreach ($segments as [$from, $to, $tone])
        <i class="fill-{{ $tone }}" @style(['flex: '.($to - $from + 1)])></i>
    @endforeach
    <span class="pin" @style(['left: '.round($score / $max * 100, 1).'%'])></span>
</div>
<div class="scale-labels">
    <span>0</span>
    @foreach (array_slice($segments, 1) as $seg)
        <span>{{ $seg[0] }}</span>
    @endforeach
    <span>{{ $max }}</span>
</div>