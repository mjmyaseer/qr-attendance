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
                    <div class="panel-title">Manual Attendance</div>

                    <div class="panel-options">
                        <a href="{{url('/secure/branch')}}"
                           data-rel="collapse">Attendance List</a>
                    </div>
                </div>
                <div class="panel-body">


                    <form action="" method="POST" id="frm_branch">
                        {{csrf_field()}}
                        <fieldset>


                            <div class="form-group">
                                <label>Branch Name</label>
                                <input class="form-control"
                                       placeholder="Branch Name"
                                       type="text"
                                       id="branch_name"
                                       name="branch_name"
                                       value="@php
                                           if (isset($branch[0]->branch_name))
                                   {
                                   echo $branch[0]->branch_name;
                                   }
                                       @endphp"
                                />
                                <span id="cus_name" class="error"></span>
                            </div>


                            <div class="form-group">
                                <label>Telephone</label>
                                <input class="form-control"
                                       placeholder="Telephone"
                                       type="text"
                                       id="branch_phone"
                                       name="branch_phone"
                                       value="@php
                                           if (isset($branch[0]->branch_phone))
                                   {
                                   echo $branch[0]->branch_phone;
                                   }
                                       @endphp"
                                />
                                <span id="branch_phone" class="error"></span>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea style="width: 400px; height: 100px"
                                          id="branch_address"
                                          class="form-control"
                                          placeholder="Address"
                                          name="branch_address" row="3">@php
                                        if (isset($branch[0]->branch_address))
                                {
                                echo $branch[0]->branch_address;
                                }
                                    @endphp</textarea>
                                <span id="add_sp" class="error"></span>
                            </div>


                            {{--<div class="form-group">--}}
                                {{--<label>City Name</label>--}}
                                {{--<select class="form-control" name="supplier_id">--}}
                                    {{--@foreach($suppliers as $supplier)--}}
                                        {{--<option value="{{$supplier->supplier_id}}"--}}
                                                {{--@php--}}
                                                    {{--if (isset($item) && $item[0]->item_supplier_id == $supplier->supplier_id)--}}
                                                    {{--{--}}
                                                    {{--echo 'selected';--}}
                                                    {{--}--}}
                                                {{--@endphp--}}
                                        {{-->{{$supplier->supplier_name}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}

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