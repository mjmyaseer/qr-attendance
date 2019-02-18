@extends('layout.app_layout')


@section("content")


    <div class="row">
        <div class="col-md-12">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Attendance</div>

                    <div class="panel-options">
                        <a href="." data-rel="reload"><i class="glyphicon glyphicon-refresh"></i></a>
                    </div>
                </div>
                <div class="panel-body">

                    <div id="input_fields_wrap" class="form-group form-inline">
                        <div>
                            <label>Search Attendance By Customer Name/NIC/Phone/Email</label>&nbsp;
                            <input class="form-control"
                                   placeholder="Search"
                                   type="text"
                                   style="widows: 50px;"
                                   name="search_txt"
                                   id="search_txt"/>&nbsp;

                            <button type="button" id="search_button" class="btn btn-info">Search
                            </button>
                            <span id="sear_txt" class="error"></span>
                        </div>
                    </div>

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Event Name</th>
                            <th>NIC</th>
                            <th>Phone</th>
                            <th>Attended Date</th>
                        </tr>
                        </thead>
                        <tbody>
@php
$x = 1;
@endphp
                        @foreach($attendance as $key=>$attendances)
                            <tr class="gradeX">
                                <td>{{$x}}</td>
                                <td>{{$attendances->customer_name}}</td>
                                <td>{{$attendances->event_name}}</td>
                                <td>{{$attendances->customer_nic}}</td>
                                <td>{{$attendances->customer_telephone}}</td>
                                <td>{{$attendances->attended_date}}</td>
                            </tr>
                            @php
                                $x++;
                            @endphp
                        @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        </div>


    </div>

@endsection


@section('js')
    <script src="../js/app/attendance.js"></script>
@endsection