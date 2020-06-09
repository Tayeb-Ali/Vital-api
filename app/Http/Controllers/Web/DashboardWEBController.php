<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\EmergencyServiced;
use App\Models\RequestSpecialists;
use App\User;

/**
 * Class DashboardWEBController
 * @package App\Http\Controllers\API
 */
class DashboardWEBController extends AppBaseController
{


    /**
     * Display a listing of the AcceptRequestSpecialists.
     * GET|HEAD /acceptRequestSpecialists
     */
    public function index()
    {
//        return [
//            'data' =>
//         $data = [
//             $this->users(),
////            'medicalRequest' => $this->medicalRequests(),
////            'emergency' => $this->emergencyRequests()
////            ]
//        ];
        $requests = RequestSpecialists::all()->count();
        $doctor = User::whereRole(4)->count();
        $provider = User::whereRole(3)->count();
        $userCount = User::all()->count();
        $pharmacists = User::whereRole(5)->count();


        $users = User::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.index', compact([
            'users',
            'userCount',
            'provider',
            'doctor',
            'pharmacists',
            'requests']));
    }

    private function users()
    {
        $users = User::all()->count();
        $doctor = User::whereRole(4)->count();
        $pharmacists = User::whereRole(5)->count();
        $nurse = User::whereRole(6)->count();
        $other = User::whereRole(7)->count();
        return [
            'user' => $users,
            'doctor' => $doctor,
            'pharmacists' => $pharmacists,
            'nurse' => $nurse,
            'other' => $other
        ];
    }

    private function medicalRequests()
    {
        $new_request = RequestSpecialists::whereStatus(1)->count();
        $accept_request = RequestSpecialists::whereStatus([2, 3])->count();
        $completed_requests = RequestSpecialists::whereStatus(6)->count();
        return [
            'new_request' => $new_request,
            'accept_request' => $accept_request,
            'completed_requests' => $completed_requests
        ];
    }

    private function emergencyRequests()
    {
        return ['emergency' => EmergencyServiced::all()->count()];
    }
}
