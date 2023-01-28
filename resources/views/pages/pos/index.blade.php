@extends('layouts.admin_layout')

@section('title', 'POS')
@section('content')

    <div ng-controller="posController">
        <div class="row">
            <div class="col-5">

                <div class="card-box">
                    <div class="row">

                        <div class="col-lg-12">
                            <form name="myForm">


                                <div class="form-group  ">
                                    <div class=" row ">
                                        <div class="col-md-10 customer-input">

                                            <select class="myselect form-control" name="customer_id" ng-model="customer_id">

                                                <option ng-repeat="customer in customers" value="[- customer.customer_id-]">
                                                    [- customer.customer_name -]
                                                </option>

                                                {{-- @foreach( $users as $user)
                                                     <option value="{{ $user->customer_id}}">
                                                         {{ $user->customer_name }}
                                                     </option>
                                                 @endforeach--}}

                                            </select>

                                        </div>
                                        <div class="col-md-2 customer-input">
                                            <button class="btn btn-success" data-toggle="modal"
                                                    data-target="#myModal">
                                                +{{__("message.New")}}
                                            </button>
                                        </div>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <input name="productItem" ng-model="productItem" type="text"
                                           ng-keyup="$event.keyCode == 13 && addProduct2(productItem)"
                                           placeholder="Search Product by Name/Code."
                                           uib-typeahead="state as state.product_name for state in {{$products}} | filter:{product_name:$viewValue} | limitTo:8"
                                           typeahead-template-url="customTemplate" class="form-control  m-b-5 pos-input"
                                           id="productItem">

                                </div>
                            </form>
                            <script type="text/ng-template" id="customTemplate">
                                <a href="">
                                    <span ng-bind-html="match.label | uibTypeaheadHighlight:query"></span>
                                    <span> </span>
                                </a>
                            </script>


                            {{--<form role="form">
                                <div class="form-group contact-search m-b-0">
                                    <input type="text" id="search" class="form-control product-search" placeholder="Search product...">
                                    <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                                </div> <!-- form-group -->
                            </form>--}}
                        </div>

                    </div>
                    <br>
                    <table class="table">

                        <tr>
                            {{--  <th>Sl</th>--}}
                            <th>+{{__("message.Product")}}</th>
                            <th>+{{__("message.Qnt")}}</th>
                            <th>+{{__("message.Unit")}}</th>
                            <th>+{{__("message.Price")}}</th>
                            <th>{{__("message.Action")}}</th>
                        </tr>

                        <tr ng-cloak ng-repeat="product in productList">

                            {{-- <td>[- $index+1 -]</td>--}}
                            <td>[- product.product_name -]</td>
                            <td><input style="width: 60px" type="number" id="" name="product.qnt" ng-model="product.qnt"
                                       class="form-control" placeholder="1"></td>
                            <td>[- product.product_retail_price -]</td>
                            <td>[- getPrice(product.product_retail_price , product.qnt) -]</td>
                            <td style="cursor: pointer;"><a ng-click="removeProduct(product)"
                                                            class="table-action-btn text-danger"><i
                                            class="md md-close"></i></a></td>
                        </tr>


                        <tr>
                            <td colspan="1" style="font-weight: bold">{{__("message.discount")}}</td>
                            <td colspan="2"><input type="number" id="" name="discount" ng-model="discount"
                                                   class="form-control" placeholder="0" value="0"></td>
                            <td style="font-weight: bold">{{__("message.Vat")}}</td>
                            <td><input type="number" id="" name="vat" ng-model="vat"
                                       class="form-control" placeholder="0" value="{{$vat}}"></td>
                        </tr>

                        <tr>
                            <td colspan="1" style="font-weight: bold">{{__("message.GivenAmount")}}</td>
                            <td colspan="2"><input type="number" id="" name="given_amount" ng-model="given_amount"
                                                   class="form-control" placeholder="0" required></td>
                            <td style="font-weight: bold">{{__("message.Change")}}</td>
                            <td class="ng-cloak">[- change() -] Tk</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="font-weight: bold;color: #BD2130">{{__("message.TotalPayment")}}</td>
                            <td class="ng-cloak" style="font-weight: bold;color: #BD2130">[- totalSum() -] Tk</td>
                        </tr>
                        {{-- <tr>
                            <td colspan="3" style="font-weight: bold">Paid Status</td>
                            <td colspan="2">
                                <div class="mt-3">
                                    <div class="custom-control custom-radio">
                                        <input id="customRadio1" class="custom-control-input" type="radio"
                                               name="paid_status" ng-model="paid_status" value="paid">
                                        <label class="custom-control-label" for="customRadio1">Paid</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="customRadio2" class="custom-control-input" type="radio"
                                               name="paid_status" ng-model="paid_status" value="due">
                                        <label class="custom-control-label" for="customRadio2">Due</label>
                                    </div>
                                </div>
                            </td>
                        </tr> --}}
                        <tr>
                            {{-- <td colspan="2">
                                 <button type="button" ng-click="addPayment()"
                                         class="btn btn-block btn-lg btn-danger waves-effect waves-light">Hold
                                 </button>
                             </td>--}}
                            <td colspan="5">
                                <button type="button" ng-click="addPayment()"
                                        class="btn btn-block btn-lg btn-primary waves-effect waves-light">{{__("message.Payment")}}
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="col-7">
                <div class="card-box">
                    {{--<h4 class="m-t-0 header-title">New Sell</h4>
                    <hr>--}}

                    <div class="row">
                        <div class="col-12">
                            <div class="p-20">
                                <button class="active btn btn-primary btn-xs waves-effect waves-light"
                                        onclick="filterSelection('all')"> {{__("message.ShowAll")}}
                                </button>
                                @foreach($categories as $category)
                                    <button class="btn btn-primary btn-xs waves-effect waves-light"
                                            onclick="filterSelection('category_{{$category->product_category_id}}')">{{$category->product_category_name}}</button>
                                @endforeach

                            </div>
                            <hr style="margin-top: -10px;margin-bottom: -18px;">
                            <div class="">
                                @foreach($products as $product)


                                    <div class="col-md-4 pull-right filterDiv category_{{$product->product_category_id}}"
                                         ng-click="addProduct('{{ $product }}')" style="cursor: pointer;">
                                        <div class="product-list-box thumb">

                                            <a href="javascript:void(0);" class="image-popup" title="Screenshot-1">
                                                @if (file_exists('/images/products/' .  $product->product_image ))
                                                    <img src="/images/products/{{ $product->product_image }}"
                                                         class="thumb-img"
                                                         alt="work-thumbnail">
                                                @else
                                                    <img src="/images/products/{{$product->product_image}}"
                                                         class="thumb-img"
                                                         alt="work-thumbnail">
                                                @endif
                                            </a>


                                            {{--<div class="price-tag">
                                                @if($product->quantity==0)
                                                <span class="mini-stat-icon bg-danger"><i class="text-black" style="
                                                    font-size: 16px;">{{$product->quantity}}</i></span>



                                                @elseif($product->quantity<=20)
                                                <span class="mini-stat-icon bg-warning"><i class="text-black" style="
                                                    font-size: 16px;">{{$product->quantity}}</i></span>


                                                @else
                                                <span class="mini-stat-icon bg-success"><i class="text-black" style="
                                                    font-size: 16px;">{{$product->quantity}}</i></span>
                                                @endif

                                            </div>--}}
                                            <div class="price-tag" style="margin-right: 94px;">

                                                {{$product->product_retail_price}}TK


                                            </div>




                                            <div class="detail">
                                                <h4 class="m-t-0 font-18"><a href="#"
                                                                             class="text-dark">{{$product->product_name}}</a>
                                                </h4>

                                                {{-- <h5 class="m-0"><span
                                                             class="text-muted"> Id: {{$product->barcode}}</span>
                                                 </h5>--}}
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>

                    </div>
                    <!-- end row -->

                </div> <!-- end card-box -->
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Name</label>
                            <div class="col-10">
                                <input type="text" class="form-control" name="customer_name"
                                       ng-model="customer_name" required>
                                <input type="hidden" class="form-control" name="_token"
                                       value="{{csrf_token()}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input type="text" class="form-control" name="customer_email"
                                       ng-model="customer_email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Phone</label>
                            <div class="col-10">
                                <input type="text" class="form-control" name="customer_phone" required
                                       ng-model="customer_phone">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Address</label>
                            <div class="col-10">
                                <textarea  class="form-control" name="customer_address"
                                           ng-model="customer_address"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 col-form-label">Company</label>
                            <div class="col-10">
                                <input type="text" class="form-control" name="customer_company"
                                       ng-model="customer_company">
                            </div>
                        </div>


                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-10">
                                <button type="submit" class="btn btn-info waves-effect waves-light"
                                        ng-click="customerSave()" data-dismiss="modal">Save
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Product Filter Start-->

    <script>
        filterSelection("all");

        function filterSelection(c) {
            var x, i;
            x = document.getElementsByClassName("filterDiv");
            if (c == "all") c = "";
            for (i = 0; i < x.length; i++) {
                w3RemoveClass(x[i], "show");
                if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
            }
        }

        function w3AddClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                if (arr1.indexOf(arr2[i]) == -1) {
                    element.className += " " + arr2[i];
                }
            }
        }

        function w3RemoveClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                while (arr1.indexOf(arr2[i]) > -1) {
                    arr1.splice(arr1.indexOf(arr2[i]), 1);
                }
            }
            element.className = arr1.join(" ");
        }

        // Add active class to the current button (highlight it)
        var btnContainer = document.getElementById("myBtnContainer");
        var btns = btnContainer.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {

            btns[i].addEventListener("click", function () {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";

            });
        }
    </script>

    <!-- Product Filter End-->

    <script>
        app.controller('posController', ['$scope', '$http', 'toaster', function ($scope, $http, toaster,) {
            $scope.customer_id = '1';
            $scope.productList = [];
            $scope.discount = 0;
            $scope.vat = 0;
            $scope.productItem = '';
            $scope.paid_status_true = true;
            // $scope.paid_status = 'paid';




            $scope.all_products = '{{ ($products) }}';


            $scope.selectpopupvalue = '';


            $scope.addProduct = function (product) {
                //console.log('product');

                var productStringToJson = JSON.parse(product);
                productStringToJson.qnt = 1;

                var index = $scope.productList.findIndex(x => x.product_name === productStringToJson.product_name);
                if (index === -1) {
                    $scope.productList.push(productStringToJson);
                }
            };


            $scope.addProduct2 = function (product) {


                var index = $scope.productList.findIndex(x => x.product_name === product.product_name);
                if (index === -1) {
                    $scope.productList.push(product);
                }

                $scope.productItem=null;
            };


            $scope.addPayment = function () {

                //console.log($scope.customer_id);
                console.log($scope.productList);

               $http({
                    method: 'POST',
                    url: '{{ url('/products/payment') }}',    // url make
                    data: {
                        token: '{{csrf_token()}}',
                        productList: $scope.productList,
                        total_discount: $scope.discount,
                        total_vat: $scope.vat,
                        given_amount: $scope.given_amount,
                        customer_id: $scope.customer_id,
                        paid_status: $scope.paid_status,
                        grand_total_price: $scope.totalSum(),
                        change: $scope.change(),
                    },
                    headers: {'Content-Type': 'application/json'},

                }).then(function (response) {
                    console.log('server-response', response.data);
                    //console.log('server-response', response.data.message);
                    console.log('server-response', response.data.result);
                    if (response.data.status === 'success') {
                        $scope.productList = [];
                        $scope.discount = 0;
                        $scope.vat = 0;
                        $scope.given_amount = 0;
                        toaster.pop('success', "success: " + response.data.message);

                        window.location.href = '/sells/pos/' + response.data.invoice;
                        // console.log("",response.data.result);

                    } else {
                        toaster.pop('error', "failed" + response.data.message);

                    }

                }, function (error) {
                    console.log('server-error', error);
                });

            };

            $scope.removeProduct = function (singleSroduct) {
                console.log('lol', singleSroduct)
                var index = $scope.productList.indexOf(singleSroduct);
                $scope.productList.splice(index, 1);
            };

            $scope.change = function () {
                if (isNaN($scope.given_amount - $scope.totalSum())) {
                    return 0;
                } else {
                    if($scope.given_amount - $scope.totalSum()==0){
                       $scope.paid_status = 'paid';
                    }
                     else{
                      $scope.paid_status = 'due';
                    }
                    return $scope.given_amount - $scope.totalSum();
                }

            };

            $scope.totalSum = function () {
                var total = 0;
                for (var i = 0; i < $scope.productList.length; i++) {
                    var quantity = $scope.productList[i].qnt;
                    if (isNaN(quantity)) {
                        quantity = 1;
                    }
                    total += parseInt($scope.productList[i].product_retail_price * quantity);
                }
                return total - $scope.discount + $scope.vat;
            };


            $scope.getValue = function () {
                return 1;
            };

            $scope.getPrice = function (product_retail_price, qnt) {
                if (isNaN(qnt)) {
                    qnt = 1;
                }
                return product_retail_price * qnt;
            };

            $scope.givenAmount = function () {
                return 0;
            };

            $scope.customerSave = function () {


                console.log($scope.customer_name);

                $http.post('/customer-js/store', {
                    customer_name: $scope.customer_name,
                    customer_email: $scope.customer_email,
                    customer_phone: $scope.customer_phone,
                    customer_address: $scope.customer_address,
                    customer_company: $scope.customer_company,
                }).then(function success(e) {
                    $scope.status = e.data.status;
                    console.log($scope.e);

                    if ($scope.status === "success") {
                        $scope.customer_name = null,
                            $scope.customer_email = null,
                            $scope.customer_phone = null,
                            $scope.customer_address = null,
                            $scope.customer_company = null

                        $scope.getCustomerData();
                        toaster.pop('success', "Customer Added");
                    } else {
                        alert("Customer Not added")
                    }
                });


            };


            $scope.getCustomerData = function () {
                $http.post('/customer/get', {}).then(function success(e) {
                    $scope.customers = e.data.customers;

                    console.log($scope.customers);
                    /* for (let i = 0; i < $scope.customers.length; i++) {
                         console.log($scope.customers[i].customer_name);
                     }*/


                });
            };
            $scope.getCustomerData();


        }]);


    </script>

    <script type="text/javascript">
        $(".myselect").select2();
    </script>


@endsection
