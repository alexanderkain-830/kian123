@extends('layouts.auth')

@section('title', 'Log in - Dash Coffee')
@section('card-class', 'auth-login')

@section('content')
<p class="auth-title-small">Log in to dash coffee</p>

<form onsubmit="event.preventDefault(); location.href='{{ route('dashboard') }}'">
    <label class="field-label small" for="email">Email</label>
    <input class="input" type="email" id="email" name="email" autocomplete="email">

    <label class="field-label small" for="password">Password</label>
    <input class="input" type="password" id="password" name="password" autocomplete="current-password">

    <div class="auth-actions">
        <button type="submit" class="btn btn-green">Log in</button>
    </div>
</form>
@endsection
