<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required|confirmed|min:8',
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);
    }
}
