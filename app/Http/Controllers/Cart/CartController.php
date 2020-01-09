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
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all carts
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
        $this->validate($request, [
            'price' => 'required'
        ]);

        $cartItem = new CartItem();

        $cart = new Cart();


        $alreadyExists = CartItem::where('course_id', $request->course_id)
            ->first();

        if (!$alreadyExists) {
            $request->user()
            ->cart()->save($cart);

            $cartItem->cart_id = $cart->id;
            $cartItem->course_id = $request->course_id;
            $cartItem->price = $request->price;

            $cartItem->save();
        } else {
            return response()
                ->json([
                    'saved' => false,
                    'message' => 'Course is already in your cart.'
                ], 422);
        }

        return response()
            ->json([
                'saved' => true,
                'id' => $cart->id,
                'message' => 'Item added to cart'
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
