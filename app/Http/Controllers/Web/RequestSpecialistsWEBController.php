<?php

namespace App\Http\Controllers;

use App\Repositories\RequestSpecialistsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RequestSpecialistsWEBController extends AppBaseController
{
    /** @var  RequestSpecialistsRepository */
    private $requestSpecialistsRepository;

    public function __construct(RequestSpecialistsRepository $requestSpecialistsRepo)
    {
        $this->requestSpecialistsRepository = $requestSpecialistsRepo;
    }

    /**
     * Display a listing of the RequestSpecialists.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
    {
        $requestSpecialists = $this->requestSpecialistsRepository->paginate(10);

        return view('users.index', compact('requestSpecialists'));
    }

    /**
     * Show the form for creating a new RequestSpecialists.
     *
     * @return Response
     */
    public function create()
    {
        return view('request_specialists.create');
    }

    /**
     * Store a newly created RequestSpecialists in storage.
     *
     * @param CreateRequestSpecialistsRequest $request
     *
     * @return Response
     */
    public function store(CreateRequestSpecialistsRequest $request)
    {
        $input = $request->all();

        $requestSpecialists = $this->requestSpecialistsRepository->create($input);

        Flash::success('Request Specialists saved successfully.');

        return redirect(route('requestSpecialists.index'));
    }

    /**
     * Display the specified RequestSpecialists.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $requestSpecialists = $this->requestSpecialistsRepository->find($id);

        if (empty($requestSpecialists)) {
            Flash::error('Request Specialists not found');

            return redirect(route('requestSpecialists.index'));
        }

        return view('request_specialists.show')->with('requestSpecialists', $requestSpecialists);
    }

    /**
     * Show the form for editing the specified RequestSpecialists.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $requestSpecialists = $this->requestSpecialistsRepository->find($id);

        if (empty($requestSpecialists)) {
            Flash::error('Request Specialists not found');

            return redirect(route('requestSpecialists.index'));
        }

        return view('request_specialists.edit')->with('requestSpecialists', $requestSpecialists);
    }

    /**
     * Update the specified RequestSpecialists in storage.
     *
     * @param int $id
     * @param UpdateRequestSpecialistsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestSpecialistsRequest $request)
    {
        $requestSpecialists = $this->requestSpecialistsRepository->find($id);

        if (empty($requestSpecialists)) {
            Flash::error('Request Specialists not found');

            return redirect(route('requestSpecialists.index'));
        }

        $requestSpecialists = $this->requestSpecialistsRepository->update($request->all(), $id);

        Flash::success('Request Specialists updated successfully.');

        return redirect(route('requestSpecialists.index'));
    }

    /**
     * Remove the specified RequestSpecialists from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $requestSpecialists = $this->requestSpecialistsRepository->find($id);

        if (empty($requestSpecialists)) {
            Flash::error('Request Specialists not found');

            return redirect(route('requestSpecialists.index'));
        }

        $this->requestSpecialistsRepository->delete($id);

        Flash::success('Request Specialists deleted successfully.');

        return redirect(route('requestSpecialists.index'));
    }
}
