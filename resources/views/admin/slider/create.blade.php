@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3> Add Slider</h3>
                    <a href="{{ url('admin/sliders/create')}}" class="btn btn-primary btn-sm float-end">Back</a>
                </div>
                <div class="card-body">

                    <form action="{{ url('admin/sliders')}} " method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control"/>
                                @error('name')<small class="text-danger">{{$message}}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea  name="description" class="form-control" rows="3"></textarea>
                                @error('description')<small class="text-danger">{{$message}}</small> @enderror

                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control"/>
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary float-end">Save</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
