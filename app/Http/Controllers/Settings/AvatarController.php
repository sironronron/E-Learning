<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JD\Cloudder\Facades\Cloudder;


class AvatarController extends Controller
{
    public function update(Request $request) {
        $user = $request->user();

        $this->validate($request, [
            'image_name' => 'required|mimes:jpg,png,jpeg|between:1,6000'
        ]);

        $image = $request->file('image_name');
        $name = $request->file('image_name')->getClientOriginalName();
        $image_name = $request->file('image_name')->getRealPath();
        Cloudder::upload($image_name, null);
        list($width, $height) = getImageSize($image_name);
        $image_url = Cloudder::show(Cloudder::getPublicId(), ['width' => $width, 'height' => $height]);

        $user->avatar = $image_url;
        $user->save();
        // Save to uploads directory
        $image->move(public_path('uploads'), $name);

        return response()
            ->json([
                'success' => true,
                'message' => 'Avatar changed' 
            ]);

    }
}
