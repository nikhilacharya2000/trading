@extends('frontend.layouts.master')

@section('title', 'FinNifty')
@section('content')
    <?php
    use Carbon\Carbon;
    ?>
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>FinNifty- Option Chain</div>
            </div>
        </div>
    </div>








    <div class="d-flex">

        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="main-card mb-3 card">
                    <div class="card-body" style="width: 915px;">
                        <div class="table-responsive">
                            <label for="expiry_date"><b>Select Expiry:</b></label>
                            <select style="width: 234px; height: 37px; color: #a37213;" id="expiry_date">
                                <option value="" selected>Options</option>
                                @if (isset($expAray) && is_array($expAray) && count($expAray) > 0)
                                    @foreach ($expAray as $index => $option)
                                        <option value="{{ $option['option'] }}"
                                            @if ($option['isUpcomingAfterInitial']) selected @endif>
                                            {{ $option['option'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="main-card mb-3 card">
                    <div class="card-body d-flex" style="width: 915px;">
                        <div class="table-responsive">
                            <label for="expiry_date"><b> <span style="color:green">START </span> STRIKE PRICE :</b></label>
                            <select style="width: 234px; height: 37px; color: #a37213;" id="starting">
                                @foreach ($putArr as $key => $value)
                                    <option value="{{ $value['value'] }}">{{ $value['value'] }}</option>
                                @endforeach


                            </select>
                        </div>
                        <div class="table-responsive">
                            <label for="expiry_date"><b> <span style="color:red">END </span> STRIKE PRICE :</b></></label>
                            
                            <select style="width: 234px; height: 37px; color: #a37213;" id="ending">
                                @foreach ($putArr as $key => $value)
                                    <option value="{{ $value['value'] }}">{{ $value['value'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button"  id="result" class="btn btn-secondary">Result</button>
                      
                    </div>
                </div>
            </div>

        </div>




    </div>





    <div style="text-align: center;">
        <div class="">
            @if (isset($putArr) && !empty($putArr))
                <div class="d-flex  ">
                    <table>
                        <!-- Call options table -->
                        <thead>
                            <tr>
                                <td style="color: red">
                                    <b> Calls</b>
                                </td>
                            </tr>
                            <tr>
                                <th style="color:#9d007b">SR</th>
                                <th>Open Intrest</th>
                                <th>OPENINTERESTCHANGE<br> (Change In Oi)</th>
                                <th>TOTALQTYTRADED<br> (Volume)</th>
                                <th>PRICECHANGE%</th>
                                <th>LASTTRADEPRICE</th>
                            </tr>
                        </thead>
                        <tbody id="updated_call_container"></tbody>
                        <tbody class="callCurrentData">

                            <?php
                                $totalCallsOpenInterest = 0;
                                $totalCallsOpenInterestChange = 0;
                                $totalCallsTotalQtyTraded = 0;

                                foreach ($callArr as $key => $value) {
                                $totalCallsOpenInterest += $value['OPENINTEREST'];
                                $totalCallsOpenInterestChange += $value['OPENINTERESTCHANGE'];
                                $totalCallsTotalQtyTraded += $value['TOTALQTYTRADED'];
                            ?>

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $value['OPENINTEREST'] }}</td>
                                <td>{{ $value['OPENINTERESTCHANGE'] }}</td>
                                <td>{{ $value['TOTALQTYTRADED'] }}</td>
                                <td>{{ $value['PRICECHANGEPERCENTAGE'] }}</td>
                                <td>{{ $value['LASTTRADEPRICE'] }}</td>
                            </tr>
                            <?php } ?>
                            <!-- Add a new row to display the total counts for calls -->

                            <tr>
                                <td style="background-color: #fff;"></td>
                                <td style="color: red"><b>{{ $totalCallsOpenInterest }} oi</b></td>
                                <td style="color: red"><b>{{ $totalCallsOpenInterestChange }}cioi</b></td>
                                <td style="color: red"><b>{{ $totalCallsTotalQtyTraded }} </b> Traded </td>
                                <td style="background-color: #fff;"></td>
                                <td style="background-color: #fff;"><b></b></td>
                            </tr>

                        </tbody>
                    </table>
                    <table>
                        <!-- Put options table -->
                        <thead>
                            <tr>
                                <td style="color: green">
                                    <b> Puts</b>
                                </td>
                            </tr>
                            <tr>

                                <th style="color:#9d007b">STRIKE PRICE</th>
                                <th>LASTTRADEPRICE</th>
                                <th>PRICECHANGE%</th>
                                <th>TOTALQTYTRADED<br> (Volume)</th>
                                <th>OPENINTERESTCHANGE<br> (Change In Oi)</th>
                                <th>Open Intrest</th>
                            </tr>
                        </thead>

                        <tbody id="updated_put_container"></tbody>
                        <tbody class="putCurrentData">
                            <?php
                                $totalPutsOpenInterest = 0;
                                $totalPutsOpenInterestChange = 0;
                                $totalPutsTotalQtyTraded = 0;

                                foreach ($putArr as $key => $value) {
                                    $totalPutsOpenInterest += $value['OPENINTEREST'];
                                    $totalPutsOpenInterestChange += $value['OPENINTERESTCHANGE'];
                                    $totalPutsTotalQtyTraded += $value['TOTALQTYTRADED'];
                            ?>
                            <tr>

                                <td>{{ $value['value'] }}</td>
                                <td>{{ $value['LASTTRADEPRICE'] }}</td>
                                <td>{{ $value['PRICECHANGEPERCENTAGE'] }}</td>
                                <td>{{ $value['TOTALQTYTRADED'] }}</td>
                                <td>{{ $value['OPENINTERESTCHANGE'] }}</td>
                                <td>{{ $value['OPENINTEREST'] }}</td>
                            </tr>
                            <?php } ?>
                            <!-- Add a new row to display the total counts for puts -->
                            <tr>
                                <td style="color: green"><b>-: Total :-</b></td>
                                <td style="background-color: #fff;"></td>

                                <td style="background-color: #fff;"></td>
                                <td style="color: green"><b> {{ $totalPutsTotalQtyTraded }} Traded</td>
                                <td style="color: green"><b>{{ $totalPutsOpenInterestChange }} cioi</b></td>
                                <td style="color: green"><b>{{ $totalPutsOpenInterest }} oi</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p>No option chain data available</p>
            @endif
        </div>
    </div>
    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 70%;
                border-radius: 5px;
            }
        }
    </style>
    <script>
        $(function() {
            table = $('#manage_all').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/admin/allBlogs',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'file_path',
                        name: 'file_path'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "columnDefs": [{
                    "className": "",
                    "targets": "_all"
                }],
                "autoWidth": false,
            });
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                'width': '220px',
                'height': '30px'
            });
        });
    </script>
    <script type="text/javascript">
        $("#expiry_date").change(function() {
            const selectedOption = $(this).val();
            $.ajax({
                url: '{{ URL::to('get-finnfitywithDt') }}/' + selectedOption,
                type: 'GET',
                success: function(response) {

                    let updatedHtml = '<div class="d-flex "><table>';
                    response.callArr.forEach(function(item, key) {
                        updatedHtml += '<tr>';
                        updatedHtml += '<td>' + key + 1 + '</td>';
                        updatedHtml += '<td>' + item.OPENINTEREST + '</td>';
                        updatedHtml += '<td>' + item.OPENINTERESTCHANGE + '</td>';
                        updatedHtml += '<td>' + item.TOTALQTYTRADED + '</td>';
                        updatedHtml += '<td>' + item.PRICECHANGEPERCENTAGE + '</td>';
                        updatedHtml += '<td>' + item.LASTTRADEPRICE + '</td>';
                        updatedHtml += '</tr>';
                    });
                    updatedHtml += '</table></div>';
                    $("#updated_call_container").html(updatedHtml);
                    $(".callCurrentData").hide();

                    let updatedHtml1 = '<div class="d-flex "><table>';
                    response.putArr.forEach(function(item) {
                        updatedHtml1 += '<tr>';

                        updatedHtml1 += '<td>' + item.value + '</td>';
                        updatedHtml1 += '<td>' + item.LASTTRADEPRICE + '</td>';
                        updatedHtml1 += '<td>' + item.PRICECHANGEPERCENTAGE + '</td>';
                        updatedHtml1 += '<td>' + item.TOTALQTYTRADED + '</td>';
                        updatedHtml1 += '<td>' + item.OPENINTERESTCHANGE + '</td>';
                        updatedHtml1 += '<td>' + item.OPENINTEREST + '</td>';
                        updatedHtml1 += '</tr>';
                    });
                    updatedHtml1 += '</table></div>';
                    $("#updated_put_container").html(updatedHtml1);
                    $(".putCurrentData").hide();


                    console.log(response);
                },
                error: function(error) {

                    console.log(error);
                }
            });

        });


        $("#result").click(function(e) {
            let starting = $("#starting").val();
            let ending = $("#ending").val();
            let selectedDt = $("#expiry_date").val();
            $.ajax({
                url: '{{ URL::to('get-finnfitywithDt') }}/' + selectedDt,
                type: 'GET',
                data: {
                    starting: starting,
                    ending: ending
                },
                success: function(response) {
                    let updatedHtml = '<div class="d-flex "><table>';
                    response.callArr.forEach(function(item, key) {
                        console.log(item)
                        updatedHtml += '<tr>';
                        updatedHtml += '<td>' + parseInt(key + 1) + '</td>';
                        updatedHtml += '<td>' + item.OPENINTEREST + '</td>';
                        updatedHtml += '<td>' + item.OPENINTERESTCHANGE + '</td>';
                        updatedHtml += '<td>' + item.TOTALQTYTRADED + '</td>';
                        updatedHtml += '<td>' + item.PRICECHANGEPERCENTAGE + '</td>';
                        updatedHtml += '<td>' + item.LASTTRADEPRICE + '</td>';
                        updatedHtml += '</tr>';
                    });
                    updatedHtml += '</table></div>';
                    $("#updated_call_container").html(updatedHtml);
                    $(".callCurrentData").hide();

                    let updatedHtml1 = '<div class="d-flex "><table>';
                    response.putArr.forEach(function(item) {
                        updatedHtml1 += '<tr>';
                        updatedHtml1 += '<td>' + item.value + '</td>';
                        updatedHtml1 += '<td>' + item.LASTTRADEPRICE + '</td>';
                        updatedHtml1 += '<td>' + item.PRICECHANGEPERCENTAGE + '</td>';
                        updatedHtml1 += '<td>' + item.TOTALQTYTRADED + '</td>';
                        updatedHtml1 += '<td>' + item.OPENINTERESTCHANGE + '</td>';
                        updatedHtml1 += '<td>' + item.OPENINTEREST + '</td>';
                        updatedHtml1 += '</tr>';
                    });
                    updatedHtml1 += '</table></div>';

                    console.log(updatedHtml1)
                    $("#updated_put_container").html(updatedHtml1);
                    $(".putCurrentData").hide();
                },
                error: function(error) {

                    console.log(error);
                }
            });

        })
    </script>
@endsection
