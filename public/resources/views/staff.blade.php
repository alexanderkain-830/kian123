@extends('layouts.app')

@section('title', 'Staff - Dash Coffee')

@section('content')
@php
    $staff = [];
@endphp

<div class="mm">
    <div class="toolbar toolbar-wide">
        <h2 class="panel-title no-margin">Staff</h2>
        <div class="toolbar-right">
            <label class="search">
                <input type="search" aria-label="Search staff">
                @include('partials.icon', ['n' => 'search'])
            </label>
            <a href="{{ route('create-account') }}" class="btn btn-green btn-sm">+ ADD STAFF</a>
        </div>
    </div>

    <div class="table staff-table">
        <div class="table-head staff-cols"><span>#</span><span>Name</span><span>Username</span><span>Role</span><span>Action</span></div>
        @forelse ($staff as $i => [$name, $user, $role])
        <div class="table-row staff-cols">
            <span class="num">{{ $i + 1 }}</span><span>{{ $name }}</span><span>{{ $user }}</span><span>{{ $role }}</span>
            <button class="icon-btn" type="button" aria-label="Edit {{ $name }}">@include('partials.icon', ['n' => 'pencil'])</button>
        </div>
        @empty
        <p class="empty-row">No staff accounts yet.</p>
        @endforelse
    </div>
</div>
@endsection
