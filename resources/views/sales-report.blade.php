@extends('layouts.app')

@section('title', 'Sales Report - Dash Coffee')

@section('content')
@php
    $salesTotal = 0;
    $orderCount = 0;
    $chart = [];
    $chartMax = max(array_merge([0], array_column($chart, 1)));
    $orders = [];
@endphp

<div class="sr">

    <div class="sr-left">
        <div class="tabs">
            <button class="tab active">Today</button>
            <button class="tab">This week</button>
            <button class="tab">This month</button>
            <button class="tab">This year</button>
        </div>

        <input class="input custom-date" type="text" placeholder="CUSTOM DATE" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">

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

        <div class="panel chart-panel">
            <div class="chart-head">
                <span class="stat-label">SALES GRAPH</span>
                <span class="chart-sub">Amount per period</span>
            </div>

            @if ($chartMax > 0)
            <div class="bar-chart">
                @foreach ($chart as [$label, $amount])
                <div class="bar-col" title="{{ $label }}: {{ number_format($amount, 2) }}">
                    <div class="bar-track"><span class="bar" data-value="{{ number_format($amount, 0) }}" style="height: {{ round($amount / $chartMax * 100) }}%"></span></div>
                    <span class="bar-label">{{ $label }}</span>
                </div>
                @endforeach
            </div>
            @else
            <div class="chart-empty">No sales data yet.</div>
            @endif
        </div>
    </div>

    <div class="panel orders-panel">
        <h2 class="list-title">TODAY'S ORDER</h2>
        <div class="order-list">
            @forelse ($orders as $no => $o)
            <div class="order-row">
                <div>
                    <b>#{{ $no }}</b>
                    <small>{{ $o['time'] }} - {{ strtoupper($o['method']) }}</small>
                </div>
                <span class="order-amount">{{ fmod($o['total'], 1) == 0 ? number_format($o['total'], 0) : number_format($o['total'], 2) }}</span>
                <button class="icon-btn" type="button" data-order="{{ $no }}" aria-label="View order {{ $no }}">@include('partials.icon', ['n' => 'receipt'])</button>
            </div>
            @empty
            <p class="empty-row">No orders yet.</p>
            @endforelse
        </div>

        <button class="btn btn-green btn-block" type="button">View all orders</button>
        <button class="btn btn-green btn-block" type="button" onclick="window.print()">PRINT REPORT</button>
    </div>
</div>
@endsection

@push('modals')
<div class="modal-backdrop" id="order-modal" hidden>
    <div class="modal" role="dialog" aria-labelledby="order-title">
        <button class="modal-x" type="button" data-close-modal aria-label="Close">@include('partials.icon', ['n' => 'close'])</button>
        <h2 class="modal-title" id="order-title"></h2>
        <p class="modal-sub" id="order-sub"></p>
        <div class="receipt" id="order-lines"></div>
        <div class="receipt-total"><span>Total</span><span id="order-total"></span></div>
        <div class="btn-row btn-row-center">
            <button class="btn btn-red btn-sm" type="button" data-open-void>Void order</button>
            <button class="btn btn-green btn-sm" type="button" onclick="window.print()">Print</button>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="void-modal" hidden>
    <div class="modal" role="dialog" aria-labelledby="void-title">
        <h2 class="modal-title" id="void-title"></h2>
        <p class="modal-sub" id="void-sub"></p>
        <label class="field-label tiny" for="void-reason">void reason (required to void)</label>
        <input class="input input-sm" id="void-reason" type="text" placeholder="Wrong item">
        <div class="btn-row btn-row-center">
            <button class="btn btn-red btn-sm" type="button" data-close-modal>cancel</button>
            <button class="btn btn-green btn-sm" type="button" data-close-modal>Void order</button>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    window.DASH_ORDERS = @json($orders);
</script>
@endpush
