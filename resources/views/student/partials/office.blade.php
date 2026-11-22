@php($o = \App\Models\Setting::values())
@php($bits = array_filter(['Where' => $o['office_location'], 'Hours' => $o['office_hours'], 'Phone' => $o['office_phone'], 'Email' => $o['office_email']]))
@if ($bits)
    <p class="small">@foreach ($bits as $k => $v)<b>{{ $k }}:</b> {{ $v }}@if(!$loop->last) · @endif @endforeach</p>
@endif
