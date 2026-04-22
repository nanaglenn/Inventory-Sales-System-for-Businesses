<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Checkout extends Controller
{
    public function getCheckout(){
        $stock = DB::select("SELECT id, item_name FROM stock ORDER BY item_name");

        $status = 0;
        return view("checkout", compact("stock", "status"));
    }

    public function calculateCheckoutList(){
        $items = $_GET['check-out-list'];

        $total = 0;

        //LIST IS AN ARRAY OF ITEM_ID AND QUANTITY PURCHASED(TO BE) PAIRS

        for ($iterator = 0; $iterator < count($items); $iterator++) {
            $tempItemHolder = $items[$iterator];
            $itemId = $tempItemHolder[0];
            $itemCount = $tempItemHolder[1];

            $itemPrice = DB::select("SELECT unit_price FROM stock WHERE id = (?)",[$itemId]);

            $itemUnitPrice = 0;

            for ($itemPriceIterator = 0; $itemPriceIterator < count($itemPrice); $itemPriceIterator++) {
                $itemUnitPrice = $itemPrice[$itemPriceIterator]->unit_price;
            }

            $total = $total + ($itemUnitPrice*$itemCount);
        }

        return $total;
    }

    public function salesCheckout(Request $request){
        $items = $_GET['check-out-list'];

        $totalSellingPrice = 0;
        $totalCostPrice = 0;

        //LIST IS AN ARRAY OF ITEM_ID AND QUANTITY PURCHASED(TO BE) PAIRS

        for ($iterator = 0; $iterator < count($items); $iterator++) {
            $tempItemHolder = $items[$iterator];
            $itemId = $tempItemHolder[0];
            $itemCount = $tempItemHolder[1];

            $currentItemStock = DB::select("SELECT current_stock FROM stock WHERE id = (?)", [$itemId]);
            $currentItemStockCount = 0;

            foreach ($currentItemStock as $item){
                $currentItemStockCount = $item->current_stock;
            }

            $currentItemStockCount = $currentItemStockCount - $itemCount;
            DB::update("UPDATE stock SET current_stock = (?) WHERE id = (?)", [$currentItemStockCount, $itemId]);

            $itemPrice = DB::select("SELECT cost_price, unit_price FROM stock WHERE id = (?)",[$itemId]);

            $itemUnitPrice = 0;
            $itemCostPrice = 0;

            for ($itemPriceIterator = 0; $itemPriceIterator < count($itemPrice); $itemPriceIterator++) {
                $itemUnitPrice = $itemPrice[$itemPriceIterator]->unit_price;
                $itemCostPrice = $itemPrice[$itemPriceIterator]->cost_price;
            }

            $totalSellingPrice = $totalSellingPrice + ($itemUnitPrice*$itemCount);
            $totalCostPrice = $totalCostPrice + ($itemCostPrice*$itemCount);
        }

        $date = date("Y-m-d");
        $user = Auth::user()->name;

        DB::insert("INSERT INTO sales (user, total, cost_price, date) VALUES (?,?,?,?)", [$user, $totalSellingPrice, $totalCostPrice, $date]);

        return 1;
    }

    public function prepareInvoice(Request $request){
        $checkoutList = $request->input('check-out-list');

        $invoiceArray = array();

        $invoiceItem = 0;
        $totalSellingPrice = 0;
        for ($iterator = 0; $iterator < count($checkoutList); $iterator++) {
            $itemUnitPrice = 0;
            $itemName = "";

            $tempItemHolder = $checkoutList[$iterator];
            $itemId = $tempItemHolder[0];
            $itemCount = $tempItemHolder[1];

            $itemData = DB::select("SELECT item_name, unit_price FROM stock WHERE id = (?)",[$itemId]);

            for ($itemPriceIterator = 0; $itemPriceIterator < count($itemData); $itemPriceIterator++) {
                $itemUnitPrice = $itemData[$itemPriceIterator]->unit_price;
                $itemName = $itemData[$itemPriceIterator]->item_name;
            }

            $invoiceArray[$invoiceItem] = [$itemName, $itemCount,($itemUnitPrice*$itemCount)];
            $invoiceItem++;
            $totalSellingPrice = $totalSellingPrice + ($itemUnitPrice*$itemCount);
        }

        return response()->json(["invoiceArray"=>$invoiceArray, "totalSellingPrice"=>$totalSellingPrice, "date"=>date("Y-m-d")]);
    }
}
