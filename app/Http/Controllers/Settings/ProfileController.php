<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;

// Cloud Storage
use JD\Cloudder\Facades\Cloudder;

// Storage
use File;
use Storage;

// Carbon
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
        ]);

        return tap($user)->update($request->all());
    }

    /**
     * Update the user's email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateEmail(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'. $user->id,
            'current_password' => ['required', new MatchOldPassword]
        ]);
        
        if ($user->updated_at < Carbon::now()->subHours(24)) {
            return response()
                ->json(422, [
                    'message' => 'You can update after 24 hours.'
                ]);
        } else {
            return tap($user)->update($request->all());
        }
    }

    /**
     * Update user avatar
     * 
     * @param $Auth
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function updateAvatar(Request $request) {
        $user = $request->user();

        $this->validate($request, [
            'avatar' => 'required|mimes:jpg,png,jpeg,webp|between:1,6000'
        ]);

        // Cloud upload
        $image = $request->file('avatar');
        $name = $request->file('avatar')->getClientOriginalName();
        $image_name = $request->file('avatar')->getRealPath();
        Cloudder::upload($image_name, null);
        list($width, $height) = getImageSize($image_name);
        $image_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);
        $image_publicId = Cloudder::getPublicId();
        $user->avatar = $image_url;
        $user->avatar_public_id = $image_publicId;

        return tap($user)->update($request->all());

    }
}
