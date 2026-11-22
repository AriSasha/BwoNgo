<fieldset class="q">
    <legend><span>{{ $n }}.</span>{{ $text }}</legend>
    <div class="opts">
        @foreach ($labels as $v => $label)
            <label class="opt">
                <input type="radio" name="{{ $name }}" value="{{ $v }}" @checked((string) $old === (string) $v) @if(empty($unscored)) required @endif>
                <span>{{ $label }}@if(empty($unscored))<small>{{ $v }} {{ $v === 1 ? 'point' : 'points' }}</small>@endif</span>
            </label>
        @endforeach
    </div>
</fieldset>
