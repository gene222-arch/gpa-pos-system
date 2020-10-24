<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartDeleteRequest;
use App\Http\Requests\CartChangeQtyRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response( $request->user()->cart()->get() );
        }
        
        return view('cart.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartStoreRequest $request)
    {   
        $barcode = $request->barcode;

        $cart = $request->user()
            ->cart()
            ->where('barcode', $barcode)
            ->first();

        if ($cart) {

            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();

        } else {

            $product = Product::where('barcode', $barcode)->first();
            $request->user()->cart()->attach($product->id, ['quantity' => 1]);
        }

        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(CartDeleteRequest $request)
    {
        $delete = $request->user()->cart()->detach($request->product_id);

        return response('', 204);
    }

    public function empty(Request $request)
    {
        $delete = $request->user()->cart()->detach();
        return response('', 204);
    }

    public function changeQty(CartChangeQtyRequest $request) 
    {

        $cart = $request->user()->cart()->where('product_id', $request->product_id)->first();
        
        if ($cart) {
            $cart->pivot->quantity = $request->quantity;
            $cart->pivot->save();
        }
        
        return response()->json([
            'success' => true
        ]);

    }

}
