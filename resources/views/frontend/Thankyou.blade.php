@extends('layouts.app')
@section('title','Thankyou for your purchase')
@section('content')
<div class="py-3 pyt-md-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="p-4 shadow bg-white">
                    <h2>Health Mart</h2>
                    <h4>Thankyou for your purchase</h4>
                </br>
                    <a href="{{url('collections')}}" class="btn btn-primary">Buy Again</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
