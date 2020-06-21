@extends('layout')
@section('title', 'Edit Specialty')
@section('content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="p-5 container">
                    <form class="user" method="post" enctype='multipart/form-data'
                          action="{{ url('admin/medical_specialists')  }}">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="name">The name of Specialty</label>
                                <input type="text"
                                       class="form-control"
                                       id="name" required name="name" value="{{$medicalSpecialty->name}}"
                                       placeholder="name">
                            </div>

                            <div class="form-group">
                                <label for="medicalId">Re-Select Medical Field</label>
                                <select name="medical_id" class="form-control" id="medicalId">
                                    @foreach($medical as $medical)
                                        <option value="{{$medical->id}}">{{$medical->name}}</option>
                                    @endforeach
                                </select>


                            </div>
                            <button type="submit" class="btn btn-google btn-user btn-block">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--    </div>--}}
@endsection
