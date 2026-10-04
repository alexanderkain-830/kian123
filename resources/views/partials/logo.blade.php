@php
    $logoFile = 'logo-default.svg';
    foreach (['svg', 'webp', 'jpeg', 'jpg', 'png'] as $ext) {
        if (file_exists(public_path('img/logo.' . $ext))) {
            $logoFile = 'logo.' . $ext;
        }
    }
@endphp
<img class="{{ $class }}" src="{{ asset('img/' . $logoFile) }}" alt="Dash Coffee">
