@extends('frontend.layouts.master')
@section('title', 'Home')
@section('content')
   

<div class="row wide-xl " >
            @foreach($breeds as $breed)
                <div class="col-lg-2 ">
                    <div class="feature-with-icon" data-aos="flip-up" >
                        <h5><strong>{{ucfirst($breed)}}</strong></h5>
                    </div>
                </div>
            @endfo


@endsection