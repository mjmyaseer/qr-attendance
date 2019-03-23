@extends('layout.app_layout')


@section("content")


    <div class="row">
        <div class="col-md-12">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Cities</div>

                    <div class="panel-options">
                        <a href="{{url('/secure/add-city')}}"
                           data-rel="collapse">Add New City</a>
                        <a href="#" data-rel="reload"><i class="glyphicon glyphicon-refresh"></i></a>
                    </div>
                </div>
                <div class="panel-body">

                    <div id="input_fields_wrap" class="form-group form-inline">
                        <div>
                            <label>Search By City Name</label>&nbsp;
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
                            <th>Id</th>
                            <th>Name</th>
                            <th>Created By</th>
                            <th style="text-align: center">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
@php
$x = 1;
@endphp
                        @foreach($city as $key=>$cities)
                            <tr class="gradeX">
                                <td>{{$x}}</td>
                                <td>{{$cities->city_name}}</td>
                                <td>{{$cities->created_by}}</td>
                                <td style="text-align: center"><a href="{{url("/secure/add-city/{$cities->city_id}")}}" >Edit</a></td>
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
    <script src="../js/app/cityIndex.js"></script>
@endsection