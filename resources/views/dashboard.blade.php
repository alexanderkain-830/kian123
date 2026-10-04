@extends('layouts.app')

@section('title', 'Dashboard - Dash Coffee')

@section('content')
@php
    $salesTotal = 0;
    $orderCount = 0;

    $monthlyPoints = '';

    $split = [['GCash', 0, '#5b3fc4'], ['Maya', 0, '#4bb34f'], ['Cash', 0, '#111']];
    $splitTotal = array_sum(array_column($split, 1));

    $recent = [];
@endphp

<div class="dash">
    @include('partials.logo', ['class' => 'dash-logo'])

    <div class="tabs">
        <button class="tab active">Today</button>
        <button class="tab">This week</button>
        <button class="tab">This month</button>
        <button class="tab">This year</button>
    </div>

    <div class="stat-row">
        <div class="panel stat">
            <span class="stat-label">SALES</span>
            <span class="stat-value">{{ number_format($salesTotal, 2) }}</span>
        </div>
        <div class="panel stat">
            <span class="stat-label">ORDERS</span>
            <span class="stat-value">{{ $orderCount }}</span>
        </div>
    </div>

    <div class="panel chart-card">
        <span class="stat-label">MONTHLY SALES</span>
        <svg viewBox="0 0 400 70" preserveAspectRatio="none" class="line-chart" aria-label="Monthly sales">
            @if ($monthlyPoints)
            <defs><linearGradient id="area" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#46b049" stop-opacity=".25"/><stop offset="1" stop-color="#46b049" stop-opacity="0"/></linearGradient></defs>
            <polygon fill="url(#area)" points="{{ $monthlyPoints }} 400,70 0,70"/>
            <polyline fill="none" stroke="#2f7d32" stroke-width="1.5" vector-effect="non-scaling-stroke" points="{{ $monthlyPoints }}"/>
            @else
            <line x1="0" y1="62" x2="400" y2="62" stroke="#ddd" stroke-width="1" vector-effect="non-scaling-stroke"/>
            @endif
        </svg>
    </div>

    <div class="panel split-card">
        <span class="stat-label">PAYMENT SPLIT</span>
        <div class="split-bar">
            @if ($splitTotal > 0)
            @foreach ($split as [$method, $amount, $color])
            <span style="width:{{ round($amount / $splitTotal * 100) }}%; background:{{ $color }}"></span>
            @endforeach
            @else
            <span style="width:100%; background:#ddd"></span>
            @endif
        </div>
        <div class="split-labels">
            @foreach ($split as [$method, $amount, $color])
            <span style="width:{{ $splitTotal > 0 ? round($amount / $splitTotal * 100) : 33 }}%">{{ $method }}</span>
            @endforeach
        </div>
    </div>

    <div class="dash-bottom">
        <div class="panel">
            <div class="card-head"><span class="stat-label">Recent orders</span></div>
            @forelse ($recent as [$no, $time, $method, $amount])
            <div class="mini-row"><span>#{{ $no }} - {{ $time }} - {{ $method }}</span><span>{{ $amount }}</span></div>
            @empty
            <p class="empty-row">No orders yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
