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
                            <form class="form-inline" method="post" action="/report/sell/product"
                                  enctype="multipart/form-data" autocomplete="off">

                                <div class="form-group">
                                    <label class="col-form-label">From Date</label>

                                    <input type="text" class="form-control" name="from_date"
                                           placeholder="mm/dd/yyyy" id="datepicker-autoclose" required>
                                    <input type="hidden" class="form-control" name="_token"
                                           value="{{csrf_token()}}">

                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">To Date</label>

                                    <input type="text" class="form-control" name="to_date" placeholder="mm/dd/yyyy"
                                           id="datepicker" required>
                                </div>


                                <div class="form-group mb-0 justify-content-end row">

                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search
                                    </button>

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
                        <h4>View Sells <span>@isset($from_date)
                                    <span class="small">(From {{ $from_date }} to {{ $to_date }})</span>
                                @endisset</span></h4>


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

                @if(isset($products))
                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php($i=1)
                        @foreach($products as $product)
                            @php($qnt=0)
                            @foreach( $result as $res)
                                @if($product->product_title==$res->product_title)
                                    @php($qnt=$qnt+$res->quantity)
                                @endif
                            @endforeach
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$product->product_title}}</td>
                                <td>{{$qnt}}</td>

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
