@extends('frontend.layouts.master')

@section('title', 'FinNifty')
@section('content')

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

        @if (isset($putArr) && !empty($putArr))
            <div class="d-flex ">

                <table>
                    <thead>
                        <tr>
                            <td style="color: red">
                                <b> Calls</b>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Open Intrest</th>
                            <th>OPENINTERESTCHANGE<br> (Change In Oi)</th>
                            <th>TOTALQTYTRADED<br> (Volume)</th>
                            <th>PRICECHANGE</th>
                            <th>LASTTRADEPRICE</th>






                        </tr>
                    </tbody>
                    <?php foreach($callArr as $key=>$value) { ?>

                    <tr>

                        <td>{{ $value['OPENINTEREST'] }}</td>
                        <td>{{ $value['OPENINTERESTCHANGE'] }}</td>
                        <td>{{ $value['TOTALQTYTRADED'] }}</td>
                        <td>{{ $value['PRICECHANGE'] }}</td>
                        <td>{{ $value['LASTTRADEPRICE'] }}</td>




                    </tr>
                    <?php } ?>
                </table>


                <table>
                    <thead>
                        <tr>
                            <td style="color:green">
                                <b> Puts</b>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th style="color:#9d007b">STRIKE PRICE</th>
                            <th>LASTTRADEPRICE</th>
                            <th>PRICECHANGE</th>
                            <th>TOTALQTYTRADED<br> (Volume)</th>
                            <th>OPENINTERESTCHANGE<br> (Change In Oi)</th>
                            <th>Open Intrest</th>





                        </tr>
                    </tbody>
                    <?php foreach($putArr as $key=>$value) { ?>

                    <tr>

                        <td>{{ $value['value'] }}</td>
                        <td>{{ $value['LASTTRADEPRICE'] }}</td>
                        <td>{{ $value['PRICECHANGE'] }}</td>
                        <td>{{ $value['TOTALQTYTRADED'] }}</td>
                        <td>{{ $value['OPENINTERESTCHANGE'] }}</td>
                        <td>{{ $value['OPENINTEREST'] }}</td>
                    </tr>
                    <?php } ?>
                </table>


            </div>
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

        $("#expiry_date").change(function() {
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
























{{-- 

@extends('frontend.layouts.master')

@section('title', 'FinNifty')
@section('content')

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

        @if (isset($putArr) && !empty($putArr))
            <div class="d-flex ">
                <table>
                    <thead>
                        <tr>
                            <td style="color:green">
                                <b> Puts</b>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <th>Open Intrest</th>
                            <th>OPENINTERESTCHANGE<br> (Change In Oi)</th>
                            <th>TOTALQTYTRADED<br> (Volume)</th>
                            <th>PRICECHANGE</th>
                            <th>LASTTRADEPRICE</th>
                            <th style="color:#9d007b">STRIKE PRICE</th>
                        </tr>
                    </tbody>
                    <?php foreach($putArr as $key=>$value) { ?>

                    <tr>

                        <td>{{ $value['OPENINTEREST'] }}</td>
                        <td>{{ $value['OPENINTERESTCHANGE'] }}</td>
                        <td>{{ $value['TOTALQTYTRADED'] }}</td>
                        <td>{{ $value['PRICECHANGE'] }}</td>
                        <td>{{ $value['LASTTRADEPRICE'] }}</td>
                        <td>{{ $value['value'] }}</td>
                    </tr>
                    <?php } ?>
                </table>

                <table>
                    <thead>
                        <tr>
                            <td style="color: red">
                                <b> Calls</b>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>LASTTRADEPRICE</th>
                            <th>PRICECHANGE</th>
                            <th>TOTALQTYTRADED<br> (Volume)</th>
                            <th>OPENINTERESTCHANGE<br> (Change In Oi)</th>
                            <th>Open Intrest</th>






                        </tr>
                    </tbody>
                    <?php foreach($callArr as $key=>$value) { ?>

                    <tr>

                        <td>{{ $value['LASTTRADEPRICE'] }}</td>
                        <td>{{ $value['PRICECHANGE'] }}</td>
                        <td>{{ $value['TOTALQTYTRADED'] }}</td>
                        <td>{{ $value['OPENINTERESTCHANGE'] }}</td>
                        <td>{{ $value['OPENINTEREST'] }}</td>




                    </tr>
                    <?php } ?>
                </table>
            </div>
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

        $("#expiry_date").change(function() {
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


@endsection --}}
