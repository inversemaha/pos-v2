@extends('layouts.admin_layout')

@section('title', 'Payments')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Payments</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">View Payments</a></li>
            </ol>

        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>View Payments</h4>

                    </div>

                </div>


                @if(isset($payments))
                    <table id="datatable-buttonsq" class="table table-striped table-bordered" cellspacing="0"
                           width="100%">
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
                                <td>{{$res->pay_amount}}</td>

                            </tr>

                            <?php $grand_total = ($grand_total + $res->pay_amount) ?>
                        @endforeach

                        </tbody>

                        <tfoot>
                        <tr>
                            <td>Total:</td>
                            <td>{{$grand_total+$first_payment->given_amount}}</td>
                        </tr>
                        </tfoot>
                    </table>


                @endif
            </div>
            <!-- end row -->
        </div> <!-- end card-box -->
    </div><!-- end col -->

    <!-- end row -->

@endsection