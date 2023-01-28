@extends('layouts.admin_layout')

@section('title', 'Show Sells')
@section('content')
    <!-- Page-Title -->
    {{--
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Sells</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">View Sells</a></li>
                </ol>

            </div>
        </div>
    --}}


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-inline" method="get" action="/sell/list"
                                  enctype="multipart/form-data" autocomplete="off">

                                <div class="form-group">
                                    <label class="col-form-label">From Date</label>

                                    <input type="text" class="form-control" name="from_date"
                                           placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">To Date</label>

                                    <input type="text" class="form-control" name="to_date" placeholder="mm/dd/yyyy"
                                           id="datepicker" required>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                </div>

                                <div class="dropdown show col-md-2">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        Filter By
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="/sell/list/due">Due</a>
                                        <a class="dropdown-item" href="/sell/list/paid">Paid</a>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>View Sells


                            @isset($from_date)
                                <span class="small">(from {{ $from_date }} to {{ $to_date }})</span>
                            @endisset


                        </h4>

                    </div>
                    {{--<div class="col-sm-6">
                        <a href="/supplier/create" class="btn btn-sm btn-primary pull-right"><i
                                    class="md md-add"></i> Add New</a>
                    </div>--}}
                </div>

                <hr>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{session('success')}}!</strong>
                    </div>
                @endif
                @if(session('failed'))
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{session('failed')}}!</strong>
                    </div>
                @endif

                @if(isset($result))
                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            {{-- <th>Customer Email</th>--}}
                            <th> Phone</th>
                            <th> Address</th>
                            {{-- <th>Company</th>--}}
                            <th>Price</th>
                            <th>Paid</th>
                            <th>Change</th>
                            <th>Due</th>
                            {{-- <th>Given Amount</th>--}}
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Operator</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php($i=1)
                        @foreach($result as $res)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$res->customer_name}}</td>
                                {{-- <td>{{$res->customer_email}}</td>--}}
                                <td>{{$res->customer_phone}}</td>
                                <td>{{$res->customer_address}}</td>
                                {{-- <td>{{$res->customer_company}}</td>--}}
                                <td>{{$res->grand_total_price}}</td>
                                <td>{{($res->given_amount)+ getPayment($res->invoice)}}</td>
                                <td>{{$res->change}}</td>
                                <td>
                                    @if($res->paid_status==1)
                                        <span class="label label-success">Paid</span>
                                    @else
                                        <span
                                            class="text-danger"> {{$res->grand_total_price- ($res->given_amount+getPayment($res->invoice)+$res->discount_amount)}}</span>

                                    @endif
                                </td>
                                {{-- <td>{{$res->given_amount}}</td>--}}
                                {{-- <td>{{$res->change}}</td>--}}
                                <td>{{$res->discount_amount}}</td>

                                <td>
                                    @if($res->paid_status==1)
                                        <span class="label label-success">Paid</span>
                                    @else

                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                                data-toggle="modal" data-target="#{{$res->sell_id}}">
                                            Due Pay
                                        </button>
                                    @endif
                                </td>
                                <td>{{$res->user_name}}</td>
                                <td>{{$res->created_at}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-danger dropdown-toggle waves-effect waves-light"
                                            data-toggle="dropdown" aria-expanded="false">Action<span
                                            class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="/sells/delete/{{$res->invoice}}"
                                           onclick="return confirm('Are you sure you want to delete this item')"><i
                                                class="fa fa-trash"></i> Delete</a>
                                        <a class="dropdown-item"
                                           href="/sells/details/{{$res->invoice}}"><i
                                                class="fa fa-align-right"></i> View Details</a>

                                        <a class="dropdown-item"
                                           href="/sells/payment/details/{{$res->invoice}}"><i
                                                class="fa fa-align-right"></i> View Payments</a>
                                    </div>
                                </td>

                            </tr>

                            <div class="modal fade" tabindex="-1" id="{{$res->sell_id}}" role="dialog"
                                 aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Pay Now</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                ×
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form class="form-horizontal" method="post"
                                                  action="/sell/pay"
                                                  enctype="multipart/form-data">

                                                <div class="form-group row" style="display: none">
                                                    <label class="col-3 col-form-label">ID</label>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control" name="sell_id"
                                                               value="{{$res->sell_id}}">
                                                        <input type="hidden" class="form-control" name="_token"
                                                               value="{{csrf_token()}}">
                                                        <input type="hidden" class="form-control" name="invoice"
                                                               value="{{$res->invoice}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="display: none">
                                                    <label class="col-3 col-form-label">given_amount</label>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control" name="given_amount"
                                                               value="{{$res->given_amount}}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-5 col-form-label">Pay Amount</label>
                                                    <div class="col-7">
                                                        <input type="text" class="form-control" name="pay_amount"
                                                               value="{{$res->grand_total_price- ($res->given_amount+getPayment($res->invoice)+$res->discount_amount)}}">
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0 justify-content-end row">
                                                    <div class="col-7">
                                                        <button type="submit"
                                                                class="btn btn-info waves-effect waves-light">Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                        @endforeach
                        </tbody>
                    </table>


                @endif
            </div>
            <!-- end row -->


        </div> <!-- end card-box -->
    </div><!-- end col -->

    <!-- end row -->


@endsection
