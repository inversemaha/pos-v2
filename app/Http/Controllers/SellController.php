<?php

namespace App\Http\Controllers;

use App\Models\DuePaymentHistory;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\Sell;
use App\Models\SellItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SellController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return Redirect::to('/login');
            } else {
                if (!Session::get('user_id')) {
                    return Redirect::to('/logout');
                }
            }
            return $next($request);
        });
    }

    public function showSales(Request $request)
    {

        $from_date = getFormatteddate($request['from_date']);
        $to_date = getFormatteddate($request['to_date']);


        if ($request['from_date'] != null) {
            $query = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')
                ->join('users', 'users.user_id', '=', 'sells.seller_id')
                ->orderBy('sells.created_at', 'DESC');

            if ($from_date != $to_date) {
                $query->whereBetween('sells.created_at', [$from_date, $to_date]);
            } else {
                $query->whereDate('sells.created_at', $from_date);
            }
            $result = $query->get([
                'sells.sell_id',
                'sells.customer_id',
                'sells.invoice',
                'sells.grand_total_price',
                'sells.given_amount',
                'sells.change',
                'sells.discount_amount',
                'sells.total_vat',
                'sells.delivery_charge',
                'sells.paid_status',
                'sells.seller_id',
                'sells.outlet_id',
                'sells.created_at',
                'sells.updated_at',

                'customers.customer_name',
                'customers.customer_phone',
                'users.user_name',
                'users.user_email',
                'users.user_phone',
                'users.user_email',
            ]);
        }else{
            $result = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')
                ->join('users', 'users.user_id', '=', 'sells.seller_id')
                ->orderBy('sells.created_at', 'DESC')
                ->get([
                    'sells.sell_id',
                    'sells.customer_id',
                    'sells.invoice',
                    'sells.grand_total_price',
                    'sells.given_amount',
                    'sells.change',
                    'sells.discount_amount',
                    'sells.total_vat',
                    'sells.delivery_charge',
                    'sells.paid_status',
                    'sells.seller_id',
                    'sells.outlet_id',
                    'sells.created_at',
                    'sells.updated_at',

                    'customers.customer_name',
                    'customers.customer_phone',
                    'users.user_name',
                    'users.user_email',
                    'users.user_phone',
                    'users.user_email',
                ]);
        }


        return view('pages.sells.show_sells')->with('result', $result);
    }


    public function payment(Request $request)
    {
        if (!$request['customer_id']) {
            return $data = [
                'status' => 'failed',
                'message' => 'Select a Customer'
            ];
        }

        if (!$request['given_amount']) {
            return $data = [
                'status' => 'failed',
                'message' => 'Given amount is empty'
            ];
        }

        $outlet_id = Session::get('outlet_id');
        $invoice = date('YmdHis');
        $paid_status = false;
        $seller_id = Session::get('outlet_id');
        $error = 0;

        if ($request['paid_status'] == "paid") {
            $paid_status = true;
        }

        if ($request['given_amount'] - $request['grand_total_price'] > 0) {
            $paid_status = true;
        }
        $change = $request['change'];
        if ($change < 0) {
            $change = 0;
        }
        $sell = [
            'customer_id' => $request['customer_id'],
            'invoice' => $invoice,
            'grand_total_price' => $request['grand_total_price'],
            'given_amount' => $request['given_amount'],
            'change' => $change,
            'discount_amount' => $request['total_discount'],
            'paid_status' => $paid_status,
            'total_vat' => $request['total_vat'],
            'seller_id' => Auth::user()->user_id,
            'outlet_id' => $outlet_id,
        ];

        try {
            Sell::create($sell);
        } catch (\Exception $exception) {
            $error = 1;
            $message = $exception->getMessage();
        }

        foreach ($request['productList'] as $product) {
            //  $previous_stock = Stock::where('product_id',$product['product_details_id'])->select('quantity');
            //  $qunt = $product['qnt'];


            $sell_item = [
                'invoice' => $invoice,
                'quantity' => $product['qnt'],
                'unit_price' => $product['product_retail_price'],
                'product_id' => $product['product_details_id'],
                'outlet_id' => $outlet_id,
            ];


            try {
                DB::table('stocks')->where('product_id', $product['product_details_id'])->decrement('quantity', $product['qnt']);
                SellItem::create($sell_item);

            } catch (\Exception $exception) {
                $error = 1;
                $message = $exception->getMessage();
            }
        }
        if ($error == 0) {
            $data = [
                'status' => 'success',
                'invoice' => $invoice,
                'message' => 'successfully Saved'
            ];
        } else {
            $data = [
                'status' => 'failed',
                'invoice' => $invoice,
                'message' => $message
            ];
        }
        return $data;
    }

    public function duepay(Request $request)
    {

        try {
            $sell = Sell::where('invoice', $request['invoice'])->first();
            if ($sell->grand_total_price - (getPayment($sell->invoice) + $sell->discount_amount + $sell->given_amount + $request['pay_amount']) <= 0) {
                Sell::where('invoice', $request['invoice'])->update([
                    'paid_status' => true
                ]);
            }

            Payment::create([
                    'invoice' => $request['invoice'],
                    'pay_amount' => $request['pay_amount'],
                ]
            );
            DuePaymentHistory::create([
                    'invoice' => $request['invoice'],
                    'due_amount' => $request['pay_amount'],
                ]
            );

            return back()->with('success', "Due Paid");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }


        /*
                return $request->all();
                $id = $request['sell_id'];
                $pay_amount = $request['pay_amount'];
                $given_amount = $request['given_amount'];
                $updated_var = $pay_amount + $given_amount;

                $sell = Sell::where('sell_id', $id)->first();
                if ($sell->grand_total_price - ($sell->given_amount + $given_amount) >= 0) {
                    $array = [
                        'given_amount' => $updated_var,
                        'paid_status' => true,
                    ];
                } else {
                    $array = ['given_amount' => $updated_var];
                }

                try {
                    Sell::where('sell_id', $id)->update($array);
                    return back()->with('success', "Due Paid");
                } catch (\Exception $exception) {
                    return $exception->getMessage();
                }*/
    }

    public function search(Request $request)
    {

        $from_date = getFormatteddate($request['from_date']);
        $to_date = getFormatteddate($request['to_date']);
        if ($from_date != $to_date) {
            return $result = Sell::
            join('customers', 'customers.customer_id', '=', 'sells.customer_id')
                ->join('users', 'users.user_id', '=', 'sells.seller_id')
                ->whereBetween('sells.created_at', [$from_date, $to_date])
                ->get([
                    'sells.sell_id',
                    'sells.customer_id',
                    'sells.invoice',
                    'sells.grand_total_price',
                    'sells.given_amount',
                    'sells.change',
                    'sells.discount_amount',
                    'sells.total_vat',
                    'sells.delivery_charge',
                    'sells.paid_status',
                    'sells.seller_id',
                    'sells.outlet_id',
                    'sells.created_at',
                    'sells.updated_at',

                    'customers.customer_name',
                    'customers.customer_phone',
                    'users.user_name',
                    'users.user_email',
                    'users.user_phone',
                    'users.user_email',
                ]);

        } else {
            $result = Sell::
            join('customers', 'customers.customer_id', '=', 'sells.customer_id')
                ->join('users', 'users.user_id', '=', 'sells.seller_id')
                ->whereDate('sells.created_at', $from_date)
                ->get([
                    'sells.sell_id',
                    'sells.customer_id',
                    'sells.invoice',
                    'sells.grand_total_price',
                    'sells.given_amount',
                    'sells.change',
                    'sells.discount_amount',
                    'sells.total_vat',
                    'sells.delivery_charge',
                    'sells.paid_status',
                    'sells.seller_id',
                    'sells.outlet_id',
                    'sells.created_at',
                    'sells.updated_at',

                    'customers.customer_name',
                    'customers.customer_phone',
                    'users.user_name',
                    'users.user_email',
                    'users.user_phone',
                    'users.user_email',
                ]);
        }


        return view('pages.sells.show_sells')->with('result', $result)
            ->with('from_date', $from_date)
            ->with('to_date', $to_date);

    }


    public function show($invoice)
    {

        $result = SellItem:: join('product_details', 'product_details.product_details_id', '=', 'sell_items.product_id')
            ->where('invoice', $invoice)
            ->get();
        $details = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')
            ->leftJoin('due_payment_histories', 'due_payment_histories.invoice', '=', 'sells.invoice')
            ->where('sells.invoice', $invoice)
            ->select('sells.invoice',
                'sells.grand_total_price',
                'sells.given_amount',
                'sells.change',
                'sells.discount_amount',
                'sells.total_vat',
                'sells.paid_status',
                'sells.created_at',
                'customers.customer_name',
                'customers.customer_phone',
                'customers.customer_address',
                'customers.customer_company')
            ->first();


        $outlet = Outlet::where('outlet_id', Session::get('outlet_id'))->first();

        $duePayments = DuePaymentHistory::where('invoice', $invoice)->get();
        $first_payment = Sell::where('invoice', $invoice)->first();

        return view('pages.sells.invoice')
            ->with('result', $result)
            ->with('outlet', $outlet)
            ->with('details', $details)
            ->with('payments', $duePayments)
            ->with('first_payment', $first_payment);

    }

    public function showPayments($invoice)
    {


        $payments = Payment::where('invoice', $invoice)->get();
        $first_payment = Sell::where('invoice', $invoice)->first();


        return view('pages.sells.payments')
            ->with('first_payment', $first_payment)
            /*       ->with('outlet', $outlet)*/
            ->with('payments', $payments);

    }

    public function posPrint($invoice)
    {

        $result = SellItem:: join('product_details', 'product_details.product_details_id', '=', 'sell_items.product_id')
            ->join('products', 'products.product_id', '=', 'sell_items.product_id')
            ->where('invoice', $invoice)
            ->get();
        $details = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')
            ->where('sells.invoice', $invoice)
            ->select('sells.invoice',
                'sells.grand_total_price',
                'sells.given_amount',
                'sells.change',

                'sells.discount_amount',
                'sells.total_vat',
                'sells.paid_status',
                'sells.created_at',
                'customers.customer_id',
                'customers.customer_name',
                'customers.customer_phone',
                'customers.customer_address',
                'customers.customer_company')
            ->first();
        //    $prevDue = 0;
        $customer_id = $details->customer_id;

        $data = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')->where('sells.customer_id', $customer_id)->where('sells.paid_status', 0)->select('sells.grand_total_price',
            'sells.given_amount',
            'sells.created_at',
            'customers.customer_name',
            'customers.customer_id',
            'sells.customer_id',
        )->get();
        $c = $data->count();

        if ($c === 0) {

            return view('pages.sells.pos2')
                ->with('result', $result)
                ->with('invoice', $invoice)
                ->with('details', $details);
        } else {
            $pStatus = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')->where('sells.customer_id', $customer_id)->orderBy('created_at', 'desc')->select('sells.*')->first();

            if ($pStatus->paid_status == 0) {
                $count = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')->where('sells.customer_id', $customer_id)->where('sells.paid_status', 0)->orderBy('created_at', 'desc')
                    ->select('sells.grand_total_price',
                        'sells.given_amount',
                        'sells.created_at',
                    )
                    ->count();
                $skip = 1;
                $limit = $count - $skip;

                $statusPayment = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')->where('sells.customer_id', $customer_id)->where('sells.paid_status', 0)->orderBy('created_at', 'desc')
                    ->select('sells.grand_total_price',
                        'sells.given_amount',
                        'sells.created_at',
                        'customers.customer_name',
                        'customers.customer_id',
                        'sells.customer_id',
                    )->skip($skip)->take($limit)
                    ->get();

            } else {
                $statusPayment = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')->where('sells.customer_id', $customer_id)->where('sells.paid_status', 0)->orderBy('created_at', 'desc')
                    ->select('sells.grand_total_price',
                        'sells.given_amount',
                        'sells.created_at',
                        'customers.customer_name',
                        'customers.customer_id',
                        'sells.customer_id'
                    )->get();

            }


            $payable = 0;
            $total_given = 0;

            foreach ($statusPayment as $item) {

                $payable = $payable + $item['grand_total_price'];
                $total_given = $total_given + $item['given_amount'];

            }
            $prevDue = $payable - $total_given;

            // return $totalgiven;


            //$customer=Customer::where('customer_id',$)->first();

            //$outlet = Outlet::where('outlet_id', Session::get('outlet_id'))->first();

            return view('pages.sells.pos2')
                ->with('result', $result)
                ->with('invoice', $invoice)
                ->with('details', $details)
                ->with('prevDue', $prevDue);
        }


    }


    public function edit(Sell $sell)
    {

    }

    public function update(Request $request, Sell $sell)
    {
        //
    }


    public function destroy($invoice)
    {
        try {
            Sell::where('invoice', $invoice)->delete();
            SellItem::where('invoice', $invoice)->delete();

            return back()->with('success', 'Successfully Deleted');
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function dueList()
    {
        $result = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')
            ->join('users', 'users.user_id', '=', 'sells.seller_id')
            ->where('sells.paid_status', 0)
            ->orderBy('sells.created_at', 'DESC')
            ->get([
                'sells.sell_id',
                'sells.customer_id',
                'sells.invoice',
                'sells.grand_total_price',
                'sells.given_amount',
                'sells.change',
                'sells.discount_amount',
                'sells.total_vat',
                'sells.delivery_charge',
                'sells.paid_status',
                'sells.seller_id',
                'sells.outlet_id',
                'sells.created_at',
                'sells.updated_at',

                'customers.customer_name',
                'customers.customer_phone',
                'users.user_name',
                'users.user_email',
                'users.user_phone',
                'users.user_email',
            ]);
        return view('pages.sells.show_sells')->with('result', $result);
    }

    public function paidList()
    {
        $result = Sell::join('customers', 'customers.customer_id', '=', 'sells.customer_id')
            ->join('users', 'users.user_id', '=', 'sells.seller_id')
            ->where('sells.paid_status', 1)
            ->orderBy('sells.created_at', 'DESC')
            ->get([
                'sells.sell_id',
                'sells.customer_id',
                'sells.invoice',
                'sells.grand_total_price',
                'sells.given_amount',
                'sells.change',
                'sells.discount_amount',
                'sells.total_vat',
                'sells.delivery_charge',
                'sells.paid_status',
                'sells.seller_id',
                'sells.outlet_id',
                'sells.created_at',
                'sells.updated_at',

                'customers.customer_name',
                'customers.customer_phone',
                'users.user_name',
                'users.user_email',
                'users.user_phone',
                'users.user_email',
            ]);
        return view('pages.sells.show_sells')->with('result', $result);
    }
}
