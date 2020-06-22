<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\AppBaseController;
use App\Models\MedicalField;
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
        $medicalSpecialties = $this->medicalSpecialtyRepository->paginate(10);

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
        $medical = MedicalField::all(['name', 'id']);
        return view('medical_specialties.create')->with('medical', $medical);
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
        return redirect('admin/medical_specialists');
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

        return view('medical_specialties.show', compact('medicalSpecialty'));
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
        $medicalSpecialty = $this->medicalSpecialtyRepository->findWith($id, 'medical');
        $medical = MedicalField::all(['name', 'id']);


        if (empty($medicalSpecialty)) {

            return redirect('admin/medicalSpecialties');
        }

        return view('medical_specialties.edit', compact(['medicalSpecialty', 'medical']));
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
            return redirect('admin/medical_specialists');
        }

        $this->medicalSpecialtyRepository->update($request->all(), $id);

        return redirect('admin/medical_specialists');
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

        return redirect('admin/medical_specialists');
    }
}
