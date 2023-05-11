@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>Slider List</h3>
                    <a href="{{ url('admin/sliders/create')}}" class="btn btn-primary btn-sm float-end">Add Sliders</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID </th>
                            <th>Title </th>
                            <th>Description </th>
                            <th>Image </th>

                            <th>Action </th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
