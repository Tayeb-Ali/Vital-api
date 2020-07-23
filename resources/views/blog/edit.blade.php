@extends('layout')
@section('title', 'update Blog')
@section('content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">write new blog!</h1>
                        </div>
                        <form method="post" enctype='multipart/form-data' action="{{url('/')}}/admin/blog/{{$blog->id}}/update">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="title">Title</label>
                                    <input type="text"
                                           class="form-control form-control-user"
                                           id="title" value="{{$blog->title}}" required name="title"
                                           placeholder="title">
                                </div>
                                <div class="col-sm-6">
                                    <label for="image">Image</label>
                                    <input type="file" name="image"
                                           value="{{$blog->image}}"
                                           class="form-control" id="image">
                                    <img height="40" width="40" src="{{$blog->image}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="summernote">content</label>
                                <textarea id="summernote" required name="content">
                                                                        {{$blog->content}}

                                </textarea>
                            </div>

                            <button type="submit" class="btn btn-google btn-user btn-block">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
