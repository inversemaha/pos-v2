@extends('layouts.admin_layout')

@section('title', 'Show Sells')

@section('content')
    <link href="/css/pos.css" rel="stylesheet" type="text/css"/>

    <div class="pull-left">
        <div class="d-print-none">
            <div class="text-right">
                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i
                            class="fa fa-print"></i></a>
                            
                {{--<a href="#" class="btn btn-primary waves-effect waves-light">Submit</a>--}}
            </div>
        </div>
    </div>


    <div id="invoice-POS">
        <p>
            <small>{{$invoice}}/ {{date('d-M')}}</small>
        </p>

        <center id="top">

            <img class="logo img-thumbnail" src="/image/{{Session::get('outlet_image')}}"/>

            <div class="info">
                <p><strong>{{Session::get('outlet_name')}}</strong></p>
                <p>{{Session::get('outlet_address')}}</p>
            </div><!--End Info-->
        </center><!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                <h2>Contact Info</h2>
                <p>Name : {{ $details->customer_name }}</p>
                <p>Phone : {{ $details->customer_phone }}</p>
                <p>Address : {{ $details->customer_address }}</p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">

            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2>Item</h2></td>
                        <td class="Hours"><h2>Qty</h2></td>
                        <td class="Rate"><h2>Sub Total</h2></td>
                    </tr>


                    @php($i=1)
                    @foreach($result as $res)
                        <tr class="service">
                            <td class="tableitem"><p class="itemtext">{{$res->product_title}}</p></td>
                            <td class="tableitem"><p class="itemtext">{{$res->quantity}}</p></td>
                            <td class="tableitem"><p class="itemtext">$ {{$res->quantity*$res->unit_price}}</p></td>
                        </tr>
                    @endforeach


                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate"><h2>Vat</h2></td>
                        <td class="payment"><h2>$ {{$details->total_vat}}</h2></td>
                    </tr>
                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate"><h2>Discount</h2></td>
                        <td class="payment"><h2>$ {{$details->discount_amount}}</h2></td>
                    </tr>


                    <tr class="tabletitle">
                        <td></td>
                        <td class="Rate"><h2>Due</h2></td>
                        <td class="payment"><h2>
                                @if($details->paid_status==1) 0

                                @else
                                    {{($details->grand_total_price+$details->discount_amount+$details->total_vat)- ($details->given_amount)}}
                                @endif
                            </h2>
                        </td>
                    </tr>



                    <tr class="tabletitle">
                        @isset($prevDue)
                        <td>Previous Due:{{ $prevDue }}Tk</td>
                        @endisset
                        @empty($prevDue)
                        <td></td>
                        @endempty
                        
                        <td class="Rate"><h2>Total</h2></td>
                        <td class="payment"><h2>
                                $ {{$details->grand_total_price+$details->discount_amount+$details->total_vat}}</h2>
                        </td>
                    </tr>

                </table>
            </div><!--End Table-->

            <div id="legalcopy">
                <p class="legal"><strong>Thank you for visiting us!</strong><br>Have a good day.
                </p>
            </div>

        </div><!--End InvoiceBot-->
    </div><!--End Invoice-->

@endsection