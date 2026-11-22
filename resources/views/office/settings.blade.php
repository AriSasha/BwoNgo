@extends('layouts.app')
@section('title', 'Settings')
@section('content')
<div class="narrow stack">
    <div><h2>Settings</h2><p class="muted">Office details appear to students on their results and referral confirmation.</p></div>
    @if ($errors->any())<div class="alert" role="alert">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>@endif
    <form method="POST" action="{{ route('office.settings.update') }}" class="card form">
        @csrf @method('PUT')
        <div class="field full"><label for="office_name">Office name</label><input id="office_name" name="office_name" value="{{ old('office_name', $settings['office_name']) }}" required></div>
        <div class="field"><label for="office_location">Location</label><input id="office_location" name="office_location" value="{{ old('office_location', $settings['office_location']) }}" placeholder="e.g. Main Building, Room 12"></div>
        <div class="field"><label for="office_hours">Opening hours</label><input id="office_hours" name="office_hours" value="{{ old('office_hours', $settings['office_hours']) }}" placeholder="e.g. Mon to Fri, 8am to 5pm"></div>
        <div class="field"><label for="office_phone">Office phone</label><input id="office_phone" name="office_phone" value="{{ old('office_phone', $settings['office_phone']) }}"></div>
        <div class="field"><label for="office_email">Office email</label><input id="office_email" name="office_email" type="email" value="{{ old('office_email', $settings['office_email']) }}"></div>
        <div class="field"><label for="phq9_threshold">Refer at PHQ-9 score of</label><input id="phq9_threshold" name="phq9_threshold" type="number" min="1" max="27" value="{{ old('phq9_threshold', $settings['phq9_threshold']) }}"></div>
        <div class="field"><label for="gad7_threshold">Refer at GAD-7 score of</label><input id="gad7_threshold" name="gad7_threshold" type="number" min="1" max="21" value="{{ old('gad7_threshold', $settings['gad7_threshold']) }}"></div>
        <p class="small muted full">10 is the usual cut-off for moderate symptoms on both scales. Any answer above zero on PHQ-9 question 9 always shows crisis contacts and the referral form.</p>
        <div class="field full">
            <label>Self-help ideas shown below the referral level</label>
            <p class="small muted">Leave a row empty to remove it.</p>
            @foreach ($resources->concat([null, null]) as $i => $res)
                <div class="resrow field">
                    <input name="resources[{{ $i }}][title]" value="{{ $res?->title }}" aria-label="Title {{ $i + 1 }}" placeholder="Title">
                    <textarea name="resources[{{ $i }}][body]" aria-label="Text {{ $i + 1 }}" placeholder="Short tip" style="min-height:44px">{{ $res?->body }}</textarea>
                </div>
            @endforeach
        </div>
        <div class="row full"><button class="btn primary" type="submit">Save settings</button></div>
    </form>

    <section class="card stack">
        <h3>Counseling staff</h3>
        <div class="scroll-x"><table class="data">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th></tr></thead>
            <tbody>@foreach ($staff as $u)<tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ ucfirst($u->role) }}</td></tr>@endforeach</tbody>
        </table></div>
        <form method="POST" action="{{ route('office.settings.staff') }}" class="form">
            @csrf
            <div class="field"><label for="s_name">Name</label><input id="s_name" name="name" required></div>
            <div class="field"><label for="s_email">Email</label><input id="s_email" name="email" type="email" required></div>
            <div class="field"><label for="s_role">Role</label><select id="s_role" name="role"><option value="counselor">Counselor</option><option value="admin">Admin</option></select></div>
            <div class="field"><label for="s_password">Temporary password</label><input id="s_password" name="password" type="text" required minlength="8"></div>
            <div class="row full"><button class="btn" type="submit">Add staff account</button></div>
        </form>
    </section>
</div>
@endsection
