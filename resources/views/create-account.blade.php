@extends('layouts.auth')

@section('title', 'Create account - Dash Coffee')
@section('card-class', 'auth-create')

@section('content')
<h1 class="auth-title">CREATE ACCOUNT</h1>
<p class="auth-sub">CREATE A BRAND NEW ACCOUNT</p>

<form onsubmit="event.preventDefault(); location.href='{{ route('login') }}'">
    <label class="field-label" for="name">Name</label>
    <input class="input" type="text" id="name" name="name" autocomplete="name">

    <label class="field-label" for="username">Username</label>
    <input class="input" type="text" id="username" name="username" autocomplete="username">

    <label class="field-label" for="email">Email</label>
    <input class="input" type="email" id="email" name="email" autocomplete="email">

    <label class="field-label" for="password">Password</label>
    <input class="input" type="password" id="password" name="password" autocomplete="new-password">

    <label class="field-label" for="password_confirmation">Confirm Password</label>
    <input class="input" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">

    <div class="auth-actions">
        <button type="submit" class="btn btn-green btn-lg">CREATE</button>
    </div>
</form>
@endsection
