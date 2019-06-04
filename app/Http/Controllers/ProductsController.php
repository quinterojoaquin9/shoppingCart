<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Products;
use App\Cart;
use App\Order;

use App\Http\Requests;
use Session;
use Auth;

use Stripe\Charge;
use Stripe\Stripe;

class ProductsController extends Controller
{
    public function getIndex()
    {
        $products = Products::all();
        return view('shop', ['products' => $products]);
    }

    public function getAddToCart(Request $request, $id)
    {
        $product = Products::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return redirect()->route('products.index');
    }

    public function getReduceByOne($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('products.shoppingCart');
    }

     public function getAddByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('products.shoppingCart');
    }

    public function getRemoveItem($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect()->route('products.shoppingCart');
    }

    public function getCart()
    {
        if (!Session::has('cart')) {
            return view('shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout()
    {
        if (!Session::has('cart')) {
            return view('shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('checkout', ['total' => $total]);
    }

    public function postCheckout(Request $request)
    {
        $validatedData = $request->validate([
              'agree' => 'required',
         ]);
        
        if (!Session::has('cart')) {
            return redirect()->route('products.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        //dd($cart);


        $idsProductos = '';
        $Products = $cart->items;
        $idUser = Auth::User()->id;

        foreach ($Products as $items) {
            if($items['item']['id'] == 3 && $cart->totalQty >= 2){
                $cart->totalPrice = $cart->totalPrice - $items['item']['price'];
            }
            $idsProductos .=  $items['item']['id']. ',';
            $validateProduct = DB::table('orders')->where([
                            ['idproducto', '=', $idsProductos],
                            ['user_id', '<>', $idUser],
                        ])->get();
        }

        //dd($cart);

        if(count($validateProduct) > 0){
            return redirect()->route('products.shoppingCart')->with('error', 'This product has already been bought by another user.');
        }

        //Stripe::setApiKey('sk_test_o7hu5f7yF0yCMD0VmcR5q1ZR008DYZKOjX');
        //dd($token = $request->stripeToken);
        try {
            /*$charge = Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Test Charge"
            ));*/

            $order = new Order();
            $order->cart = serialize($cart);
            $order->idproducto = $idsProductos;
            $order->address = $request->input('address');
            $order->name = $request->input('name');
            $order->payment_id = uniqid();
            
            Auth::User()->Orders()->save($order);
        } catch (\Exception $e) {
            return redirect()->route('products.shoppingCart')->with('error', $e->getMessage());
        }

        Session::forget('cart');
        return redirect()->route('products.index')->with('success', 'Successfully purchased products!');
    }

    
}
