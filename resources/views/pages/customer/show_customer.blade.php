@extends('layouts.admin_layout')

@section('title', 'Show Customer')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">{{ __("message.Customer") }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ __("message.ViewCustomer") }}</a></li>
            </ol>

        </div>
    </div>


    <div class="row">
        <div class="col-12">
            @include('includes.message')
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>{{ __("message.ViewCustomer") }}</h4>

                    </div>
                    <div class="col-sm-6">
                        <a href="/customer/create" class="btn btn-sm btn-primary pull-right"><i
                                    class="md md-add"></i> {{ __("message.AddNew") }}</a>
                    </div>
                </div>

                <hr>

                @if(isset($result))
                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __("message.CustomerName") }}</th>
                            <th>{{ __("message.CustomerEmail") }}</th>
                            <th>{{ __("message.CustomerPhone") }}</th>
                            <th>{{ __("message.CustomerAddress") }}</th>
                            <th>{{ __("message.CustomerCompany") }}</th>
                            <th>{{ __("message.Action") }}</th>
                        </tr>
                        </thead>


                        <tbody>
                        @php($i=1)
                        @foreach($result as $res)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$res->customer_name}}</td>
                                <td>{{$res->customer_email}}</td>
                                <td>{{$res->customer_phone}}</td>
                                <td>{{$res->customer_address}}</td>
                                <td>{{$res->customer_company}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-danger dropdown-toggle waves-effect waves-light"
                                            data-toggle="dropdown" aria-expanded="false">Action<span
                                                class="caret"></span></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="/customer/edit/{{$res->customer_id}}"><i
                                                    class="fa fa-edit"></i> {{ __("message.Edit") }}</a>
                                        <a class="dropdown-item"
                                           href="/customer/destroy/{{$res->customer_id}}"><i
                                                    class="fa fa-remove"></i> {{ __("message.Delete") }}</a>
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
