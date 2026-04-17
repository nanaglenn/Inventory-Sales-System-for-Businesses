@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Stock</div>

                    <div class="card-body">
                        <form id="add-user-form" method="POST" action="{{ url('/edit-stock/'.$id) }}">
                            @csrf


                            <div class="form-group row">
                                <label for="item-name" class="col-md-4 col-form-label text-md-right">Item Name</label>

                                <div class="col-md-6">
                                    @foreach($stock as $item)
                                        <input id="item-name" type="text" class="form-control" name="unit-price" required disabled value="{{ $item->item_name }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="unit-price" class="col-md-4 col-form-label text-md-right">Unit Price (GHC)</label>

                                <div class="col-md-6">
                                    @foreach($stock as $item)
                                        <input id="unit-price" type="number" class="form-control" name="unit-price" required step="0.5"  value="{{ $item->unit_price }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label text-md-right">Quantity</label>

                                <div class="col-md-6">
                                    @foreach($stock as $item)
                                        <input id="quantity" type="number" class="form-control" name="quantity" required step="1" value="{{ $item->current_stock }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save changes
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
        if ("{{ $status }}" == 1) {
            alert("Stock edited successfully.");
            window.location.href = "{{ url('/edit-stock/'.$id) }}";
        }
    </script>
@endsection
