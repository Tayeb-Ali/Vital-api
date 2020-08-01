<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use App\Models\Wallet;
use App\Repositories\EmployRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class EmployController
 * @package App\Http\Controllers\API
 */
class EmployAPIController extends AppBaseController
{
    /** @var  EmployRepository */
    private $employRepository;

    public function __construct(EmployRepository $employRepo)
    {
        $this->employRepository = $employRepo;
    }

    /**
     * Display a listing of the Employ.
     * GET|HEAD /employs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $employs = $this->employRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($employs->toArray(), 'Employs retrieved successfully');
    }

    /**
     * Store a newly created Employ in storage.
     * POST /employs
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
//        $request->merge(['cv' => 'null']);
        $employ = $this->employRepository->createApi($request);
        return $this->sendResponse($employ->toArray(), 'Employ saved successfully');
    }

    /**
     * Display the specified Employ.
     * GET|HEAD /employs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Employ $employ */
        $employ = $this->employRepository->find($id);

        if (empty($employ)) {
            return $this->sendError('Employ not found');
        }

        return $this->sendResponse($employ->toArray(), 'Employ retrieved successfully');
    }

    /**
     * Update the specified Employ in storage.
     * PUT/PATCH /employs/{id}
     *
     * @param int $id
     * @param UpdateEmployAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var Employ $employ */
        $employ = $this->employRepository->find($id);

        if (empty($employ)) {
            return $this->sendError('Employ not found');
        }

        $employ = $this->employRepository->update($input, $id);

        return $this->sendResponse($employ->toArray(), 'Employ updated successfully');
    }

    /**
     * Remove the specified Employ from storage.
     * DELETE /employs/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Employ $employ */
        $employ = $this->employRepository->find($id);

        if (empty($employ)) {
            return $this->sendError('Employ not found');
        }

        $employ->delete();

        return $this->sendSuccess('Employ deleted successfully');
    }


}
