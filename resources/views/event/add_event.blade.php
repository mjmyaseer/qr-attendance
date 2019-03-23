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
                    <div class="panel-title">Event</div>

                    <div class="panel-options">
                        <a href="{{url('/secure/city')}}"
                           data-rel="collapse">Event</a>
                    </div>
                </div>
                <div class="panel-body">


                    <form action="" method="POST" id="frm_city">
                        {{csrf_field()}}
                        <fieldset>


                            <div class="form-group">
                                <label>Event Name</label>
                                <input class="form-control"
                                       placeholder="Event Name"
                                       type="text"
                                       id="event_name"
                                       name="event_name"
                                       value="{{ old('event_name') }}@php
                                           if (isset($city[0]->event_name))
                                   {
                                   echo $city[0]->event_name;
                                   }
                                       @endphp"
                                />
                                <span id="event_name" class="error"></span>
                            </div>

                            <div class="form-group">
                                <label>Event Start Date</label>
                                <input class="form-control"
                                       placeholder="Event Date"
                                       type="date"
                                       id="event_date"
                                       name="event_date"
                                       value="{{ old('event_date') }}@php
                                           if (isset($city[0]->event_date))
                                   {
                                   echo $city[0]->event_date;
                                   }
                                       @endphp"
                                />
                                <span id="event_date" class="error"></span>
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