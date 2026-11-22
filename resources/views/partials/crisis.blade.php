@php($settings = \App\Models\Setting::values())
<section class="safety" @isset($id) id="{{ $id }}" @endisset @if(!empty($hidden)) hidden @endif aria-label="Support right now">
    <h3>{{ $heading ?? 'Please reach out today' }}</h3>
    <p>You said you've had thoughts of being better off dead or of hurting yourself. Those thoughts deserve support from a real person, today. If you might act on them, call emergency services or go to the nearest hospital now.</p>
    <div class="lines">
        @foreach (\App\Support\Screening::CRISIS_LINES as $line)
            <div class="line"><b>{{ $line['number'] }}</b><span>{{ $line['name'] }}</span><span>{{ $line['hours'] }}</span></div>
        @endforeach
        @if ($settings['office_phone'])
            <div class="line"><b>{{ $settings['office_phone'] }}</b><span>{{ $settings['office_name'] }}</span><span>{{ $settings['office_hours'] }}</span></div>
        @endif
    </div>
    <p class="small">You can also tell a friend, roommate, warden or lecturer you trust and ask them to stay with you.</p>
</section>
