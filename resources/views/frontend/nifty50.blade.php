@extends('frontend.layouts.master')

@section('title', 'Nifty50')
@section('content')

    <h1>FINNIFTY- Option Chain</h1>


    


    <div style="margin-left: 455px; margin-top: 40px; margin-bottom: 25px; color: #c71d47;">
        <label for="expiry_date"><b>Select Expiry:</b></label>
           
        <select style="width: 234px; height: 37px; color: #a37213;" id="expiry_date">
            <option value="" selected>Options</option>
            
               
            @if (isset($expiryDate1))
                
              
             
            @foreach ($expiryDate1 as $option)
                
    
                 
                    <option value="{{ $option }}">{{ date('d-M-Y', strtotime($option)) }}</option>
                     
                 
            @endforeach
            @endif  
        </select>
    </div>

    

                 
 
     
 
     






    @if (isset($data) && !empty($data))

        <table style="
        margin-left: 455px;">
            <thead>
                <tr>
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
                    $oiCE = 0;
                    $coiCE = 0;
                    $volCE = 0;
                    $oiPE = 0;
                    $coiPE = 0;
                    $volPE = 0;
                @endphp
                @foreach ($data as $option)
                    @php
                        $oiCE += $option['CE']['openInterest'];
                        $coiCE += $option['CE']['changeinOpenInterest'];
                        $volCE += $option['CE']['totalTradedVolume'];
                        $oiPE += $option['PE']['openInterest'];
                        $coiPE += $option['PE']['changeinOpenInterest'];
                        $volPE += $option['PE']['totalTradedVolume'];
                    @endphp
                    @if (isset($option['PE']) && isset($option['CE']))
                        <tr class="{{ $option['expiryDate'] }}">
                            <td>{{ $option['expiryDate'] }}</td>
                            <td>{{ $option['CE']['openInterest'] }}</td>
                            <td>{{ $option['CE']['changeinOpenInterest'] }}</td>
                            <td>{{ $option['CE']['totalTradedVolume'] }}</td>
                            <td>{{ $option['CE']['impliedVolatility'] }}</td>
                            <td>{{ $option['CE']['change'] }}</td>
                            <td>{{ $option['CE']['lastPrice'] }}</td>
                            <td>{{ $option['strikePrice'] }}</td>
                            <td>{{ $option['PE']['expiryDate'] }}</td>
                            <td>{{ $option['PE']['lastPrice'] }}</td>
                            <td>{{ $option['PE']['change'] }}</td>
                            <td>{{ $option['PE']['impliedVolatility'] }}</td>
                            <td>{{ $option['PE']['totalTradedVolume'] }}</td>
                            <td>{{ $option['PE']['changeinOpenInterest'] }}</td>
                            <td>{{ $option['PE']['openInterest'] }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td style="color: rgb(255, 94, 0)"><b>TOTAL</b></td>
                    <td>{{ $oiCE }}</td>
                    <td>{{ $coiCE }}</td>
                    <td>{{ $volCE }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $volPE }}</td>
                    <td>{{ $coiPE }}</td>
                    <td>{{ $oiPE }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>No option chain data available</p>
    @endif





    <script>
        // JavaScript code to handle table filtering based on selected expiry date

        $("#expiry_date").change(function(){
            const selectedOption = $("#expiry_date").val();
            const tableRows = document.querySelectorAll('tbody tr');
               
            tableRows.forEach((row) => {
                console.log(row);
                if (row.classList.contains(selectedOption)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
    </script>


@endsection
