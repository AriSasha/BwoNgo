<form method="POST" action="{{ route('student.referrals.store', $s) }}" class="form">
    @csrf
    <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required autocomplete="name"></div>
    <div class="field"><label for="student_number">Student number</label><input id="student_number" name="student_number" value="{{ old('student_number', auth()->user()->student_number) }}" inputmode="numeric"></div>
    <div class="field"><label for="contact">Phone or email</label><input id="contact" name="contact" value="{{ old('contact', auth()->user()->phone) }}" required placeholder="07XX XXX XXX"></div>
    <div class="field"><label for="contact_method">How should they contact you?</label>
        <select id="contact_method" name="contact_method">
            @foreach ($contactMethods as $m)<option @selected(old('contact_method') === $m)>{{ $m }}</option>@endforeach
        </select>
    </div>
    <div class="field full"><label for="preferred_time">Best time to reach you</label><input id="preferred_time" name="preferred_time" value="{{ old('preferred_time') }}" placeholder="e.g. weekdays after 4pm"></div>
    <div class="field full"><label for="note">Anything you'd like the counselor to know (optional)</label><textarea id="note" name="note">{{ old('note') }}</textarea></div>
    <label class="check full"><input type="checkbox" name="consent" value="1" @checked(old('consent'))><span>I agree that the {{ $settings['office_name'] }} may see my name, contact details and these scores, and contact me{{ $s->hasSelfHarmAnswer() ? ' as soon as possible' : '' }}.</span></label>
    @if ($errors->any())<div class="err full" role="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>@endif
    <div class="row full"><button class="btn primary" type="submit">Send referral request</button></div>
</form>
