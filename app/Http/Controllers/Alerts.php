<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Alerts extends Controller
{
    public function checkForNewMessages(){
        $messages = DB::select("SELECT * FROM messages WHERE type = 'new'");

        return count($messages);
    }

    public function getAlerts(){
        $messages = DB::select("SELECT * FROM messages WHERE type = 'new'");

        $itemData = array();
        $itemDataCounter = 0;

        foreach ($messages as $message) {
            $tempItemData = DB::select("SELECT id, item_name, current_stock FROM stock WHERE id = (?)", [$message->item_id]);
            $itemData[$itemDataCounter] = $tempItemData;

            $itemDataCounter++;
        }
        return view("alerts", compact("itemData", "messages"));
    }

    public function countNewAlerts(){
        $messages = DB::select("SELECT * FROM messages WHERE type = 'new'");

        return count($messages);
    }

    public function checkLowStocksCount(){
        $lowStocks = DB::select("SELECT id, current_stock FROM stock WHERE current_stock < 50");

        foreach ($lowStocks as $lowStock) {
            if (count(DB::select("SELECT * FROM messages WHERE item_id = (?)", [$lowStock->id])) == 0)
                DB::insert("INSERT INTO messages (item_id, current_stock, type) VALUES (?,?,?) ", [$lowStock->id, $lowStock->current_stock, "new"]);
        }
    }

    public function dismissMessage(Request $request){
        $messageId = $request->input('message-id');

        DB::delete("DELETE FROM messages WHERE item_id = (?)", [$messageId]);

        return 1;
    }
}
