@extends('frontend.layouts.master')

@section('title', 'Nifty50')
@section('content')
    <h1>FINNIFTY- Option Chain</h1>

    @if (isset($data) && !empty($data))
        <table>
            <thead>
                <tr >
                    <th style="color:green ; text-align: center"colspan='7'>Calls</th>
                    <th colspan='1'></th>
                    <th style="color:red ; text-align: center" colspan='7'>Puts</th>
            </tr> 
                <tr>
                    <th>Date</th>
                    <th>OI</th>
                    <th>CHNG IN OI</th>
                    <th>VOLUME</th>
                    <th>IV</th>
                    <th>CHNG</th>
                    <th>LTP</th>
                    <th>STRIKE</th>
                   
                    <th>Date</th>
                    <th>LTP</th>
                    <th>CHNG</th>
                    <th>IV</th>
                    <th>VOLUME</th>
                    <th>CHNG IN OI</th>
                    <th>OI</th>
                </tr>
            </thead>
            
            <tbody>
            @php
            $int = 0   
            @endphp
                @foreach ($data as $option)
                
                @php
                $int+= $option['CE']['openInterest']    
                @endphp
                @if (isset($option['PE']) && isset($option['CE']))
                        <tr> <td>{{ $option['CE']['expiryDate'] }}</td>
                            <td>{{ $option['CE']['openInterest'] }}</td>
                            <td>{{ $option['CE']['changeinOpenInterest'] }}</td>
                            <td>{{ $option['CE']['totalTradedVolume'] }}</td>
                            <td>{{ $option['CE']['impliedVolatility'] }}</td>
                            <td>{{ $option['CE']['change'] }}</td>
                            <td>{{ $option['CE']['lastPrice'] }}</td>
                            <td>{{ $option['strikePrice'] }}</td>
                            <td>{{ $option ['PE']['expiryDate'] }}</td>
                            <td>{{ $option['PE']['openInterest'] }}</td>
                            <td>{{ $option['PE']['changeinOpenInterest'] }}</td>
                            <td>{{ $option['PE']['totalTradedVolume'] }}</td>
                            <td>{{ $option['PE']['impliedVolatility'] }}</td>
                            <td>{{ $option['PE']['change'] }}</td>
                            <td>{{ $option['PE']['lastPrice'] }}</td>
                        
                           
                            
                        </tr>
                    @endif
                    
                @endforeach
                <tr> <td></td>
                            <td>{{$int}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        
                           
                            
                        </tr>
            </tbody>
        </table>
        

    @else
        <p>No option chain data available</p>
    @endif
@endsection
