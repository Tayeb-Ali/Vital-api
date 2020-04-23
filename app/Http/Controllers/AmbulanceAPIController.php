<?php

namespace App\Http\Controllers;


use App\Models\Ambulance;
use App\Models\Wallet;
use App\Repositories\AmbulanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class AmbulanceController
 * @package App\Http\Controllers\API
 */
class AmbulanceAPIController extends AppBaseController
{
    /** @var  AmbulanceRepository */
    private $ambulanceRepository;

    public function __construct(AmbulanceRepository $ambulanceRepo)
    {
        $this->ambulanceRepository = $ambulanceRepo;
    }

    /**
     * @SWG\Get(
     *      path="/ambulances",
     *      summary="Get a listing of the Ambulances.",
     *      tags={"Ambulance"},
     *      description="Get all Ambulances",
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
     *                  @SWG\Items(ref="#/definitions/Ambulance")
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
        return $ambulances = $this->ambulanceRepository->withPaginate(10, 'user');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/ambulances",
     *      summary="Store a newly created Ambulance in storage",
     *      tags={"Ambulance"},
     *      description="Store Ambulance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ambulance that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ambulance")
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
     *                  ref="#/definitions/Ambulance"
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
        $user = Auth::user();
        $ambulance = $this->ambulanceRepository->createApi($input);
        $wallet = Wallet::whereUserId($user->id)->first();;
        $wallet->balance = ($wallet->balance - env('AMBULANCE_POINT'));
        $wallet->save();

        return $this->sendResponse($ambulance->toArray(), 'Ambulance saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/ambulances/{id}",
     *      summary="Display the specified Ambulance",
     *      tags={"Ambulance"},
     *      description="Get Ambulance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ambulance",
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
     *                  ref="#/definitions/Ambulance"
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
        /** @var Ambulance $ambulance */
        $ambulance = $this->ambulanceRepository->findWith($id, ['user']);

        if (empty($ambulance)) {
            return $this->sendError('Ambulance not found');
        }

        return $this->sendResponse($ambulance->toArray(), 'Ambulance retrieved successfully');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/ambulances/{id}",
     *      summary="Update the specified Ambulance in storage",
     *      tags={"Ambulance"},
     *      description="Update Ambulance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ambulance",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ambulance that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ambulance")
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
     *                  ref="#/definitions/Ambulance"
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

        /** @var Ambulance $ambulance */
        $ambulance = $this->ambulanceRepository->find($id);

        if (empty($ambulance)) {
            return $this->sendError('Ambulance not found');
        }

        $ambulance = $this->ambulanceRepository->update($input, $id);

        return $this->sendResponse($ambulance->toArray(), 'Ambulance updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/ambulances/{id}",
     *      summary="Remove the specified Ambulance from storage",
     *      tags={"Ambulance"},
     *      description="Delete Ambulance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ambulance",
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
        /** @var Ambulance $ambulance */
        $ambulance = $this->ambulanceRepository->find($id);

        if (empty($ambulance)) {
            return $this->sendError('Ambulance not found');
        }

        $ambulance->delete();

        return $this->sendSuccess('Ambulance deleted successfully');
    }
}
