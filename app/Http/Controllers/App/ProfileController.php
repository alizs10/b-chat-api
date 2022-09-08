<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ProfileRequest;
use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(ProfileRequest $request, ImageService $imageService)
    {
        $user = Auth::user();
        $inputs = $request->all();

        if ($request->hasFile('profile_photo')) {
            if (!empty($user->profile_photo)) {
                $imageService->deleteImage($user->profile_photo);
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

    public function deleteAvatar(Request $request, ImageService $imageService)
    {
        $user = Auth::user();
        if(!empty($user->profile_photo)) {
            $imageService->deleteImage($user->profile_photo);
            $user->update([
                'profile_photo' => null
            ]);
        }      

        return response()->json([
            'user' => $user,
            'status' => true,
        ]);
    }
}
