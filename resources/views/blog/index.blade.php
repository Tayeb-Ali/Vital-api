@extends('layout')
@section('title', 'Blog')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        {{--            <h1 class="h3 mb-2 text-gray-800">Blog</h1>--}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Blog</h6>
                <br>
                <a href="blog/create" class="btn-lg btn-primary">
                    Add <i class="fas fa-pen-square"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Start date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Start date</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($blogs as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->title}}</td>
                                <td><img src="{{$item->image}}" height="50" width="50"></td>
                                @if($item->status ==1)
                                    <td>Visible</td>
                                @elseif($item->status ==2)
                                    <td>non-Visible</td>

                                @endif
                                <td>{{$item->created_at}}</td>
                                <td>
                                    <a href="blog/{{$item->id}}/view" class="btn btn-primary btn-circle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="blog/{{$item->id}}/edit" class="btn btn-info btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="blog/{{$item->id}}/delete"
                                       class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $blogs->links() }}

                </div>
            </div>
        </div>
    </div>

@endsection
