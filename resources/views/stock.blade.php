@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span style="float: left">Dashboard</span>
                        <form style="float: right" onsubmit="return false">
                            <input id="stock-search-item" type="text" class="form-control" placeholder="search" style="display: inline; width: 70%">
                            <button class="btn btn-primary" type="submit" onclick="searchInventory()">Search</button>
                        </form>
                    </div>

                    <div class="card-body">
                        <table style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Current Stock</th>
                                    <th>Cost Price</th>
                                    <th>Unit Price (GHC)</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($stock as $item)
                                    <tr>
                                        <td style="text-transform: uppercase">{{ $item->item_name }}</td>
                                        <td>{{ $item->current_stock }}</td>
                                        <td>{{ $item->cost_price }}</td>
                                        <td>{{ $item->unit_price }}</td>
                                        <td>
                                            <a href="{{ url('/edit-stock/'.$item->id) }}" class="btn btn-primary" style="color: #FFF; font-weight: 500; width: 70px">Edit</a>
                                            {{--<a href="javascript:void(0)" class="btn btn-primary" style="color: #FFF; font-weight: 500; width: 70px">Edit</a>--}}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-primary" data-item-id="{{ $item->id }}" style="color: #FFF; font-weight: 500; width: 70px; background-color: red; border-color: red" onclick="deleteStock(this.getAttribute('data-item-id'))">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function searchInventory() {
            var searchItem = document.getElementById("stock-search-item").value;

            window.location.href = "{{ url('/search-stock/') }}/"+searchItem;
        }

        function deleteStock(itemId) {
            if (confirm("Are you sure you want to delete this item from stock?")) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/delete-item') }}",
                    data: {"item-id": itemId},

                    success:function (status) {
                        if (status == 1) {
                            alert("Item removed from stock successfully.");
                            window.location.href = "{{ url('/get-stock') }}";
                        }
                        else
                            alert("Error removing Item from stock. Please try again later.");
                    }
                })
            }
        }
    </script>
@endsection
