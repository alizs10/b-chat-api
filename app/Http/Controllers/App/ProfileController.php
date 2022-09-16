<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ProfileInfoRequest;
use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // avatar : update and delete

    public function updateAvatar(Request $request, ImageService $imageService)
    {
        $request->validate([
            'profile_photo' => 'required|file|max:2000|mimes:jpg,jpeg,png,webp'
        ]);
        $user = Auth::user();
        $inputs = $request->all();

        if ($request->hasFile('profile_photo')) {
            if (!empty($user->profile_photo)) {
                $imageService->deleteImage(public_path(DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $user->profile_photo));
            }

            $imageService->setExclusiveDirectory('user' . DIRECTORY_SEPARATOR . 'avatar');
            $result = $imageService->save($request->file('profile_photo'));


            if (!$result) {

                return response()->json([
                    'user' => $user,
                    'status' => false,
                ]);
            }

            $inputs['profile_photo'] = $result;
        }

        $user->update($inputs);

        return response()->json([
            'user' => $user,
            'status' => true,
        ]);
    }

    public function deleteAvatar(ImageService $imageService)
    {
        $user = Auth::user();
        if (!empty($user->profile_photo)) {
            $imageService->deleteImage(public_path(DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . $user->profile_photo));
            $user->update([
                'profile_photo' => null
            ]);
        }

        return response()->json([
            'user' => $user,
            'status' => true,
            'path' => public_path()
        ]);
    }

    // bio: update

    public function updateBio(Request $request)
    {
        $request->validate([
            'bio' => "required|string|max:255"
        ]);

        $user = Auth::user();
        $updatable = $request->all();
        $user->update($updatable);


        return response()->json([
            'user' => $user,
            'status' => true,
        ]);
    }

    // personal information: update

    public function updateInfo(ProfileInfoRequest $request)
    {
        $updatable = $request->all();
        $user = Auth::user();
        if ($user->email !== $updatable['email']) {
            $updatable['email_verified_at'] = null;
        }

        $user->update($updatable);

        return response()->json([
            'user' => $user,
            'status' => true,
        ]);
    }

    // delete account

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);
        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => "password is invalid",
                'status' => false,
            ]);
        }

        $user->update([
            "username" => null,
            "email" => null,
            "password" => null,
            "name" => "Deleted Account",
            "bio" => null,
            "profile_photo" => null,
            "user_status" => 0,
        ]);

        return response()->json([
            'message' => "account deleted successfully",
            'status' => true,
        ]);
    }
}
