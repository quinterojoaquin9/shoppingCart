@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('products.index')}}" style="color: #007bff">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                  </ol>
                </nav>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($orders) > 0)
                    <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1>User Profile</h1>
                        <hr>
                        <h2>My Orders</h2>

                        @foreach($orders as $order)
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        @foreach($order->cart->items as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div class="img-wrap"><img src="{{ $item['item']['imagePath'] }}" style="max-height: 50px;"></div> {{ $item['item']['title'] }} | {{ $item['qty'] }} Units
                                                <span class="badge badge-primary badge-pill pull-right">${{ $item['price'] }}</span>
                                              </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="panel-footer">
                                    <strong>Total Price: ${{ $order->cart->totalPrice }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                            <h2>No Items!</h2>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
