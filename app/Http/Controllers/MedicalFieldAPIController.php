<?php

namespace App\Http\Controllers;

use App\Models\MedicalField;
use App\Repositories\MedicalFieldRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MedicalFieldController
 * @package App\Http\Controllers\API
 */

class MedicalFieldAPIController extends AppBaseController
{
    /** @var  MedicalFieldRepository */
    private $medicalFieldRepository;

    public function __construct(MedicalFieldRepository $medicalFieldRepo)
    {
        $this->medicalFieldRepository = $medicalFieldRepo;
    }

    /**
     * Display a listing of the MedicalField.
     * GET|HEAD /medicalFields
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $medicalFields = $this->medicalFieldRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($medicalFields->toArray(), 'Medical Fields retrieved successfully');
    }

    /**
     * Store a newly created MedicalField in storage.
     * POST /medicalFields
     *
     * @param CreateMedicalFieldAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $medicalField = $this->medicalFieldRepository->create($input);

        return $this->sendResponse($medicalField->toArray(), 'Medical Field saved successfully');
    }

    /**
     * Display the specified MedicalField.
     * GET|HEAD /medicalFields/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MedicalField $medicalField */
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {
            return $this->sendError('Medical Field not found');
        }

        return $this->sendResponse($medicalField->toArray(), 'Medical Field retrieved successfully');
    }

    /**
     * Update the specified MedicalField in storage.
     * PUT/PATCH /medicalFields/{id}
     *
     * @param int $id
     * @param UpdateMedicalFieldAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var MedicalField $medicalField */
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {
            return $this->sendError('Medical Field not found');
        }

        $medicalField = $this->medicalFieldRepository->update($input, $id);

        return $this->sendResponse($medicalField->toArray(), 'MedicalField updated successfully');
    }

    /**
     * Remove the specified MedicalField from storage.
     * DELETE /medicalFields/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MedicalField $medicalField */
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {
            return $this->sendError('Medical Field not found');
        }

        $medicalField->delete();

        return $this->sendSuccess('Medical Field deleted successfully');
    }
}
