@extends('layout')
@section('title', 'View Medical Field')
@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
    {{--            <h1 class="h3 mb-2 text-gray-800">Blog</h1>--}}

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Medical Field #{{$medicalField->id}}</h6>
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

                        <th>{{$medicalField->id}}</th>
                        <th>{{$medicalField->name}}</th>
                        <th>{{$medicalField->created_at}}</th>
                        <th>{{$medicalField->updated_at}}</th>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
