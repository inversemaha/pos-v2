@extends('layouts.admin_layout')

@section('title', 'Show Sells')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="panel-body">
                    {{--<div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-right"><img src="/assets/images/logo_dark.png" alt="velonic"></h4>

                        </div>
                        <div class="pull-right">
                            <h4 class="font-16">Invoice #
                                <strong>{{$details->invoice}}</strong>
                            </h4>
                        </div>
                    </div>
                    <hr>--}}
                    <div class="" style="vertical-align: middle; text-align: center;">
                                <address>

                                    <img src="/image/{{ $outlet->outlet_image }}" class="img-rounded"
                                         alt="Shop image" width="50" height="50"><br>
                                       <strong> {{$outlet->outlet_name}}</strong><br>
                                    {{$outlet->outlet_address}}<br>
                                    <abbr title="Phone">P:</abbr> {{$outlet->outlet_phone}}
                                    {{-- <abbr title="Phone">P:</abbr> {{$details->customer_phone}} --}}

                                </address>
                            </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="pull-left m-t-30">
                                <address>

                                    <strong>{{$details->customer_name}}</strong><br>
                                    {{$details->customer_address}}<br>
                                    <abbr title="Phone">P:</abbr> {{$details->customer_phone}}
                                </address>
                            </div>

                            

                            <div class="pull-right m-t-30">
                                <h4 class="font-16">Invoice #
                                    <strong>{{$details->invoice}}</strong>
                                </h4>
                                <p><strong>Order Date: </strong> {{ date('d-M-Y', strtotime($details->created_at))}}</p>
                                <p class="m-t-10"><strong>Paid Status: </strong> @if($details->paid_status==1)<span
                                            class="label label-default">Paid</span> @else <span
                                            class="label label-info">Pending</span></p> @endif
                                {{-- <p class="m-t-10"><strong>Order ID: </strong> #123456</p>--}}
                            </div>
                        </div>
                    </div>
                    
                    @if($result)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table m-t-30">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            {{--<th>Description</th>--}}
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($i=1)
                                        @foreach($result as $res)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$res->product_title}}</td>
                                                {{-- <td>{{$res->product_title}}</td>--}}
                                                <td>{{$res->quantity}}</td>
                                                <td>$ {{$res->unit_price}}</td>
                                                <td>$ {{$res->quantity*$res->unit_price}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        
                      <div class="row">
                        <div  class="col-md-6">
                            <div class="row" >
                            @if(isset($payments))
                                <table class="table m-t-30">
                                    <thead>
                                    <tr>
                                        <th>Payment Date</th>
                                        <th>Installment</th>
                                        <th>Payment Amount</th>
                                    </tr>
                                    </thead>
            
            
                                    <tbody>
            
            
                                    @php($i=1)
                                    @php($grand_total=0)
                                    <tr>
                                        <td>{{ date('d-M-Y', strtotime($first_payment->created_at))}}</td>
                                        <td>Installment: {{$i++}} </td>
                                        <td>{{$first_payment->given_amount}}</td>
                                    </tr>
            
                                    @foreach($payments as $res)
                                        <tr>
                                            <td>{{ date('d-M-Y', strtotime($res->created_at))}}</td>
                                            <td>Installment: {{$i++}} </td>
                                            <td>{{$res->due_amount}}</td>
            
                                        </tr>
            
                                        <?php $grand_total = ($grand_total + $res->due_amount) ?>
                                    @endforeach
            
                                    </tbody>
            
                                    <tfoot>
                                    <tr>
                                        <td>Total Payment:</td> 
                                                               
                                        {{-- <td>{{$grand_total+$first_payment->given_amount}}</td> --}}
                                        <?php
                                        $totalPayment=$grand_total+($first_payment->given_amount) ;  
                                        ?>                       
                                      <td>{{$totalPayment}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            @endif
                            </div>
                        </div>

                                
                        <div  class="col-md-6" >


                                    <div class=" justify-content-end float-right">
                                        <div class="col-md-12">
                                            <p class="text-right">
                                                <b>Sub-total:</b>
                                                $ {{$details->grand_total_price+$details->discount_amount+$details->total_vat}}
                                            </p>
                                            <p class="text-right"><b>Discout:</b> $ {{$details->discount_amount}}</p>
                                            <p class="text-right"><b>VAT: </b>$ {{$details->total_vat}}</p>
                                            <p class="text-right"><b>Due: </b>
                                                @if($details->paid_status==1) 0

                                                @else
                                                {{($details->grand_total_price+$details->discount_amount+$details->total_vat) - ($totalPayment)}}
                                                @endif
                                            </p>
                                            <hr>
                                            <h3 class="text-right">Grand Total: $ {{$details->grand_total_price}}</h3>
                                        </div>
                                    </div>
                                </div>
                                

                                
                       </div>
                        

                        
                    @endif
                    <hr>
                    <div class="d-print-none">
                        <div class="text-right">
                            <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i
                                        class="fa fa-print"></i></a>
                            {{--<a href="#" class="btn btn-primary waves-effect waves-light">Submit</a>--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- end row -->


@endsection