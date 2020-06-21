@extends('layout')
@section('title', 'Users')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
    {{--            <h1 class="h3 mb-2 text-gray-800">Blog</h1>--}}

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
                <br>
                <a href="users/create" class="btn-lg btn-primary">
                    Add <i class="fas fa-pen-square"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>phone</th>
                            <th>Type</th>
                            <th>image</th>
                            <th>create at</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>phone</th>
                            <th>Type</th>
                            <th>image</th>
                            <th>create at</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>
                                @if($user->role ==4)
                                    <td style="color: #2d56a5">Doctor</td>
                                @elseif($user->role ==3)
                                    <td style="color: #ff4861">Provider</td>
                                @elseif($user->role ==5)
                                    <td style="color: #373fa5">Pharmacists</td>
                                @elseif($user->role ==6)
                                    <td style="color: #a52392">Nurse</td>
                                @elseif($user->role ==7)
                                    <td>Other</td>
                                @else
                                    <td>Non</td>
                                @endif
                                <td><img src="{{$user->image}}" height="40" width="40"></td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="users/{{$user->id}}/view" class="btn btn-primary btn-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="users/{{$user->id}}/edit" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="#"
                                       class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}

                </div>
            </div>
        </div>
    </div>

@endsection
