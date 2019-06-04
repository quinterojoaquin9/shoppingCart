@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('products.index')}}" class="active">Shopping Cart</a></li>
                  </ol>
                </nav>
                <div class="card-body">
                @if(Session::has('success'))
                    <div class="row">
                        <div class="col">
                            <div id="charge-message" class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        </div>
                    </div>
                @endif
                @foreach($products->chunk(3) as $productChunk)
                <div class="row">
                    @foreach($productChunk as $product)
                        <div class="col-md-4">
                        <span class="badge-new"> NEW </span>
                        <figure class="card card-product">
                            <div class="img-wrap"><img src="{{ $product->imagePath }}"></div>
                            <figcaption class="info-wrap">
                                    <h3 class="title">{{ $product->title }}</h3>
                                    <p class="desc" style="font-size: small;">{{ $product->description }}</p>
                                    <div class="rating-wrap">
                                        <ul class="rating-stars">
                                            <li style="width:80%" class="stars-active"> 
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 
                                            </li>
                                        </ul>
                                        <div class="label-rating">132 reviews</div>
                                        <div class="label-rating">154 orders </div>
                                    </div> <!-- rating-wrap.// -->
                            </figcaption>
                            <div class="bottom-wrap">
                                <a href="{{ route('products.addToCart', ['id' => $product->id]) }}" class="btn btn-sm btn-primary float-right" style="color:white;">Add to Cart</a> 
                                <div class="price-wrap h5">
                                    <span class="price-new">${{ $product->price }}</span> <del class="price-old">${{ $product->oldprice }}</del>
                                </div> <!-- price-wrap.// -->
                            </div> <!-- bottom-wrap.// -->
                        </figure>
                    </div> <!-- col // -->
                    @endforeach
                </div>
            @endforeach
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
