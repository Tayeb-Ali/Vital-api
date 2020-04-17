<?php

namespace App\Http\Controllers;


use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class WalletController
 * @package App\Http\Controllers\API
 */
class WalletAPIController extends AppBaseController
{
    /** @var  WalletRepository */
    private $walletRepository;

    public function __construct(WalletRepository $walletRepo)
    {
        $this->walletRepository = $walletRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/wallets",
     *      summary="Get a listing of the Wallets.",
     *      tags={"Wallet"},
     *      description="Get all Wallets",
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
     *                  @SWG\Items(ref="#/definitions/Wallet")
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
        $user = Auth::user();
        if ($user) {
            $wallets = Wallet::where('user_id', $user->id)->first();
            return $this->sendResponse($wallets->toArray(), 'Wallets retrieved successfully');
        }
        return false;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/wallets",
     *      summary="Store a newly created Wallet in storage",
     *      tags={"Wallet"},
     *      description="Store Wallet",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Wallet that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Wallet")
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
     *                  ref="#/definitions/Wallet"
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

        $wallet = $this->walletRepository->create($input);

        return $this->sendResponse($wallet->toArray(), 'Wallet saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/wallets/{id}",
     *      summary="Display the specified Wallet",
     *      tags={"Wallet"},
     *      description="Get Wallet",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Wallet",
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
     *                  ref="#/definitions/Wallet"
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
        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->find($id);

        if (empty($wallet)) {
            return $this->sendError('Wallet not found');
        }

        return $this->sendResponse($wallet->toArray(), 'Wallet retrieved successfully');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/wallets/{id}",
     *      summary="Update the specified Wallet in storage",
     *      tags={"Wallet"},
     *      description="Update Wallet",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Wallet",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Wallet that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Wallet")
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
     *                  ref="#/definitions/Wallet"
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

        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->find($id);

        if (empty($wallet)) {
            return $this->sendError('Wallet not found');
        }

        $wallet = $this->walletRepository->update($input, $id);

        return $this->sendResponse($wallet->toArray(), 'Wallet updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/wallets/{id}",
     *      summary="Remove the specified Wallet from storage",
     *      tags={"Wallet"},
     *      description="Delete Wallet",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Wallet",
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
        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->find($id);

        if (empty($wallet)) {
            return $this->sendError('Wallet not found');
        }

        $wallet->delete();

        return $this->sendSuccess('Wallet deleted successfully');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/my_wallets",
     *      summary="Display the specified Wallet. By userID",
     *      tags={"Wallet"},
     *      description="Get one Wallets By userID",
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
     *                  @SWG\Items(ref="#/definitions/Wallet")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function myBalancy()
    {

    }
}
