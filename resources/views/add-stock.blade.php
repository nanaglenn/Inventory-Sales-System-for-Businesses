@extends('layouts.app')
{{--ON CLICK OF ITEM PROBABLY LOAD AND GET ITEM CURRENT UNIT PRICE FROM DB--}}
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Stock</div>

                    <div class="card-body">
                        <form id="add-stock-form" method="POST" action="{{ url('/add-stock') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="item-name" class="col-md-4 col-form-label text-md-right">Item Name</label>

                                <div class="col-md-6">
                                    <select id="item-name" type="text" class="form-control" name="item-name" required autofocus onchange="getCurrentStockData(this.value)">
                                        <option></option>
                                        @foreach($stock as $item)
                                            <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="unit-price" class="col-md-4 col-form-label text-md-right">Unit Price (GHC)</label>

                                <div class="col-md-6">
                                    <input id="unit-price" type="number" class="form-control" name="unit-price" required step="0.5">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">Quantity</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="number" class="form-control" name="quantity" required step="1" onchange="addToCurrentStock()">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="current-stock" class="col-md-4 col-form-label text-md-right">Current Stock</label>

                                <div class="col-md-6">
                                    <input id="current-stock" data-initial-current="" type="text" class="form-control" required disabled value="">
                                    <input id="current-stock-value" name="current-stock" style="visibility: hidden">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add Stock
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getCurrentStockData(itemId){
            $.ajax({
                type: "GET",
                url: "{{ url('/get-current-stock') }}",
                data: {"item-id": itemId},

                success:function (currentStock) {
                    console.log(currentStock);
                    for(var iterator = 0; iterator < currentStock.length; iterator++){
                        document.getElementById("current-stock").value = currentStock[iterator].current_stock;
                        document.getElementById("current-stock").setAttribute("data-initial-current", currentStock[iterator].current_stock);
                        document.getElementById("unit-price").value = currentStock[iterator].unit_price;
                    }
                }
            })
        }
        
        function addToCurrentStock() {
            var quantity = parseInt(document.getElementById("quantity").value);
            document.getElementById("current-stock").value = parseInt(document.getElementById("current-stock").getAttribute("data-initial-current")) + quantity ;
            document.getElementById("current-stock-value").value = document.getElementById("current-stock").value;
        }

        if ("{{ $status }}" == 1) {
            alert("Stock added successfully.");
            window.location.href = "{{ url('/add-stock') }}";
        }
    </script>
@endsection
