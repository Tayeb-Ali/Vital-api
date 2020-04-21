<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfileApiController extends Controller
{

    public function checkUser()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json(['status' => true, 'user' => $user]);
        }
        return response()->json(['status' => false]);
    }

    public function updateFCM(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $userModel = User::find($user->id)->first();
            $userModel->fcm_registration_id = $request->fcm_registration_id;
            $userModel->save();
            return response()->json(['status' => true, 'user' => $userModel]);
        }
        return response()->json(['status' => false]);
    }

    public function uploadCvFile(Request $request)
    {
        $cvFile = $this->saveFile($request);
        $user = Auth::user();
        if ($user) {
            if ($cvFile) {
                $userModel = Employ::whereUserId($user->id)->first();
                $userModel->cv = $cvFile;
                $userModel->save();
                return response()->json(['error' => false, 'message' => 'file add successful']);

            } else {
                return response()->json(['error' => true, 'message' => 'no file uploaded']);
            }
        }
        return response()->json(['error' => true, 'message' => 'user not found']);

    }

    public function uploadImage(Request $request)
    {
        $cvFile = $this->saveFile($request);
        $user = Auth::user();
        if ($user) {
            if ($cvFile) {
                $userModel = User::find($user->id)->first();
                $userModel->cv = $cvFile;
                $userModel->save();
                return response()->json(['error' => false, 'message' => 'file add successful']);

            } else {
                return response()->json(['error' => true, 'message' => 'no file uploaded']);
            }
        }
        return response()->json(['error' => true, 'message' => 'user not found']);

    }


    public function saveFile($request)
    {
        $random = Str::random(10);
        if ($request->hasfile('cv')) {
            $image = $request->file('cv');
            $name = $random . 'cv_' . self::dateNow() . ".pdf";
            $image->move(public_path() . '/cv/', $name);
            $name = url("cv/$name");
            return $name;
        }
        return $request;
    }

    public function saveImage($request)
    {
        $random = Str::random(10);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name = $random . 'cv_' . self::dateNow() . ".jpg";
            $image->move(public_path() . '/upload/image/', $name);
            $name = url("upload/image/$name");
            return $name;
        }
        return false;
    }
}
