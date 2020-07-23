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
                        <form method="post" enctype='multipart/form-data' action="{{url('/')}}/admin/blog">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label for="title">Title</label>
                                    <input type="text"
                                           class="form-control form-control-user"
                                           id="title" required name="title"
                                           placeholder="title">
                                </div>
                                <div class="col-sm-6">
                                    <label for="image">Image</label>
                                    <input type="file" name="image"
                                           class="form-control" id="image">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="summernote">content</label>
                                <textarea id="summernote" required name="content">
                                </textarea>
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
                            <div class="form-group">
                                <label for="notificationTopic">Select notification Topic:</label>
                                <select class="form-control form-control-option col col-3" id="notificationTopic"
                                        name="topic">
                                    <option value="1">Doctor</option>
                                    <option value="2">Provider</option>
                                    <option value="3">All</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-google btn-user btn-block">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
