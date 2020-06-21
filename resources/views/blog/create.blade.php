@extends('layout')
@section('title', 'Add Blog')
@section('jsUrl', 'Add Blog')
@section('content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">write new blog!</h1>
                        </div>
                        <form class="user" method="post" enctype='multipart/form-data'
                              action="{{ url('admin/blog')  }}">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="title">Title</label>
                                    <input type="text"
                                           class="form-control form-control-user"
                                           id="title" required name="title" placeholder="title">
                                </div>
                                <div class="col-sm-6">
                                    <label for="image">Image</label>
                                    <input type="file" name="image"
                                           class="form-control" required id="image">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content">content</label>
                                <textarea id="content" required name="content"></textarea>
                            </div>
                            <div class="form-group row">

                                <label for="status">Visible:</label>
                                <select class="form-control form-control-option col col-3" id="status" required
                                        name="status">
                                    <option value="1">yes</option>
                                    <option value="2">no</option>
                                </select>
                                <label for="notification">Send Notification:</label>
                                <select class="form-control form-control-option col col-3" id="notification"
                                        name="notification">
                                    <option value="1">yes</option>
                                    <option value="2">no</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-google btn-user btn-block">Save
                            </button>
                            {{--                            <button class="btn-lg btn-primary">Save</button>--}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
