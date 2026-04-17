@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Sales Records
                        <form class="form-inline" action="" style="margin-bottom: 0" onsubmit="return false">
                            <label style="font-weight: 700; margin-left: 20px">
                                <input id="to-check-box" type="checkbox" name="" onclick="checkToCbState(this)"> Filter &nbsp;&nbsp;
                            </label>

                            <div style="display: flex">
                                <span style="font-weight: 700; margin-top: 7px">Between: &nbsp;</span>

                                <div class="form-group" style="margin-right: 5px">
                                    <select id="from-day-select" class="form-control to-filter-element" disabled>

                                    </select>
                                </div>

                                <div class="form-group" style="margin-right: 5px">
                                    <select id="from-month-select" class="form-control to-filter-element" disabled>

                                    </select>
                                </div>

                                <div class="form-group" style="margin-right: 5px">
                                    <select id="from-year-select" class="form-control to-filter-element" disabled>

                                    </select>
                                </div>
                                {{--------------------------------------------------------------------------------------}}

                                <span style="font-weight: 700; margin-top: 7px">And: &nbsp;</span>

                                <div class="form-group" style="margin-right: 5px">
                                    <select id="to-day-select" class="form-control to-filter-element" disabled>

                                    </select>
                                </div>

                                <div class="form-group" style="margin-right: 5px">
                                    <select id="to-month-select" class="form-control to-filter-element" disabled>

                                    </select>
                                </div>

                                <div class="form-group" style="margin-right: 5px">
                                    <select id="to-year-select" class="form-control to-filter-element" disabled>

                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn edit-contact-button to-filter-element" onclick="getFilterDate()" disabled>Filter</button>
                        </form>
                    </div>

                    <div class="card-body">
                        <table style="width: 100%; text-align: center">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>System User</th>
                                    <th>Total Sales(GHC)</th>
                                    <th>Total Cost Price(GHC)</th>
                                    <th>Date (Year-Month-Day)</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($salesRecords as $salesRecord)
                                    <tr>
                                        <td>{{ $salesRecord->id }}</td>
                                        <td>{{ $salesRecord->user }}</td>
                                        <td class="total-sp">{{ $salesRecord->total }}</td>
                                        <td class="total-cp">{{ $salesRecord->cost_price }}</td>
                                        <td>{{ $salesRecord->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary" style="background-color: #2ca02c; border-color: #2ca02c; width: 100%; margin-bottom: 10px" onclick="calculateFilteredSubtotal()">Calculate Total</button>
                        <label for="name" class="col-md-12 col-form-label">Total Sales</label>
                        <input id="sales-sub-total" type="text" class="form-control" disabled value="Total Sold">
                        <label for="name" class="col-md-12 col-form-label">Profit</label>
                        <input id="profit" type="text" class="form-control" disabled value="Profit">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function appendYears() {
            var dateObj = new Date();
            var year = dateObj.getFullYear();

            for (var iterator = (parseInt(year) - 10); iterator <= parseInt(year); iterator++){
                var option = document.createElement("OPTION");
                option.innerHTML = ""+iterator;
                option.value = ""+iterator;

                option.style.color = "#000";
                if(option.innerHTML == 2019)
                    option.selected = true;

                document.getElementById("to-year-select").insertBefore(option, document.getElementById("to-year-select").childNodes[0]);
                document.getElementById("from-year-select").insertBefore(option.cloneNode(true), document.getElementById("from-year-select").childNodes[0]);
            }
        }

        function appendMonths() {
            var dateObj = new Date();
            var month = parseInt(dateObj.getMonth())+1;

            for (var iterator = 1; iterator <= 12; iterator++){
                var option = document.createElement("OPTION");
                option.innerHTML = ""+iterator;
                option.value = ""+iterator;

                if(option.innerHTML == month)
                    option.selected = true;

                document.getElementById("to-month-select").appendChild(option);
                document.getElementById("from-month-select").appendChild(option.cloneNode(true));
            }
        }

        function appendDays() {
            var dateObj = new Date();
            var day = dateObj.getDate();

            for (var iterator = 1; iterator <= 31; iterator++){
                var option = document.createElement("OPTION");
                option.innerHTML = ""+iterator;
                option.value = ""+iterator;

                if(option.innerHTML == day)
                    option.selected = true;

                document.getElementById("to-day-select").appendChild(option);
                document.getElementById("from-day-select").appendChild(option.cloneNode(true));
            }
        }

        function checkToCbState(checkBox){
            if(checkBox.checked === true){
                var toElements = document.getElementsByClassName('to-filter-element');

                for (var iterator = 0; iterator < toElements.length; iterator++) {
                    toElements[iterator].disabled = false;
                }
            }else {
                var toElements = document.getElementsByClassName('to-filter-element');

                for (var iterator = 0; iterator < toElements.length; iterator++){
                    toElements[iterator].disabled = true;
                }
                window.location.href = "{{ url('/get-sales-records') }}";
            }
        }

        function getFilterDate(){
            var fromYear, fromMonth, fromDay, toYear, toMonth, toDay, numberPadding = 0;

            fromYear = document.getElementById('from-year-select').value;

            fromMonth = document.getElementById('from-month-select').value;
            if (fromMonth.length === 1)
                fromMonth = numberPadding+fromMonth;

            fromDay = document.getElementById('from-day-select').value;
            if(fromDay.length === 1)
                fromDay = numberPadding+fromDay;

            toYear = document.getElementById('to-year-select').value;

            toMonth = document.getElementById('to-month-select').value;
            if (toMonth.length === 1)
                toMonth = numberPadding+toMonth;

            toDay = document.getElementById('to-day-select').value;
            if (toDay.length === 1)
                toDay = numberPadding+toDay;

            console.log("FROM: "+fromYear+"-"+fromMonth+"-"+fromDay+"");
            console.log("TO: "+toYear+"-"+toMonth+"-"+toDay+"");

            var fromDate = fromYear+"-"+fromMonth+"-"+fromDay;
            var toDate = toYear+"-"+toMonth+"-"+toDay;
            window.location.href = "{{ url('/filter-sales-records/') }}/"+fromDate+"/"+toDate;
        }

        function calculateFilteredSubtotal() {
            var totalSellingPriceTd = document.getElementsByClassName("total-sp");
            var totalCostPriceTd = document.getElementsByClassName("total-cp");

            var totalsSpArray = [];

            for (var counter = 0; counter < totalSellingPriceTd.length; counter++){
                totalsSpArray[counter] = totalSellingPriceTd[counter].innerHTML;
            }

            var totalsCpArray = [];
            for (counter = 0; counter < totalCostPriceTd.length; counter++){
                totalsCpArray[counter] = totalCostPriceTd[counter].innerHTML;
            }

            $.ajax({
                type: "GET",
                url: "{{ url('/calculate-filtered-subtotal') }}",
                data: {"totals-sp-array": totalsSpArray, "totals-cp-array": totalsCpArray},

                success: function (subtotal) {
                    document.getElementById("sales-sub-total").value = subtotal["sellingPriceSubTotal"];
                    document.getElementById("profit").value = subtotal["profitSubTotal"];
                }
            })
        }
        $(document).ready(function(){
            appendYears();
            appendMonths();
            appendDays();
        });
    </script>
@endsection
