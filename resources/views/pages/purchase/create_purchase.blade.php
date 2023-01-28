@extends('layouts.admin_layout')

@section('title', 'Create Purchase')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Purchase</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">New Purchase</a></li>
            </ol>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">New Purchase</h4>
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row" ng-controller="AppController">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-horizontal" method="post" action="/purchase/store"
                                  enctype="multipart/form-data" >

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Product</label>
                                    <div class="col-10">
                                        @if(isset($product))

                                            @if(count($product)<=0)
                                                <a href="/products/create" class="btn btn-info">+ Add
                                                    Product First To Continue</a>
                                            @else
                                                <select name="product_details_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    <option>SelectA Product First</option>
                                                    @foreach( $product as $product)
                                                        <option value="{{ $product->product_details_id}}">
                                                            {{ $product->product_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif

                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Supplier</label>
                                    <div class="col-10">
                                        @if(isset($suppliers))

                                            @if(count($suppliers)<=0)
                                                <a href="/supplier/create" class="btn btn-info">+ Add
                                                    Supplier First To Continue</a>
                                            @else
                                                <select name="supplier_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    <option>SelectA Supplier First</option>
                                                    @foreach( $suppliers as $suppliers)
                                                        <option value="{{ $suppliers->supplier_id}}">
                                                            {{ $suppliers->supplier_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif

                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Product Quantity</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="quantity" ng-change="changeValue()"ng-model="quantity">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Unit Price</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="unit_price" ng-change="changeValue()" ng-model="unit_price">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Total Price</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="total_price" ng-model="total_price" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Notes</label>
                                    <div class="col-10">
                                        <textarea type="text" class="form-control" name="notes"></textarea>
                                    </div>
                                </div>

                                <div class="form-group mb-0 justify-content-end row">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div> <!-- end card-box -->
        </div><!-- end col -->
    </div>
    <!-- end row -->





    <script>
         var app= angular.module('sposApp', []);

        app.controller('AppController', function($scope){
            // $scope.total_price= $scope.quantity * $scope.unit_price;


            $scope.changeValue=function(){
                 $scope.total_price= $scope.quantity * $scope.unit_price;
                 console.log($scope.total_price);
            }
        });
    </script>

@endsection
