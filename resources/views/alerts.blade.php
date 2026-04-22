@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" id="messages-container">
                {{--@foreach($itemData as $itemDatum)--}}
                @for($counter = 0; $counter < count($itemData); $counter++)
                    @for($innerCounter = 0; $innerCounter < count($itemData[$counter]); $innerCounter++)
                        <div class="card" id="{{ $itemData[$counter][$innerCounter]->id }}">

                            <div class="card-body">
                                <p>
                                    <strong>{{ $itemData[$counter][$innerCounter]->item_name }}</strong> is running out.
                                    <br>
                                    <strong>Current Stock: {{ $itemData[$counter][$innerCounter]->current_stock }}</strong>
                                </p>
                                <button class="btn-primary btn" style="float: right" onclick="dismissMessage({{ $itemData[$counter][$innerCounter]->id }})">Dismiss</button>
                            </div>
                        </div>
                    @endfor
                @endfor
                {{--@endforeach--}}
            </div>
        </div>
    </div>

    <script>
        function dismissMessage(message_id) {
            if(confirm("Are you sure you want to dismiss this message?")) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/dismiss-message') }}",
                    data: {"message-id": message_id},

                    success:function (status) {
                        if (status == 1)
                            window.location.href = "{{ url('/system-alerts') }}";
                    }
                })
            }
        }
    </script>
@endsection
