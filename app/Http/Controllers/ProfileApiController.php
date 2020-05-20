<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadCvFile(Request $request)
    {

        $userId = $request->userId;
        if ($userId) {
            $cvFile = $this->saveFile($request, $userId);
            if ($cvFile) {
                $userModel = Employ::whereUserId($userId)->first();
                $userModel->cv = $cvFile;
                $userModel->save();
                User::find($userId)->update(['status' => env('STATUS_CV')]);

                return response()->json(['error' => false, 'message' => 'file add successful', 'user' => $userModel]);

            } else {
                return response()->json(['error' => true, 'message' => 'no file uploaded', 'eq' => $cvFile]);
            }
        }
        return response()->json(['error' => true, 'message' => 'user not found']);

    }

    public function uploadImage(Request $request)
    {
        $userId = $request->userId;
        if ($userId) {
            $picFile = $this->saveImage($request, $userId);
            if ($picFile) {
                $userModel = User::find($userId);
                $userModel->image = $picFile;
                if ($request->email !== $userModel->email) {
                    $userModel->email = $request->email;
                }
                $userModel->save();
                return response()->json(['error' => false, 'message' => 'file add successful', 'user' => $userModel]);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'no file uploaded']);
        }
        return response()->json(['error' => true, 'message' => 'user not found']);
    }


    public function saveFile($request, $userId)
    {
        if ($request->hasfile('cv')) {
            $image = $request->file('cv');
            $name = $userId . '_cv.' . $request->cv->extension();
            $image->move(base_path() . '/public/cv/', $name);
            return $name = url("cv/$name");
        }
        return $request;
    }

    public function saveImage($request, $userId)
    {
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name = $userId . '_pic.' . $request->image->extension();
            $image->move(base_path() . '/public/profiles/', $name);
            $name = url("profiles/$name");
            return $name;
        }
        return false;
    }
}
