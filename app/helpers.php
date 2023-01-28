<?php

use App\Models\Payment;
use Illuminate\Support\Carbon;

function getPayment($invoice)
{

    return Payment::where('invoice', $invoice)->sum('pay_amount');
}

function getPassword($length)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

function getQrCode()
{
    $length = 2;
    $randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length);
    return $qr_code = strtoupper($randomletter) . date('is');
}
function getFormatteddate($date){
        return Carbon::parse($date)->format('Y/m/d');

    }
?>
