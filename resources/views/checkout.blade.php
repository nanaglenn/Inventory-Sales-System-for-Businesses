@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Checkout</div>

                    <div class="card-body">
                        <form id="checkout" method="POST" action="" onsubmit="return false;">
                            @csrf

                            <div  style="max-height: 350px; overflow-y: scroll; overflow-x: hidden">
                                @for($counter = 0; $counter < 100; $counter++)
                                    <div class="form-group row">
                                        <label for="item-name-{{ $counter }}" class="col-md-4 col-form-label text-md-right">Item {{ $counter+1 }}</label>

                                        <div class="col-md-3">
                                            <select id="item-name-{{ $counter }}" type="text" class="form-control" name="item-name-{{ $counter }}" autofocus>
                                                <option></option>
                                                @foreach($stock as $item)
                                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input id="quantity-{{ $counter }}" type="number" class="form-control" name="quantity-{{ $counter }}" autofocus placeholder="Quantity">
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div style="margin-top: 30px; border: 1px solid grey; border-radius: 5px; padding: 10px">
                                <div class="form-group row">
                                    <label for="total" class="col-md-4 col-form-label text-md-right">Total (GHC)</label>

                                    <div class="col-md-6">
                                        <input id="total" type="text" class="form-control" name="total" value="0.00" required disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4" style="">
                                        <button class="btn btn-primary" style="width: 100%; background-color: #2ca02c; border: 1px solid #2CA02C" onclick="calculateItems()">
                                            Calculate
                                        </button>
                                    </div>
                                    {{--<div class="col-md-6" >--}}
                                        {{--<button type="" class="btn btn-primary" style="">--}}
                                            {{--Clear--}}
                                        {{--</button>--}}
                                    {{--</div>--}}
                                </div>

                                <div class="form-group row mb-0" style="margin-top: 20px">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary" style="width: 100%" onclick="checkout()">
                                            Checkout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="invoice-overlay" class="overlay">
        <div class="row" style="width: 100%">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <span class="close-overlay" onclick="closeOverlay('invoice-overlay')">&times;</span>
                        <span>Devine Greatness Enterprise</span>
                        <span id="date" style="float: right"></span>
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            </thead>

                            <tbody id="invoice-tbody">

                            </tbody>
                        </table>
                        <br>
                        <br>
                        <div>
                            <strong style="float: left">TOTAL(GHC):</strong>
                            <strong id="total-cost" style="float: right"></strong>
                        </div>
                    </div>
                </div>
                <div style="text-align: center">
                    <button class="btn btn-primary" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateItems(){
            const checkoutData = {};

            var counter;
            var itemName, itemQuantity;
            var arrangerVariable = 0;
            for (counter = 0; counter < 100; counter++){
                var itemNameId = "item-name-"+counter;
                var itemQuantityId = "quantity-"+counter;

                itemName = document.getElementById(itemNameId);
                itemQuantity = document.getElementById(itemQuantityId);


                if (itemName.value.length > 0){
                    checkoutData[arrangerVariable] = [itemName.value, itemQuantity.value];
                    ++arrangerVariable;
                }
            }

            $.ajax({
                type: "GET",
                url: "{{ url('/calculate-checkout-list') }}",
                data:{"check-out-list": checkoutData},

                success:function (calculatedTotal) {
                    console.log(calculatedTotal);
                    document.getElementById("total").value = calculatedTotal;
                }
            })
        }

        function checkout(){
            const checkoutData = {};

            var counter;
            var itemName, itemQuantity;
            for (counter = 0; counter < 100; counter++){
                var itemNameId = "item-name-"+counter;
                var itemQuantityId = "quantity-"+counter;

                itemName = document.getElementById(itemNameId);
                itemQuantity = document.getElementById(itemQuantityId);

                if (itemName.value.length > 0){
                    checkoutData[counter] = [itemName.value, itemQuantity.value];
                }
            }

            $.ajax({
                type: "GET",
                url: "{{ url('/checkout') }}",
                data:{"check-out-list": checkoutData},

                success:function (returned) {
                    alert("Checkout successful.");
                    prepareInvoice();
                }
            })
        }

        function prepareInvoice(){
            const checkoutData = {};

            var counter;
            var itemName, itemQuantity;
            for (counter = 0; counter < 100; counter++){
                var itemNameId = "item-name-"+counter;
                var itemQuantityId = "quantity-"+counter;

                itemName = document.getElementById(itemNameId);
                itemQuantity = document.getElementById(itemQuantityId);

                if (itemName.value.length > 0){
                    checkoutData[counter] = [itemName.value, itemQuantity.value];
                }
            }

            console.log(checkoutData);
            $.ajax({
                type: "GET",
                url: "{{ url('/prepare-invoice') }}",
                data:{"check-out-list": checkoutData},

                success:function (returned) {
                    console.log(returned);

                    for(var counter = 0; counter < returned.invoiceArray.length; counter++){
                        var invoiceRow = document.createElement("TR");

                        var itemName = document.createElement("TD");
                        itemName.innerHTML = returned.invoiceArray[counter][0];

                        var itemQuantity = document.createElement("TD");
                        itemQuantity.innerHTML = returned.invoiceArray[counter][1];

                        var itemTotal = document.createElement("TD");
                        itemTotal.innerHTML = returned.invoiceArray[counter][2];

                        invoiceRow.appendChild(itemName);
                        invoiceRow.appendChild(itemQuantity);
                        invoiceRow.appendChild(itemTotal);

                        document.getElementById("invoice-tbody").appendChild(invoiceRow);
                    }

                    document.getElementById("total-cost").innerHTML = returned["totalSellingPrice"];
                    document.getElementById("date").innerHTML = returned["date"];
                    showOverlay("invoice-overlay")
//                    alert("Checkout successful.");
                }
            })
        }
    </script>
@endsection
