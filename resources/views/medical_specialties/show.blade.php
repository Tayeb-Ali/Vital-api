@extends('layout')
@section('title', 'View Medical Specialty')
@section('content')

    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Medical Specialty #{{$medicalSpecialty->id}}</h6>
                <br>
                <a href="/admin/medical_fields/create" class="btn-lg btn-primary">
                    Add <i class="fas fa-pen-square"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Create at</th>
                            <th>Update at</th>
                        </tr>

                        <th>{{$medicalSpecialty->id}}</th>
                        <th>{{$medicalSpecialty->name}}</th>
                        <th>{{$medicalSpecialty->created_at}}</th>
                        <th>{{$medicalSpecialty->updated_at}}</th>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
