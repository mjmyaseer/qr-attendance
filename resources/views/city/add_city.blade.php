@extends('layout.app_layout')


@section("content")


    <div class="row">
        <div class="col-md-12">
            <div class="content-box-large">
                <div class="panel-heading">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="panel-title">City</div>

                    <div class="panel-options">
                        <a href="{{url('/secure/city')}}"
                           data-rel="collapse">City</a>
                    </div>
                </div>
                <div class="panel-body">


                    <form action="" method="POST" id="frm_city">
                        {{csrf_field()}}
                        <fieldset>


                            <div class="form-group">
                                <label>City Name</label>
                                <input class="form-control"
                                       placeholder="City Name"
                                       type="text"
                                       id="city_name"
                                       name="city_name"
                                       value="@php
                                           if (isset($city[0]->city_name))
                                   {
                                   echo $city[0]->city_name;
                                   }
                                       @endphp"
                                />
                                <span id="city_name" class="error"></span>
                            </div>

                        </fieldset>
                        <div>
                            <button class="btn btn-primary" type="submit" id="submit">
                                <i class="fa fa-save"></i>
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('js')
    <script src="../js/app/customers.js"></script>

@endsection