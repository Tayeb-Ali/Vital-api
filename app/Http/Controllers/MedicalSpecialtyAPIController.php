<?php

namespace App\Http\Controllers;

use App\Models\MedicalSpecialty;
use App\Repositories\MedicalSpecialtyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

/**
 * Class MedicalSpecialtyController
 * @package App\Http\Controllers\API
 */
class MedicalSpecialtyAPIController extends Controller
{
    /** @var  MedicalSpecialtyRepository */
    private $medicalSpecialtyRepository;

    public function __construct(MedicalSpecialtyRepository $medicalSpecialtyRepo)
    {
        $this->medicalSpecialtyRepository = $medicalSpecialtyRepo;
    }

    /**
     * Display a listing of the MedicalSpecialty.
     * GET|HEAD /medicalSpecialties
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $medicalSpecialties = $this->medicalSpecialtyRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($medicalSpecialties->toArray(), 'Medical Specialties retrieved successfully');
    }

    /**
     * Store a newly created MedicalSpecialty in storage.
     * POST /medicalSpecialties
     *
     * @param CreateMedicalSpecialtyAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $medicalSpecialty = $this->medicalSpecialtyRepository->create($input);

        return $this->sendResponse($medicalSpecialty->toArray(), 'Medical Specialty saved successfully');
    }

    /**
     * Display the specified MedicalSpecialty.
     * GET|HEAD /medicalSpecialties/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MedicalSpecialty $medicalSpecialty */
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {
            return $this->sendError('Medical Specialty not found');
        }

        return $this->sendResponse($medicalSpecialty->toArray(), 'Medical Specialty retrieved successfully');
    }

    /**
     * Update the specified MedicalSpecialty in storage.
     * PUT/PATCH /medicalSpecialties/{id}
     *
     * @param int $id
     * @param UpdateMedicalSpecialtyAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var MedicalSpecialty $medicalSpecialty */
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {
            return $this->sendError('Medical Specialty not found');
        }

        $medicalSpecialty = $this->medicalSpecialtyRepository->update($input, $id);

        return $this->sendResponse($medicalSpecialty->toArray(), 'MedicalSpecialty updated successfully');
    }

    /**
     * Remove the specified MedicalSpecialty from storage.
     * DELETE /medicalSpecialties/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var MedicalSpecialty $medicalSpecialty */
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {
            return $this->sendError('Medical Specialty not found');
        }

        $medicalSpecialty->delete();

        return $this->sendSuccess('Medical Specialty deleted successfully');
    }
}
