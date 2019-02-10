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
                    <div class="panel-title">User Event</div>

                    <div class="panel-options">
                        <a href="{{url('/secure/userEvent')}}"
                           data-rel="collapse">User Event</a>
                    </div>
                </div>
                <div class="panel-body">


                    <form action="" method="POST" id="frm_city">
                        {{csrf_field()}}
                        <fieldset>


                            <div class="form-group">
                            <label>Event Name</label>
                            <select class="form-control" name="event_id">
                            @foreach($userEvent as $item)
                            <option value="{{$item->event_id}}">{{$item->event_name}}</option>
                            @endforeach
                            </select>
                            </div>

                            <div class="form-group">
                            <label>Customer Name</label>
                            <select class="form-control" name="customer_id">
                            @foreach($customers as $item)
                            <option value="{{$item->customer_id}}">{{$item->customer_name}}</option>
                            @endforeach
                            </select>
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