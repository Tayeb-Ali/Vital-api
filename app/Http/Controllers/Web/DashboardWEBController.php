<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\EmergencyServiced;
use App\Models\RequestSpecialists;
use App\User;
use Carbon\Carbon;

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
        $requests = RequestSpecialists::all()->count();
        $doctor = User::whereRole(4)->count();
        $provider = User::whereRole(3)->count();
        $userCount = User::all()->count();
        $pharmacists = User::whereRole(5)->count();

//        $record = RequestSpecialists::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
////            ->where('created_at', '>', Carbon::today()->subDay(6))
//            ->groupBy('day_name','day')
//            ->orderBy('day')
//            ->get();

//        $data = [];

//        foreach($record as $row) {
//            $data['label'][] = $row->day_name;
//            $data['data'][] = (int) $row->count;
//        }

//        $chart_data = json_encode($data);

//        $users = User::orderBy('created_at', 'desc')
//            ->paginate(20);
//        $dataSet = [0, 9000, 5000, 40000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000];
//        $dataSet= json_encode($dataSet);

        return view('dashboard.index', compact([
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
