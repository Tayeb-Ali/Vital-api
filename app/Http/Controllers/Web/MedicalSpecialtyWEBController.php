<?php

namespace App\Http\Controllers;

use App\Repositories\MedicalSpecialtyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MedicalSpecialtyWEBController extends AppBaseController
{
    /** @var  MedicalSpecialtyRepository */
    private $medicalSpecialtyRepository;

    public function __construct(MedicalSpecialtyRepository $medicalSpecialtyRepo)
    {
        $this->medicalSpecialtyRepository = $medicalSpecialtyRepo;
    }

    /**
     * Display a listing of the MedicalSpecialty.
     *
     * @return Response
     */
    public function index()
    {
        $medicalSpecialties = $this->medicalSpecialtyRepository->all();

        return view('medical_specialties.index')
            ->with('medicalSpecialties', $medicalSpecialties);
    }

    /**
     * Show the form for creating a new MedicalSpecialty.
     *
     * @return Response
     */
    public function create()
    {
        return view('medical_specialties.create');
    }

    /**
     * Store a newly created MedicalSpecialty in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->medicalSpecialtyRepository->create($input);
        return redirect(route('medicalSpecialties.index'));
    }

    /**
     * Display the specified MedicalSpecialty.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {
            return redirect(route('medicalSpecialties.index'));
        }

        return view('medical_specialties.show')->with('medicalSpecialty', $medicalSpecialty);
    }

    /**
     * Show the form for editing the specified MedicalSpecialty.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {

            return redirect(route('medicalSpecialties.index'));
        }

        return view('medical_specialties.edit')->with('medicalSpecialty', $medicalSpecialty);
    }

    /**
     * Update the specified MedicalSpecialty in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {
            Flash::error('Medical Specialty not found');

            return redirect(route('medicalSpecialties.index'));
        }

        $this->medicalSpecialtyRepository->update($request->all(), $id);

        return redirect(route('medicalSpecialties.index'));
    }

    /**
     * Remove the specified MedicalSpecialty from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $medicalSpecialty = $this->medicalSpecialtyRepository->find($id);

        if (empty($medicalSpecialty)) {
            return redirect(route('medicalSpecialties.index'));
        }

        $this->medicalSpecialtyRepository->delete($id);

        return redirect(route('medicalSpecialties.index'));
    }
}
