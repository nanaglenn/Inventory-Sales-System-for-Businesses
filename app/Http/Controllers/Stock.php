<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Stock extends Controller
{
    public function getAddStock(){
        $stock = DB::select("SELECT id, item_name, current_stock, unit_price FROM stock ORDER BY item_name");

        $status = 0;
        return view("add-stock", compact("stock", "status"));
    }

    public function addStock(Request $request){
        $id = $request->input('item-name');
        $unit_price = $request->input('unit-price');
        $current_stock = $request->input('current-stock');

        DB::insert("UPDATE stock SET unit_price = (?), current_stock = (?) WHERE id = (?)", [$unit_price, $current_stock, $id]);

        $stock = DB::select("SELECT id, item_name, current_stock FROM stock");
        $status = 1;
        return view("add-stock", compact("stock", "status"));
    }

    public function getAddNewItem(){
        $status = 0;

        return view("add-new-item", compact("status"));
    }

    public function addNewItem(Request $request){
        $itemName = $request->input('item-name');
        $unitPrice = $request->input('unit-price');
        $quantity = $request->input('quantity');

        DB::insert("INSERT INTO stock (item_name, current_stock, unit_price) VALUES (?,?,?)", [$itemName, $quantity, $unitPrice]);

        $status = 1;
        return view("add-new-item", compact("status"));
    }

    public function getStock(){
        $stock = DB::select("SELECT * FROM stock ORDER BY item_name");

        return view("stock", compact("stock"));
    }

    public function getCurrentStock(){
        $itemId = $_GET["item-id"];

        $stock = DB::select("SELECT current_stock, unit_price FROM stock WHERE id = (?)", [$itemId]);

        return $stock;
    }

    public function editStock($id){
        $stock = DB::select("SELECT * FROM stock WHERE id = (?)", [$id]);

        $status = 0;
        return view("edit-stock", compact("stock", "id", "status"));
    }

    public function saveEditStock($id, Request $request){
        $unitPrice = $request->input('unit-price');
        $quantity = $request->input('quantity');


        DB::insert("UPDATE stock SET unit_price = (?), current_stock = (?) WHERE id = (?)", [$unitPrice, $quantity, $id]);


        $status = 1;
        $stock = DB::select("SELECT id, item_name, current_stock, unit_price FROM stock WHERE id = (?)", [$id]);
        return view("edit-stock", compact("stock", "id", "status"));
    }

    public function searchStock($item_name){
        $stock = DB::select("SELECT * FROM stock WHERE item_name LIKE '%$item_name%' ORDER BY item_name");
        return view("stock", compact("stock"));
    }

    public function deleteStock(){
        $itemId = $_GET['item-id'];

        if(DB::delete("DELETE FROM stock WHERE id = (?)", [$itemId]))
            return 1;
        else
            return 0;
    }
}
