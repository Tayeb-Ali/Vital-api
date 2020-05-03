<?php

namespace App\Http\Controllers;

use App\Models\EmergencyRequest;
use App\Repositories\EmergencyRequestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

//use Illuminate\Support\Facades\Auth;

/**
 * Class EmergencyRequestAPIController
 * @package App\Http\Controllers\API
 */
class EmergencyRequestAPIController extends AppBaseController
{
    /** @var  EmergencyRequestRepository */
    private $EmergencyRequestRepository;

    public function __construct(EmergencyRequestRepository $emergencyRequestRep)
    {
        $this->EmergencyRequestRepository = $emergencyRequestRep;
    }

    /**
     * @return emergencyRequest
     *
     * @SWG\Get(
     *      path="emergency_request",
     *      summary="Get a listing of the EmergencyRequests.",
     *      tags={"EmergencyRequest"},
     *      description="Get all EmergencyRequests",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/EmergencyRequest")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        $emergencyRequest = $this->EmergencyRequestRepository->withPaginate(10, 'user');
        return $this->sendResponse($emergencyRequest->toArray(), 'Emergency Request retrieved successfully');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="emergency_request",
     *      summary="Store a newly created EmergencyRequest in storage",
     *      tags={"EmergencyRequest"},
     *      description="Store EmergencyRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EmergencyRequest that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EmergencyRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/EmergencyRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $emergencyRequest = $this->EmergencyRequestRepository->createApi($input);

        return $this->sendResponse($emergencyRequest->toArray(), 'Emergency Request saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="emergency_request/{id}",
     *      summary="Display the specified EmergencyRequest",
     *      tags={"EmergencyRequest"},
     *      description="Get EmergencyRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmergencyRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/EmergencyRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var EmergencyRequest $emergencyRequest */
        $emergencyRequest = $this->EmergencyRequestRepository->findWith($id, ['user']);

        if (empty($emergencyRequest)) {
            return $this->sendError('Emergency Request not found');
        }

        return $this->sendResponse($emergencyRequest->toArray(), 'Emergency Request retrieved successfully');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="emergency_request/{id}",
     *      summary="Update the specified EmergencyRequest in storage",
     *      tags={"EmergencyRequest"},
     *      description="Update EmergencyRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmergencyRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EmergencyRequest that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EmergencyRequest")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/EmergencyRequest"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var EmergencyRequest $emergencyRequest */
        $emergencyRequest = $this->EmergencyRequestRepository->find($id);

        if (empty($emergencyRequest)) {
            return $this->sendError('Emergency Request not found');
        }

        $emergencyRequest = $this->EmergencyRequestRepository->update($input, $id);

        return $this->sendResponse($emergencyRequest->toArray(), 'EmergencyRequest updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @throws \Exception
     * @SWG\Delete(
     *      path="emergency_request/{id}",
     *      summary="Remove the specified EmergencyRequest from storage",
     *      tags={"EmergencyRequest"},
     *      description="Delete EmergencyRequest",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmergencyRequest",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var EmergencyRequest $emergencyRequest */
        $emergencyRequest = $this->EmergencyRequestRepository->find($id);

        if (empty($emergencyRequest)) {
            return $this->sendError('Emergency Request not found');
        }

        $emergencyRequest->delete();

        return $this->sendSuccess('Emergency Request deleted successfully');
    }

    public function adminHistory()
    {
        /** @var EmergencyRequest $emergencyRequest */
        $emergencyRequest = $this->EmergencyRequestRepository->withPaginate(10, 'user');

        if (empty($emergencyRequest)) {
            return $this->sendError('Emergency Request not found');
        }

        return $this->sendResponse($emergencyRequest->toArray(), 'Emergency Request retrieved successfully');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userHistory()
    {
        /** @var EmergencyRequest $emergencyRequest */
        $emergencyRequest = $this->EmergencyRequestRepository->withPaginate(10, 'user');

        if (empty($emergencyRequest)) {
            return $this->sendError('Emergency Request not found');
        }

        return $this->sendResponse($emergencyRequest->toArray(), 'Emergency Request retrieved successfully');
    }

    public function saveFile($request)
    {
        $random = Str::random(5);
        if ($request->hasfile('reports_file')) {
            $image = $request->file('reports_file');
            $name = $random . 'reports_file_' . $request->reports_file->extension();
            $image->move(public_path() . '/reports/', $name);
            $name = url("reports/$name");
            return $name;
        }
        return false;
    }
}
