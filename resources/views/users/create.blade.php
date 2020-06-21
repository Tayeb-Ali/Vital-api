@extends('layout')
@section('title', 'Add user')
@section('content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                {{--                <div class="col-lg-5 d-none d-lg-block"></div>--}}
                {{--                <div class="col-lg-7">--}}
                <div class="p-5 container">
                    {{--                        <div class="text-center">--}}
                    {{--                            <h1 class="h4 text-gray-900 mb-4">write new blog!</h1>--}}
                    {{--                        </div>--}}
                    <form class="user" method="post" enctype='multipart/form-data'
                          action="{{ url('admin/users')  }}">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="name">name</label>
                                <input type="text"
                                       class="form-control"
                                       id="name" required name="name" placeholder="name">
                            </div>
                            <div class="col-sm-6">
                                <label for="image">Image</label>
                                <input type="file" name="image"
                                       class="form-control" required id="image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text"
                                   class="form-control"
                                   id="phone" required name="phone" placeholder="phone">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password"
                                   class="form-control"
                                   id="password" required name="password" placeholder="password">
                        </div>

                        <div class="form-group">
                            <label for="accountType">Account Type</label>
                            <select class="form-control" id="accountType">
                                <option value="4">Doctor</option>
                                <option value="3">Provider</option>
                                <option value="5">Pharmacists</option>
                                <option value="6">Nurse</option>
                                <option value="7">Other</option>
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
    {{--    </div>--}}
@endsection
