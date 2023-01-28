@extends('layouts.admin_layout')

@section('title', 'Show Sells')
@section('content')
    <!-- Page-Title -->

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-inline" method="post" action="/report/sell"
                                  enctype="multipart/form-data">

                                <div class="form-group col-md-4">
                                    <label class="col-5 col-form-label">From Date</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="from_date"
                                               placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="col-5 col-form-label">To Date</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="to_date" placeholder="mm/dd/yyyy"
                                               id="datepicker" required>

                                    </div>
                                </div>


                                <div class="form-group mb-0 justify-content-end row col-md-4">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-info waves-effect waves-light">Search
                                        </button>
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
                        <h4>View Sells</h4>

                    </div>

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
                            <th>#</th>
                            <th>Total Price</th>
                            <th>Given Amount</th>
                            <th>Change</th>
                            <th>Due</th>
                            <th>Paid Status</th>
                            <th>Discount</th>
                            <th>Date</th>
                            <th>Show</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php($i=1)
                        @foreach($result as $res)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$res->grand_total_price}}</td>
                                <td>{{$res->given_amount}}</td>
                                <td>{{$res->change}}</td>
                                <td>{{$res->grand_total_price-($res->given_amount-$res->change)}}</td>
                                <td>
                                    @if($res->paid_status==1)
                                        <span class="label label-info">Paid</span>
                                    @else
                                        <span class="label label-danger">Due</span>
                                    @endif
                                </td>
                                <td>{{$res->discount_amount}}</td>
                                <td>{{ date('d-M-Y', strtotime($res->created_at)) }}</td>
                                <td><a href="/sells/details/{{$res->invoice}}"
                                       class="btn btn-sm btn-primary waves-effect waves-light">Show</a></td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                @endif
            </div>
            <!-- end row -->


        </div> <!-- end card-box -->
    </div><!-- end col -->


@endsection
