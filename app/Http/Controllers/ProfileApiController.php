<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
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
                Uses::find($user->id)->update(['status'=> env('STATUS_CV')]);

                return response()->json(['error' => false, 'message' => 'file add successful', 'eq' => $cvFile]);

            } else {
                return response()->json(['error' => true, 'message' => 'no file uploaded', 'eq' => $cvFile]);
            }
        }
        return response()->json(['error' => true, 'message' => 'user not found']);

    }

    /**
     * @param Request $request
     * @param $id
     * @return View
     */
    public function uploadCvFileWeb(Request $request, $id)
    {
        $cvFile = $this->saveFile($request);
        if ($cvFile) {
            $userModel = Employ::whereUserId($id)->first();
            $userModel->cv = $cvFile;
            $userModel->save();
            Uses::find($id)->update(['status'=> env('STATUS_CV')]);

            $message = 'file add successful';
            return view('messages', compact('message'));
        }
        $message = 'no file uploaded';
        return view('messages', compact('message'));


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
