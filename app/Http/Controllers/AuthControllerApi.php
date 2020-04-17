<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthControllerApi extends Controller
{
    /**
     * @var bool
     */
    public $loginAfterSignUp = true;


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
//        $validate = Validate::make($request->all(), [
//            'phone' => 'required',
//            'password' => 'required|string',
//        ]);
//
//        if ($validate->fails()) {
//            return Response()->json(['success' => false,
//                'error' => false, 'message' => $validate->messages()->first()]);
//        } else {

        $credentials = $request->only(['phone', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => 'Invalid Phone or Password',
            ], 200);
        }

        if (!empty($request->fcm_registration_id)) {
            $user = Auth::user();
            DB::table('users')
                ->where('id', $user->id)
                ->update(['fcm_registration_id' => $request->fcm_registration_id]);
        }
        //medical_director or doctors
        $user = Auth::user();
        if ($user->role == $request->role) {
            return response()->json([
                'success' => true,
                'error' => false,
                'token_type' => 'bearer',
                'token' => $token,
                'expires_in' => Auth::factory()->getTTL() * 89698,
                'user' => Auth::user(),
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => false,
            'message' => "not your app"]);
//        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {

        $status = env('STATUS_NEW');
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|unique:users|max:10',
            'password' => 'required|max:30|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->messages()->first(), "error" => true]);
        }

        $image = self::saveImage($request);
        $user = User::create([
            'phone' => $request->phone,
            'name' => $request->name,
            'status' => $status,
            'password' => $request->password,
            'fcm_registration_id' => $request->fcm_registration_id,
            'image' => $image,
            'role' => $request->role
        ]);


        return response()->json([
            'success' => true,
            'error' => false,
            'data' => $user
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function checkAuth()
    {
        try {
            $token = JWTAuth::parseToken()->authenticate();
            return response()->json(["message" => "valid token", "status" => true]);
        } catch (TokenExpiredException $e) {

            return response()->json(["message" => "token is expired", 'status' => false]);

        } catch (TokenInvalidException $e) {
            return response()->json(["message" => "token is invalid", 'status' => false]);
            // do whatever you want to do if a token is invalid

        } catch (JWTException $e) {
            return response()->json(["message" => "token is not present", 'status' => false]);
            // do whatever you want to do if a token is not present
        }
    }


    /**
     * @param int $roleId
     * @param $userID
     * @return string
     */
    public function getRoles($roleId, $userID)
    {
        $users = User::find($userID);
        $user = $users->roles->where('id', $roleId)->first();

        if (!empty($user) && $user->name === 'medical_director') {
            return 'true';
        }
        if (!empty($user) && $user->name === 'doctors') {
            return 'true';
        }
        return 'false';

    }


    public function saveImage($request)
    {
        $random = Str::random(10);
        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $name = $random . 'profile_' . self::dateNow() . ".jpg";
            $image->move(public_path() . '/upload/image/', $name);
            $name = url("upload/image/$name");
            return $name;
        }
        return url("upload/image/profile.jpg");
    }
}
