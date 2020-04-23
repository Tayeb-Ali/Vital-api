<?php

namespace App\Http\Controllers;

use App\Models\EmergencyServiced;
use App\Repositories\EmergencyServicedRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class EmergencyServicedController
 * @package App\Http\Controllers\API
 */
class EmergencyServicedAPIController extends AppBaseController
{
    /** @var  EmergencyServicedRepository */
    private $emergencyServicedRepository;

    public function __construct(EmergencyServicedRepository $emergencyServicedRepo)
    {
        $this->emergencyServicedRepository = $emergencyServicedRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/emergencyServiceds",
     *      summary="Get a listing of the EmergencyServiceds.",
     *      tags={"EmergencyServiced"},
     *      description="Get all EmergencyServiceds",
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
     *                  @SWG\Items(ref="#/definitions/EmergencyServiced")
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
        $emergencyServiceds = $this->emergencyServicedRepository->withPaginate(10, 'user');
        return $this->sendResponse($emergencyServiceds->toArray(), 'Emergency Serviceds retrieved successfully');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/emergencyServiceds",
     *      summary="Store a newly created EmergencyServiced in storage",
     *      tags={"EmergencyServiced"},
     *      description="Store EmergencyServiced",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EmergencyServiced that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EmergencyServiced")
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
     *                  ref="#/definitions/EmergencyServiced"
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

        $emergencyServiced = $this->emergencyServicedRepository->createApi($input);

        return $this->sendResponse($emergencyServiced->toArray(), 'Emergency Serviced saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/emergencyServiceds/{id}",
     *      summary="Display the specified EmergencyServiced",
     *      tags={"EmergencyServiced"},
     *      description="Get EmergencyServiced",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmergencyServiced",
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
     *                  ref="#/definitions/EmergencyServiced"
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
        /** @var EmergencyServiced $emergencyServiced */
        $emergencyServiced = $this->emergencyServicedRepository->findWith($id, ['user']);

        if (empty($emergencyServiced)) {
            return $this->sendError('Emergency Serviced not found');
        }

        return $this->sendResponse($emergencyServiced->toArray(), 'Emergency Serviced retrieved successfully');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/emergencyServiceds/{id}",
     *      summary="Update the specified EmergencyServiced in storage",
     *      tags={"EmergencyServiced"},
     *      description="Update EmergencyServiced",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmergencyServiced",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EmergencyServiced that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EmergencyServiced")
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
     *                  ref="#/definitions/EmergencyServiced"
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

        /** @var EmergencyServiced $emergencyServiced */
        $emergencyServiced = $this->emergencyServicedRepository->find($id);

        if (empty($emergencyServiced)) {
            return $this->sendError('Emergency Serviced not found');
        }

        $emergencyServiced = $this->emergencyServicedRepository->update($input, $id);

        return $this->sendResponse($emergencyServiced->toArray(), 'EmergencyServiced updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/emergencyServiceds/{id}",
     *      summary="Remove the specified EmergencyServiced from storage",
     *      tags={"EmergencyServiced"},
     *      description="Delete EmergencyServiced",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmergencyServiced",
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
        /** @var EmergencyServiced $emergencyServiced */
        $emergencyServiced = $this->emergencyServicedRepository->find($id);

        if (empty($emergencyServiced)) {
            return $this->sendError('Emergency Serviced not found');
        }

        $emergencyServiced->delete();

        return $this->sendSuccess('Emergency Serviced deleted successfully');
    }

    public function adminHistory()
    {
        /** @var EmergencyServiced $emergencyServiced */
        $emergencyServiced = $this->emergencyServicedRepository->withPaginate(10, 'user');

        if (empty($emergencyServiced)) {
            return $this->sendError('Emergency Serviced not found');
        }

        return $this->sendResponse($emergencyServiced->toArray(), 'Emergency Serviced retrieved successfully');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userHistory()
    {
        /** @var EmergencyServiced $emergencyServiced */
        $emergencyServiced = $this->emergencyServicedRepository->withPaginate(10, 'user');

        if (empty($emergencyServiced)) {
            return $this->sendError('Emergency Serviced not found');
        }

        return $this->sendResponse($emergencyServiced->toArray(), 'Emergency Serviced retrieved successfully');
    }

}
