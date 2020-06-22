<?php

namespace App\Http\Controllers;

use App\Repositories\MedicalFieldRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class MedicalFieldWEBController extends AppBaseController
{
    /** @var  MedicalFieldRepository */
    private $medicalFieldRepository;

    public function __construct(MedicalFieldRepository $medicalFieldRepo)
    {
        $this->medicalFieldRepository = $medicalFieldRepo;
    }

    /**
     * Display a listing of the MedicalField.
     *
     * @return Response
     */
    public function index()
    {
        $medicalFields = $this->medicalFieldRepository->paginate(10);

        return view('medical_fields.index')
            ->with('medicalFields', $medicalFields);
    }

    /**
     * Show the form for creating a new MedicalField.
     *
     * @return Response
     */
    public function create()
    {
        return view('medical_fields.create');
    }

    /**
     * Store a newly created MedicalField in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $this->medicalFieldRepository->create($input);
        return redirect('admin/medical_fields');
    }

    /**
     * Display the specified MedicalField.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {

            return redirect('admin/medical_fields');
        }

        return view('medical_fields.show')->with('medicalField', $medicalField);
    }

    /**
     * Show the form for editing the specified MedicalField.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {
            return redirect(route('medicalFields.index'));
        }

        return view('medical_fields.edit')->with('medicalField', $medicalField);
    }

    /**
     * Update the specified MedicalField in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {

            return redirect('admin/medical_fields');
        }

        $this->medicalFieldRepository->update($request->all(), $id);

        return redirect('admin/medical_fields');
    }

    /**
     * Remove the specified MedicalField from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $medicalField = $this->medicalFieldRepository->find($id);

        if (empty($medicalField)) {
            return redirect('admin/medical_fields');
        }

        $this->medicalFieldRepository->delete($id);

        return redirect('admin/medical_fields');
    }

}
