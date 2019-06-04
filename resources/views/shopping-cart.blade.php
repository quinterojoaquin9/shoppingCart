@extends('layouts.app')

@section('title')
    Laravel Shopping Cart
@endsection


@section('extra-css')
    <style>
        .mt-32 {
            margin-top: 32px;
        }
    </style>

@endsection

@section('content')
    
    <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('products.index')}}" style="color: #007bff">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping-Cart</li>
          </ol>
        </nav>
        @if (session()->has('success_message'))
            <div class="spacer"></div>
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="spacer"></div>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('error'))
            <div class="spacer"></div>
            <div class="alert alert-danger">
                <ul>
                        <li>!! {{Session::get('error')}} !!</li>
                    
                </ul>
            </div>
        @endif
    @if(Session::has('cart'))
        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        <div class="checkout-section">
            <div>
                <form action="{{ route('checkout') }}" method="POST" id="payment-form">
                    {{ csrf_field() }}
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        @if (auth()->user())
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
                        @else
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}" required>
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode" value="{{ old('postalcode') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                    </div> <!-- end half-form -->

                    <div class="spacer"></div>

                    <h2>Payment Details</h2>

                    <div class="form-group">
                        <label for="name_on_card">Name on Card</label>
                        <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="adsfads">
                    </div>

                    <div class="form-group">
                        <label for="card-element">
                          Credit or debit card
                        </label>
                        <div id="card-element">
                          <!-- a Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <div class="spacer"></div>
                    <div class="form-group">
                        <input type="checkbox" name="agree" value="check" id="agree" /> I have read and agree to the Terms and Conditions and Privacy Policy
                        <a href="{{url('/terms') }}" role="button" class="btn btn-sm btn-primary" style="color: white;">See terms</a>
                    </div>

                    <div class="spacer"></div>

                    <a href="{{route('products.index')}}" class="btn full-width" style="background-color: #e9ecef"><span class="fa fa-arrow-left"> </span> Continue Shopping</a></a>

                    <div class="spacer"></div>

                    <button type="submit" id="complete-order" class="button-primary full-width">Complete Order</button>


                </form>

            </div>



            <div class="checkout-table-container">
                <h2>Your Order</h2>

                <div class="checkout-table">
                    @foreach ($products as $product)
                    <div class="checkout-table-row">
                        <input id="idProducto" type="text" class="hidden" value="{{ $product['item']['id'] }}">
                        <div class="checkout-table-row-left">
                            <img src="{{ $product['item']['imagePath'] }}" alt="item" class="checkout-table-img">
                            <div class="checkout-item-details">
                                <div class="checkout-table-item">{{ $product['item']['title'] }}</div>
                                <div class="checkout-table-description">{{ $product['item']['description'] }}</div>
                                <div class="checkout-table-price">$ {{ $product['item']['price'] }}</div>
                            </div>
                        </div> <!-- end checkout-table -->

                        <div class="checkout-table-row-right">
                            <div class="checkout-table-quantity">{{ $product['qty'] }}</div>
                        </div>
                    </div> <!-- end checkout-table-row -->
                    @endforeach

                </div> <!-- end checkout-table -->

                <div class="checkout-totals">
                    <div class="checkout-totals-left">
                        <span class="checkout-totals-total">Total</span>
                    </div>

                    <div class="checkout-totals-right">
                        <span class="checkout-totals-total">$ {{ $totalPrice }}</span>

                    </div>
                </div> <!-- end checkout-totals -->
            </div>

        </div> <!-- end checkout-section -->
    </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2>No Items in Cart!</h2>
            </div>
        </div>
    @endif

@endsection

@section('extra-js')
    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function(){
            // Create a Stripe client
            var stripe = Stripe('pk_test_gxxVlWJL4oW9K9AteGwq7ox800fCRyPFvy');
            // Create an instance of Elements
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
              base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                  color: '#aab7c4'
                }
              },
              invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
              }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
              var displayError = document.getElementById('card-errors');
              if (event.error) {
                displayError.textContent = event.error.message;
              } else {
                displayError.textContent = '';
              }
            });
            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
              event.preventDefault();
              // Disable the submit button to prevent repeated clicks
              document.getElementById('complete-order').disabled = true;
              var options = {
                name: document.getElementById('name_on_card').value,
                address_line1: document.getElementById('address').value,
                address_city: document.getElementById('city').value,
                address_state: document.getElementById('province').value,
                address_zip: document.getElementById('postalcode').value
              }
              stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                  // Inform the user if there was an error
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;
                  // Enable the submit button
                  document.getElementById('complete-order').disabled = false;
                } else {
                  // Send the token to your server
                  stripeTokenHandler(result.token);
                }
              });
            });
            function stripeTokenHandler(token) {
              // Insert the token ID into the form so it gets submitted to the server
              var form = document.getElementById('payment-form');
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'stripeToken');
              hiddenInput.setAttribute('value', token.id);
              form.appendChild(hiddenInput);
              // Submit the form
              form.submit();
            }
        })();
    </script>
