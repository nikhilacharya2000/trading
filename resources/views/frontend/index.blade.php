@extends('frontend.layouts.master')

@section('title', 'Finnifty')
@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>SCALPING PRICE </div>
               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="table-responsive" style="font-size: 60px;    text-align: center;    /* margin: 0px; */">
                    🚧🛠️
                        <!-- <label for="expiry_date"><b>Select Expiry:</b></label>
                        <select style="width: 234px; height: 37px; color: #a37213;" id="expiry_date">
                            <option value="" selected>Options</option>


                            @if (isset($expiryDate1))



                                @foreach ($expiryDate1 as $option)
                                    <option value="{{ $option }}">{{ date('d-M-Y', strtotime($option)) }}</option>
                                @endforeach
                            @endif
                        </select> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    

   
 

@endsection
