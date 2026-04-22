<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Sales extends Controller
{
    public function getSalesRecords(){
        $salesRecords = DB::select("SELECT * FROM sales ORDER BY date DESC");
        return view("sales-records", compact("salesRecords"));
    }

    public function filterSalesRecords($from, $to){
        $salesRecords = DB::select("SELECT * FROM sales WHERE date BETWEEN (?) AND (?) ORDER BY date DESC", [$from, $to]);
        return view("sales-records", compact("salesRecords"));
    }

<<<<<<< HEAD
    public function calculateSubtotal(Request $request){
        $totalsSpArray = $request->input('totals-sp-array');
        $totalsCpArray = $request->input('totals-cp-array');
=======
    public function calculateSubtotal(){
        $totalsSpArray = $_GET['totals-sp-array'];
        $totalsCpArray = $_GET['totals-cp-array'];
>>>>>>> 378df80085aad65960795f2be6d92428dac60024

        $sellingPriceSubtotal = 0;
        $costPriceSubtotal = 0;

        for ($iterator = 0; $iterator < count($totalsSpArray); $iterator++){
            $sellingPriceSubtotal = $sellingPriceSubtotal + $totalsSpArray[$iterator];
        }

        for ($iterator = 0; $iterator < count($totalsCpArray); $iterator++){
            $costPriceSubtotal = $costPriceSubtotal + $totalsCpArray[$iterator];
        }

        return response()->json(["sellingPriceSubTotal"=>$sellingPriceSubtotal, "profitSubTotal"=>($sellingPriceSubtotal - $costPriceSubtotal)]);
    }
}
