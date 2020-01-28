<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User\UserSearch;

use Auth;

class UserSearchController extends Controller
{
    /**
     * Display a listing of user searches
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store user search
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'search_term' => 'required'
        ]);

        if (Auth::user()) {
            $userSearch = new UserSearch($request->all());

            $request->user()
                ->searches()->save($userSearch);
        } else {
            return;
        }

        return response()
            ->json(['searched'], 200);
    }
}
