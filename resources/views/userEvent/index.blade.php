@extends('layout.app_layout')


@section("content")


    <div class="row">
        <div class="col-md-12">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">User Events</div>

                    <div class="panel-options">
                        <a href="{{url('/secure/add-userEvent')}}"
                           data-rel="collapse">Map New User Event</a>
                        <a href="#" data-rel="reload"><i class="glyphicon glyphicon-refresh"></i></a>
                    </div>
                </div>
                <div class="panel-body">

                    <div id="input_fields_wrap" class="form-group form-inline">
                        <div>
                            <label>Search By Event Name</label>&nbsp;
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

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                           id="example">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Event Name</th>
                            <th>Customer Name</th>
                            <th>Created By</th>
                            <th style="text-align: center">Edit</th>
                            <th style="text-align: center">Print QR</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $x = 1;
                        @endphp
                        @foreach($event as $key=>$event)
                            <tr class="gradeX">
                                <td>{{$x}}</td>
                                <td>{{$event->event_name}}</td>
                                <td>{{$event->customer_name}}</td>
                                <td>{{$event->event_created_by}}</td>
                                <td style="text-align: center"><a href="{{url("/secure/add-userEvent/{$event->event_id}")}}">Edit</a>
                                <td style="text-align: center"><a href="{{url("/secure/qr-code/userEvent/{$event->user_event_id}")}}">Print</a>
                                </td>
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
    <script src="../js/app/userEventIndex.js"></script>
@endsection