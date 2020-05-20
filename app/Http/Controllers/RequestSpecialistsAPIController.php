<?php

namespace App\Http\Controllers;

use App\Models\RequestSpecialists;
use App\Models\Wallet;
use App\Repositories\RequestSpecialistsRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RequestSpecialistsController
 * @package App\Http\Controllers\API
 */
class RequestSpecialistsAPIController extends AppBaseController
{
    /** @var  RequestSpecialistsRepository */
    private $requestSpecialistsRepository;

    public function __construct(RequestSpecialistsRepository $requestSpecialistsRepo)
    {
        $this->requestSpecialistsRepository = $requestSpecialistsRepo;
    }

    /**
     * Display a listing of the RequestSpecialists.
     * GET|HEAD /requestSpecialists
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return $this->requestSpecialistsRepository
            ->WhereWithPaginate('status', 1, 20, ['specialties.medical', 'user', 'acceptRequest.doctor.employ']);
    }

    /**
     * Store a newly created RequestSpecialists in storage.
     * POST /requestSpecialists
     *
     *  * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $requestSpecialists = $this->requestSpecialistsRepository->createApi($input);
        if ($requestSpecialists) {
            $user = Auth::user();
            if ($user) {
                $wallet = Wallet::where('user_id', $user->id)->first();
                $wallet->balance = $wallet->balance - env('REQUEST_POINT');
                $wallet->save();
            }
            $requestSpecialistsModle = new  RequestSpecialists();
            $requestSpecialistsModle->users_notfication($request->medical_id, $requestSpecialists);
            return $this->sendResponse($requestSpecialists->toArray(), 'Request Specialists saved successfully');
        }
    }

    /**
     * Display the specified RequestSpecialists.
     * GET|HEAD /requestSpecialists/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RequestSpecialists $requestSpecialists */
        $requestSpecialists = $this->requestSpecialistsRepository->findWith($id, ['specialties.medical', 'user', 'acceptRequest.doctor.employ.specialty']);

        if (empty($requestSpecialists)) {
            return $this->sendError('Request Specialists not found');
        }

        return $this->sendResponse($requestSpecialists->toArray(), 'Request Specialists retrieved successfully');
    }

    /**
     * Update the specified RequestSpecialists in storage.
     * PUT/PATCH /requestSpecialists/{id}
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var RequestSpecialists $requestSpecialists */
        $requestSpecialists = $this->requestSpecialistsRepository->find($id);

        if (empty($requestSpecialists)) {
            return $this->sendError('Request Specialists not found');
        }

        $requestSpecialists = $this->requestSpecialistsRepository->update($input, $id);

        return $this->sendResponse($requestSpecialists->toArray(), 'RequestSpecialists updated successfully');
    }

    /**
     * Remove the specified RequestSpecialists from storage.
     * DELETE /requestSpecialists/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws Exception
     *
     */
    public function destroy($id)
    {
        /** @var RequestSpecialists $requestSpecialists */
        $requestSpecialists = $this->requestSpecialistsRepository->find($id);

        if (empty($requestSpecialists)) {
            return $this->sendError('Request Specialists not found');
        }

        $requestSpecialists->delete();

        return $this->sendSuccess('Request Specialists deleted successfully');
    }

    public function adminHistory()
    {
        $user = Auth::user()->id;

        return dd(RequestSpecialists::whereUserId($user)
            ->orderBy('created_at', 'desc')
            ->paginate(10));
//        return $this->requestSpecialistsRepository->wherePaginate('user_id', $user, 10);
    }

    public function doctorHistory()
    {
        $user = Auth::user();
        return $this->requestSpecialistsRepository->wherePaginate('doctor_id', $user->id, 10);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function search(Request $request)
    {
        $search = $request->title;
        return RequestSpecialists::where('status', env("STATUS_NEW"))
            ->where("name", 'like', '%' . $search . '%')
            ->orWhere("address", 'like', '%' . $search . '%')
            ->with(['specialties.medical', 'user', 'acceptRequest.doctor.employ'])
            ->get();
    }

}
