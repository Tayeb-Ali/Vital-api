@extends('layout')
@section('title', 'Specialists')

@section('content')

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Blog</h6>
                <br>
                <a href="medical_specialists/create" class="btn-lg btn-primary">
                    Add <i class="fas fa-pen-square"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Create at</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Create at</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($medicalSpecialties as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    <a href="medical_specialists/{{$item->id}}/view" class="btn btn-primary btn-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="medical_specialists/{{$item->id}}/edit" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="medical_specialists/{{$item->id}}/delete"
                                       class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $medicalSpecialties->links() }}

                </div>
            </div>
        </div>
    </div>

@endsection
