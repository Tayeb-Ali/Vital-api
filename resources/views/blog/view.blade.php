@extends('layout')
@section('title', 'View Blog')
@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
    {{--            <h1 class="h3 mb-2 text-gray-800">Blog</h1>--}}

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Blog #{{$blog->id}}</h6>
                <br>
                <a href="/admin/blog/create" class="btn-lg btn-primary">
                    Add <i class="fas fa-pen-square"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Start date</th>
                            <th>Content</th>
                        </tr>

                        <th>{{$blog->id}}</th>
                        <th>{{$blog->title}}</th>
                        <th><img height="100" width="200" src="{{$blog->image}}"></th>
                        @if($blog->status ==1)
                            <th>Visible</th>
                        @elseif($blog->status ==2)
                            <th>non-Visible</th>

                        @endif
                        <th>{{$blog->created_at}}</th>
                        <th>{!! $blog->content !!}</th>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
