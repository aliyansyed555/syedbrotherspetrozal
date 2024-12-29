@extends('layouts.app')

@section('main-content')
    <div class="mx-5 mt-5">
        <div class="card p-5 mb-5 d-flex">
            <h1>{{ $pump->name }} ({{ $pump->location }})</h1>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="card border">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Fuel Stock</h2>
                        <ul class="card-text list-unstyled">
                            @foreach ($stocks as $stock )
                                <li><strong>{{ $stock['fuel_type_name'] }}:</strong> {{ $stock['total_stock'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="card border">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Mobiloil Stock</h2>
                        <ul class="card-text list-unstyled">
                            @foreach ($products as $product )
                                <li><strong>{{ $product->name }}({{$product->company}}):</strong> {{ $product->quantity }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card border">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Cash in Hand</h2>
                        <ul class="card-text list-unstyled">
                            <li><strong>Total:</strong> {{ $cashInhand }}</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('javascript')

@endsection
