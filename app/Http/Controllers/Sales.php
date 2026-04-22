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

    public function calculateSubtotal(Request $request){
        $totalsSpArray = $request->input('totals-sp-array');
        $totalsCpArray = $request->input('totals-cp-array');

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
