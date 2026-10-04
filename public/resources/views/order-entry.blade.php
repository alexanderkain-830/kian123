@extends('layouts.app')

@section('title', 'Order Entry - Dash Coffee')
@section('main-class', 'main-flush')

@section('content')
@php
    $categories = [];
@endphp

<div class="oe">

    <section class="oe-products" data-filter-scope>
        <div class="toolbar">
            <div class="tabs" data-tabs>
                <button class="tab active" data-cat="all">All Products</button>
                <button class="tab plain" data-cat="foods">Foods</button>
                <button class="tab plain" data-cat="beverages">Beverages</button>
                <button class="tab plain" data-cat="others">Others</button>
            </div>
            <label class="search">
                <input type="search" data-search aria-label="Search products">
                @include('partials.icon', ['n' => 'search'])
            </label>
        </div>

        <div class="oe-scroll">
            @foreach ($categories as [$catKey, $catTitle, $catProducts])
            <div class="cat-section" data-cat="{{ $catKey }}">
                <div class="cat-title"><span>{{ strtoupper($catTitle) }}</span><i></i></div>
                <div class="tile-grid">
                    @foreach ($catProducts as [$id, $name, $price, $img])
                    <button class="tile" data-product data-id="{{ $id }}" data-name="{{ $name }}" data-price="{{ $price }}" data-img="{{ $img }}">
                        <span class="tile-img">
                            @if ($img)
                            <img src="{{ $img }}" alt="">
                            @endif
                        </span>
                        <span class="tile-label"><b>{{ strtoupper($name) }}</b><small>{{ number_format($price, 2) }}</small></span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach

            <p class="empty-note" data-empty {{ count($categories) ? 'hidden' : '' }}>No products yet. Add them in Manage Menu.</p>
        </div>
    </section>

    <aside class="cart" id="cart">
        <div class="cart-lines" id="cart-lines"></div>

        <div class="cart-bottom">
            <div class="cart-total"><span>Total</span><strong id="cart-total">0.00</strong></div>

            <label class="field-label tiny" for="pay-method">Payment method</label>
            <div class="select-wrap">
                <select class="input input-sm" id="pay-method">
                    <option>Cash</option>
                    <option>GCash</option>
                    <option>Maya</option>
                </select>
                @include('partials.icon', ['n' => 'chevron'])
            </div>

            <div id="cash-fields">
                <label class="field-label tiny" for="received">Amount received</label>
                <input class="input input-sm input-fill" id="received" type="number" min="0" step="0.01" placeholder="0.00">
                <div class="change-row"><span>Change</span><strong id="cart-change">0.00</strong></div>
            </div>

            <div id="ref-field" hidden>
                <label class="field-label tiny" for="reference">Reference number</label>
                <input class="input input-sm input-fill" id="reference" type="text" placeholder="1224 115 4135">
            </div>

            <div class="btn-pair">
                <button class="btn btn-red" id="clear-order" type="button">Clear Order</button>
                <button class="btn btn-green" id="confirm-order" type="button">confirm Order</button>
            </div>
        </div>
    </aside>
</div>
@endsection
