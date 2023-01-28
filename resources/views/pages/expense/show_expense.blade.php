@extends('layouts.admin_layout')

@section('title', 'Expense')
@section('content')
    <!-- Page-Title -->
 {{--   <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Expense</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">View Expense</a></li>
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
                            <form class="form-inline" method="post" action="/ingredient/purchase/search"
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
                        <h4>View Expense</h4>

                    </div>
                    <div class="col-sm-6">
                        <a href="/expense/create" class="btn btn-sm btn-primary pull-right"><i
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
                            <th>Expense Name</th>
                            <th>Expense Amount</th>
                            <th>Expense Category</th>
                            <th>Expense Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php($i=1)
                        @foreach($result as $res)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$res->expense_name}}</td>
                                <td>{{$res->expense_amount}} Tk</td>
                                <td>{{$res->expense_category_name}}</td>
                                <td>{{$res->expense_details}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-danger dropdown-toggle waves-effect waves-light"
                                            data-toggle="dropdown" aria-expanded="false">Action<span
                                                class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="/expense/edit/{{$res->expense_id}}"><i
                                                    class="fa fa-edit"></i> Edit</a>
                                        <a class="dropdown-item"
                                           href="/expense/destroy/{{$res->expense_id}}"><i
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