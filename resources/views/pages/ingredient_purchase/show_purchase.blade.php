@extends('layouts.admin_layout')

@section('title', 'Show Purchase')
@section('content')
    <!-- Page-Title -->
    {{--    <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Purchase</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">View Purchase</a></li>
                </ol>

            </div>
        </div>--}}

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-inline" method="post" action="/ingredient/purchase/search"
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


                                <div class="form-group mb-0 justify-content-end">

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
                        <h4>View Purchase</h4>

                    </div>
                    <div class="col-sm-6">
                        <a href="/ingredient/purchase/create" class="btn btn-sm btn-primary pull-right"><i
                                class="md md-add"></i> Add New</a>
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
                            <th>SL</th>
                            <th>Purpose</th>
                            <th>Measurement</th>
                            <th>Total Price</th>
                            <th>Notes</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php($i=1)
                        @foreach($result as $res)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$res->purpose}}</td>
                                <td>{{$res->measurement}}</td>
                                <td>{{$res->total_price}} Tk</td>
                                <td>{{$res->notes}}</td>
                                <td>{{$res->created_at}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-danger dropdown-toggle waves-effect waves-light"
                                            data-toggle="dropdown" aria-expanded="false">Action<span
                                            class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="/ingredient/purchase/edit/{{$res->ingredient_id}}"><i
                                                class="fa fa-edit"></i> Edit</a>
                                        <a class="dropdown-item"
                                           href="/ingredient/purchase/destroy/{{$res->ingredient_id}}" onclick="return confirm('Are you sure you want to delete this item')"><i
                                                class="fa fa-remove"></i> Delete</a>
                                    </div>
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                @endif
            </div>
            <!-- end row -->


        </div> <!-- end card-box -->
    </div><!-- end col -->
    </div>
    <!-- end row -->

@endsection
