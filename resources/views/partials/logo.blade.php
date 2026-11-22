{{-- Put the MUBS logo at public/images/mubs-logo.png (or .svg) and it appears here automatically. --}}
@php($logo = collect(['images/mubs-logo.svg', 'images/mubs-logo.png'])->first(fn ($p) => file_exists(public_path($p))))
@if ($logo)
    <img src="{{ asset($logo) }}" alt="Makerere University Business School logo" class="{{ $class ?? '' }}">
@endif
