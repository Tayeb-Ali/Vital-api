<?php

namespace App\Http\Controllers;

use App\Models\AcceptRequestSpecialists;
use App\Repositories\AcceptRequestSpecialistsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class AcceptRequestSpecialistsController
 * @package App\Http\Controllers\API
 */
class AcceptRequestSpecialistsAPIController extends AppBaseController
{
    /** @var  AcceptRequestSpecialistsRepository */
    private $acceptRequestSpecialistsRepository;

    public function __construct(AcceptRequestSpecialistsRepository $acceptRequestSpecialistsRepo)
    {
        $this->acceptRequestSpecialistsRepository = $acceptRequestSpecialistsRepo;
    }

    /**
     * Display a listing of the AcceptRequestSpecialists.
     * GET|HEAD /acceptRequestSpecialists
     */
    public function index()
    {
        return $acceptRequestSpecialists = $this->acceptRequestSpecialistsRepository
            ->withPaginate(10, ['request.doctor']);

    }

    /**
     * Store a newly created AcceptRequestSpecialists in storage.
     * POST /acceptRequestSpecialists
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $acceptRequest = new AcceptRequestSpecialists();
        $acceptRequest = $acceptRequest->acceptRequest($request, $user);
        return $acceptRequest;
    }

    /**
     * Display the specified AcceptRequestSpecialists.
     * GET|HEAD /acceptRequestSpecialists/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AcceptRequestSpecialists $acceptRequestSpecialists */
        $acceptRequestSpecialists = $this->acceptRequestSpecialistsRepository->find($id);

        if (empty($acceptRequestSpecialists)) {
            return $this->sendError('Accept Request Specialists not found');
        }

        return $this->sendResponse($acceptRequestSpecialists->toArray(), 'Accept Request Specialists retrieved successfully');
    }

    /**
     * Update the specified AcceptRequestSpecialists in storage.
     * PUT/PATCH /acceptRequestSpecialists/{id}
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var AcceptRequestSpecialists $acceptRequestSpecialists */
        $acceptRequestSpecialists = $this->acceptRequestSpecialistsRepository->find($id);

        if (empty($acceptRequestSpecialists)) {
            return $this->sendError('Accept Request Specialists not found');
        }

        $acceptRequestSpecialists = $this->acceptRequestSpecialistsRepository->update($input, $id);

        return $this->sendResponse($acceptRequestSpecialists->toArray(), 'AcceptRequestSpecialists updated successfully');
    }

    /**
     * Remove the specified AcceptRequestSpecialists from storage.
     * DELETE /acceptRequestSpecialists/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var AcceptRequestSpecialists $acceptRequestSpecialists */
        $acceptRequestSpecialists = $this->acceptRequestSpecialistsRepository->find($id);

        if (empty($acceptRequestSpecialists)) {
            return $this->sendError('Accept Request Specialists not found');
        }

        $acceptRequestSpecialists->delete();

        return $this->sendSuccess('Accept Request Specialists deleted successfully');
    }

    /**
     * acceptRequestByUser the specified AcceptRequestSpecialists in storage.
     * POST /acceptRequestByUser/{id}
     *
     * @param int $requestId
     * @return Response
     */
    public function acceptRequestByUser($requestId)
    {
        $doctor_id = Auth::user()->id;
        $accept = new AcceptRequestSpecialists();
        return $accept->acceptRequestByUser($requestId, $doctor_id);
    }

    /**
     * acceptRequestByAdmin the specified AcceptRequestSpecialists in storage.
     * POST /acceptRequestByAdmin/{id}
     *
     * @param int $requestId
     * @return array
     */
    public function acceptRequestByAdmin($requestId)
    {
        $userId = Auth::user()->id;
        $accept = new AcceptRequestSpecialists();
        return $accept->acceptRequestByAdmin($requestId, $userId);
    }

    /**
     * cancelRequestByAdmin the specified AcceptRequestSpecialists in update.
     * POST /cancelRequestByAdmin/{id}
     *
     * @param int $requestId
     * @return Response
     * @throws \Exception
     */
    public function cancelRequestByAdmin($requestId)
    {
        $accept = new AcceptRequestSpecialists();
        return $accept->cancelRequestByAdmin($requestId);
    }

    /**
     * cancelRequestByAdmin the specified AcceptRequestSpecialists in update.
     * POST /cancelRequestByAdmin/{id}
     *
     * @param int $requestId
     * @return Response
     * @throws \Exception
     */
    public function cancelRequestByAdminToUser($requestId)
    {
        $accept = new AcceptRequestSpecialists();
        return $accept->cancelRequestByAdminToUser($requestId);
    }

    /**
     * cancelRequestByUser the specified AcceptRequestSpecialists in storage.
     * POST /cancelRequestByUser/{id}
     *
     * @param int $requestId
     * @return array
     * @throws \Exception
     */
    public function cancelRequestByUser($requestId)
    {
        $accept = new AcceptRequestSpecialists();
        return $accept->cancelRequestByUser($requestId);
    }


    /**
     * acceptRequestAndDone the specified AcceptRequestSpecialists in storage.
     * POST /acceptRequestAndDone/{id}
     *
     * @param Request $request
     * @param int $requestId
     * @return Response
     */
    public function acceptRequestAndDone(Request $request, $requestId)
    {
        $accept = new AcceptRequestSpecialists();
        return $accept->acceptRequestAndDone($requestId, $request);
    }
}
