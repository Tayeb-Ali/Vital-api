<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
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
        return [
            'data' => [
                'users' => $this->users(),
                'medicalRequest' => $this->medicalRequests()
            ]
        ];
    }

    private function users()
    {
        $admin_user = User::whereRole(4)->count();
        $doctor = User::whereRole(4)->count();
        $pharmacists = User::whereRole(5)->count();
        $nurse = User::whereRole(6)->count();
        $other = User::whereRole(7)->count();
        return [
            'admin_user' => $admin_user,
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

    }
}
