@extends('layouts.app')

@section('title', 'Inventory - Dash Coffee')

@section('content')
@php
    $items = [];
@endphp

<div class="inv" data-filter-scope>

    <section class="inv-main">
        <div class="toolbar">
            <label class="search search-wide">
                <input type="search" data-search aria-label="Search ingredients">
                @include('partials.icon', ['n' => 'search'])
            </label>
        </div>

        <div class="tabs" data-tabs>
            <button class="tab active" data-cat="all">All Products</button>
            <button class="tab plain" data-cat="foods">Foods</button>
            <button class="tab plain" data-cat="beverages">Beverages</button>
            <button class="tab plain" data-cat="others">Others</button>
        </div>

        <div class="table inv-table">
            <div class="table-head inv-cols"><span>#</span><span>Ingredient</span><span>Unit</span><span>Quantity</span><span>Action</span></div>
            @forelse ($items as $i => [$name, $unit, $qty, $cat])
            <div class="table-row inv-cols" data-cat="{{ $cat }}" data-text="{{ strtolower($name) }}">
                <span class="num">{{ $i + 1 }}</span><span>{{ $name }}</span><span>{{ $unit }}</span><span>{{ $qty }}</span>
                <button class="icon-btn" type="button" data-pick="{{ $name }}|{{ $qty }} {{ $unit }}|{{ ucfirst(rtrim($cat, 's')) }}" aria-label="Update {{ $name }}">@include('partials.icon', ['n' => 'pencil'])</button>
            </div>
            @empty
            <p class="empty-row">No ingredients yet. Add one using the form on the right.</p>
            @endforelse
        </div>

    </section>

    <section class="panel side-card">
        <h2 class="side-title">Update stock</h2>
        <div class="chip" id="stock-chip"><b>No ingredient selected</b><small>Click a pencil in the table</small></div>
        <label class="field-label tiny" for="stock-qty">Quantity (pcs)</label>
        <input class="input qty-input" id="stock-qty" type="number" step="0.1" placeholder="0.0">
        <div class="btn-pair soft">
            <button class="btn btn-soft" type="button">+ ADD</button>
            <button class="btn btn-soft" type="button">- DEDUCT</button>
        </div>
        <div class="btn-row btn-row-center side-bottom">
            <button class="btn btn-red btn-sm" type="button">Cancel</button>
            <button class="btn btn-green btn-sm" type="button">Save</button>
        </div>
    </section>

    <section class="panel side-card">
        <h2 class="side-title">ADD Ingredient</h2>
        <label class="field-label tiny" for="n-name">Ingredient name</label>
        <input class="input input-sm" id="n-name" type="text">
        <label class="field-label tiny" for="n-unit">Unit</label>
        <div class="select-wrap"><select class="input input-sm" id="n-unit"><option></option><option>pcs</option><option>g</option><option>kg</option><option>ml</option><option>L</option></select>@include('partials.icon', ['n' => 'chevron'])</div>
        <label class="field-label tiny" for="n-init">Initial stock</label>
        <input class="input input-sm" id="n-init" type="text">
        <label class="field-label tiny" for="n-low">Low stock levels</label>
        <input class="input input-sm" id="n-low" type="text">
        <div class="btn-row btn-row-center side-bottom">
            <button class="btn btn-red btn-sm" type="button">Cancel</button>
            <button class="btn btn-green btn-sm" type="button">Save</button>
        </div>
    </section>
</div>
@endsection
