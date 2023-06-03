@extends('frontend.layouts.master')

@section('title', 'finnifty')
@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>FINNIFTY- Option Chain</div>
                <div class="d-inline-block ml-2">
                    @can('blogs-create')
                        <button class="btn btn-success" onclick="create()"><i class="glyphicon glyphicon-plus"></i>
                            New Blogs
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="table-responsive">
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
                </div>
            </div>
        </div>
    </div>
    <div style="text-align: center;">

        @if (isset($data) && !empty($data))

        <table style=" margin: auto;">
            <thead>
                <tr>
                    <th style="color:green ; text-align: center"colspan='8'>Calls</th>
                    <th colspan='1'></th>
                    <th style="color:red ; text-align: center" colspan='7'>Puts</th>
                    
                </tr>
                <tr>
                    <th style="color:#ff5200">Chain Name </th>
                    <th>Date</th>
                    <th>OI</th>
                    <th>CHNG IN OI</th>
                    <th>VOLUME</th>
                    <th>IV</th>
                    <th>CHNG</th>
                    <th>LTP</th>
                    <th style="color:#9d007b">STRIKE</th>

                    
                    <th>LTP</th>
                    <th>CHNG</th>
                    <th>IV</th>
                    <th>VOLUME</th>
                    <th>CHNG IN OI</th>
                    <th>OI</th>
                    <th>Date</th>
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
                        <td>{{ $option['CE']['underlying'] }}</td>
                            <td>{{ $option['expiryDate'] }}</td>
    

                            <td>{{ $option['CE']['openInterest'] }}</td>
                            <td>{{ $option['CE']['changeinOpenInterest'] }}</td>
                            <td>{{ $option['CE']['totalTradedVolume'] }}</td>
                            <td>{{ $option['CE']['impliedVolatility'] }}</td>
                            <td>{{ $option['CE']['change'] }}</td>
                            <td>{{ $option['CE']['lastPrice'] }}</td>
                            <td>{{ $option['strikePrice'] }}</td>
                           
                            <td>{{ $option['PE']['lastPrice'] }}</td>
                            <td>{{ $option['PE']['change'] }}</td>
                            <td>{{ $option['PE']['impliedVolatility'] }}</td>
                            <td>{{ $option['PE']['totalTradedVolume'] }}</td>
                            <td>{{ $option['PE']['changeinOpenInterest'] }}</td>
                            <td>{{ $option['PE']['openInterest'] }}</td>
                            <td>{{ $option['PE']['expiryDate'] }}</td>
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
        function create() {
            ajax_submit_create('blogs');
        }

        $(document).ready(function() {
            // View Form
            $("#manage_all").on("click", ".view", function() {
                var id = $(this).attr('id');
                ajax_submit_view('blogs', id)
            });

            // Edit Form
            $("#manage_all").on("click", ".edit", function() {
                var id = $(this).attr('id');
                ajax_submit_edit('blogs', id)
            });


            // Delete
            $("#manage_all").on("click", ".delete", function() {
                var id = $(this).attr('id');
                ajax_submit_delete('blogs', id)
            });

        });
    </script>
    
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
