<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class ProfileApiController extends Controller
{
    public function index($id)
    {
//        $user = User::find($id);
        return view('profile', compact('id'));
    }

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
                return response()->json(['error' => false, 'message' => 'file add successful', 'eq' => $cvFile]);

            } else {
                return response()->json(['error' => true, 'message' => 'no file uploaded', 'eq' => $cvFile]);
            }
        }
        return response()->json(['error' => true, 'message' => 'user not found']);

    }

    public function uploadCvFileWeb(Request $request, $id)
    {
        $cvFile = $this->saveFile($request);
        if ($cvFile) {
            $userModel = Employ::whereUserId($id)->first();
            $userModel->cv = $cvFile;
            $userModel->save();
            return response()->json(['error' => false, 'message' => 'file add successful', 'eq' => $cvFile]);

        } else {
            return response()->json(['error' => true, 'message' => 'no file uploaded', 'eq' => $cvFile]);
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
            $name = $random . 'cv_' . Carbon::now()->format('y-m-d') . ".pdf";
            $image->move(base_path() . '/public/cv/', $name);
            return $name = url("cv/$name");
//             $name;
        }
        return $request;
    }

    public function saveImage($request)
    {
        $random = Str::random(10);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name = $random . 'cv_' . Carbon::now()->format('y-m-d') . ".jpg";
            $image->move(base_path() . '/public/upload/image/', $name);
            $name = url("upload/image/$name");
            return $name;
        }
        return false;
    }
}
