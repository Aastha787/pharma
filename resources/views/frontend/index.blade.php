@extends('layouts.app')

@section('content')
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('assets/img.jpg')}}" class="d-block w-100" alt="...">
            </div>

        </div>
    </div>
    @endsection
