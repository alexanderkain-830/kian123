@extends('layouts.app')

@section('title', 'Manage Menu - Dash Coffee')

@section('content')
@php
    $products = [];

    $ingredients = [];

    $ingredientOptions = [];
@endphp

<div class="mm" data-filter-scope>

    <div class="toolbar toolbar-wide">
        <div class="tabs" data-tabs>
            <button class="tab active" data-cat="all">All Products</button>
            <button class="tab plain" data-cat="foods">Foods</button>
            <button class="tab plain" data-cat="beverages">Beverages</button>
            <button class="tab plain" data-cat="others">Others</button>
        </div>
        <div class="toolbar-right">
            <label class="search">
                <input type="search" data-search aria-label="Search products">
                @include('partials.icon', ['n' => 'search'])
            </label>
            <button class="btn btn-green btn-sm" type="button">+ ADD PRODUCT</button>
        </div>
    </div>

    <div class="mm-body">

        <section class="panel mm-list">
            <h2 class="panel-title">Products</h2>
            @forelse ($products as [$name, $price, $img, $cat])
            <div class="list-item" data-cat="{{ $cat }}" data-text="{{ strtolower($name) }}">
                <span class="thumb">
                    @if ($img)
                    <img src="{{ $img }}" alt="">
                    @endif
                </span>
                <span class="list-item-text"><b>{{ strtoupper($name) }}</b><small>{{ number_format($price, 2) }}</small></span>
                <button class="btn btn-green btn-xs" type="button">EDIT</button>
            </div>
            @empty
            <p class="empty-row">No products yet.</p>
            @endforelse
        </section>

        <section class="panel mm-form">
            <div class="mm-form-top">
                <div class="mm-image">
                    <span class="thumb thumb-lg"></span>
                    <button class="btn btn-outline btn-xs" type="button">Change Image</button>
                    <div class="status-toggle">
                        <span>Status</span>
                        <label class="switch"><input type="checkbox" checked><i></i></label>
                        <small>Available</small>
                    </div>
                </div>
                <div class="mm-fields">
                    <label class="field-label tiny" for="p-name">Product name</label>
                    <input class="input input-sm" id="p-name" type="text">
                    <label class="field-label tiny" for="p-cat">Category</label>
                    <div class="select-wrap">
                        <select class="input input-sm" id="p-cat"><option></option><option>Foods</option><option>Beverages</option><option>Others</option></select>
                        @include('partials.icon', ['n' => 'chevron'])
                    </div>
                    <label class="field-label tiny" for="p-price">Price</label>
                    <input class="input input-sm" id="p-price" type="text">
                </div>
            </div>

            <div class="section-head">
                <h2>INGREDIENT</h2>
                <button class="btn btn-green btn-xs" type="button" data-open-modal="ingredient-modal">@include('partials.icon', ['n' => 'plus']) Add Ingredient</button>
            </div>

            <div class="table">
                <div class="table-head mm-cols"><span>#</span><span>Ingredient</span><span>Unit</span><span>Quantity</span><span>Action</span></div>
                @forelse ($ingredients as $i => [$name, $unit, $qty])
                <div class="table-row mm-cols">
                    <span class="num">{{ $i + 1 }}</span><span>{{ $name }}</span><span>{{ $unit }}</span><span>{{ $qty }}</span>
                    <button class="icon-btn" type="button" aria-label="Edit {{ $name }}">@include('partials.icon', ['n' => 'pencil'])</button>
                </div>
                @empty
                <p class="empty-row">No ingredients added yet.</p>
                @endforelse
            </div>

            <div class="btn-row">
                <button class="btn btn-red btn-sm" type="button">CANCEL</button>
                <button class="btn btn-green btn-sm" type="button">SAVE</button>
            </div>
        </section>
    </div>
</div>
@endsection

@push('modals')
<div class="modal-backdrop" id="ingredient-modal" hidden>
    <div class="modal modal-sm" role="dialog" aria-labelledby="ing-title">
        <button class="modal-x" type="button" data-close-modal aria-label="Close">@include('partials.icon', ['n' => 'close'])</button>
        <h2 class="modal-title" id="ing-title">ADD Ingredient</h2>

        <label class="field-label tiny" for="m-ing">Ingredient</label>
        <div class="select-wrap">
            <select class="input input-sm" id="m-ing">
                <option></option>
                @foreach ($ingredientOptions as $opt)
                <option>{{ $opt }}</option>
                @endforeach
            </select>
            @include('partials.icon', ['n' => 'chevron'])
        </div>
        <label class="field-label tiny" for="m-unit">Unit</label>
        <div class="select-wrap"><select class="input input-sm" id="m-unit"><option></option><option>pcs</option><option>g</option><option>kg</option><option>ml</option><option>L</option></select>@include('partials.icon', ['n' => 'chevron'])</div>
        <label class="field-label tiny" for="m-qty">Quantity</label>
        <input class="input input-sm" id="m-qty" type="text">

        <div class="btn-row btn-row-center">
            <button class="btn btn-red btn-sm" type="button" data-close-modal>Cancel</button>
            <button class="btn btn-green btn-sm" type="button" data-close-modal>Save</button>
        </div>
    </div>
</div>
@endpush
