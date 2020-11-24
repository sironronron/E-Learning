<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Cart
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;

// User
use Auth;

// Course
use App\Models\Course\Course;

class CartController extends Controller
{
    /**
     * Middleware
     */
    public function __construct()
    {
        return $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all carts
        $carts = Cart::where('user_id', Auth::user()->id)
            ->get();

        return response()
            ->json([
                'carts' => $carts
            ]);
    }

    /**
     * Show the form for creating carts
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store the cart
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        if (Auth::user()->cart) {
            $cart = Cart::where('user_id', Auth::user()->id)
            ->firstOrFail();
        } else {
            $cart = new Cart();
            $cart->user_id = Auth::user()->id;
            $cart->save();
        }

        $cartItem = new CartItem();

        $cartItem->cart_id = $cart->id;
        $cartItem->course_id = $request->course_id;
        $cartItem->price = $request->price;

        $cartItem->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $cartItem->id,
                'message' => "Course is added to your cart."
            ]);
    }

    /**
     * Display the specified resource
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // --
    }

    /**
     * Show the form for editing the specified resource
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // --
    }

    /**
     * Edit the Resource
     * 
     * @param  int $id
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        // --
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
