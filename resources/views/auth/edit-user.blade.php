@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <form id="edit-user-data-form" method="POST" action="{{ url('/edit-user-data') }}" onsubmit="return false">
                            @csrf

                            <div class="form-group row">
                                <label for="access-level" class="col-md-4 col-form-label text-md-right">Role</label>

                                <div class="col-md-6">
                                    @foreach($userData as $userDatum)
                                        <select id="access-level" class="form-control" name="access-level" required>
                                            @if($userDatum->access_level == "Administrator")
                                                <option selected>Administrator</option>
                                                <option>Supervisor</option>
                                                <option>Sales Person</option>
                                            @elseif($userDatum->access_level == "Supervisor")
                                                <option>Administrator</option>
                                                <option selected>Supervisor</option>
                                                <option>Sales Person</option>
                                            @elseif($userDatum->access_level == "Sales Person")
                                                <option>Administrator</option>
                                                <option>Supervisor</option>
                                                <option selected>Sales Person</option>
                                            @endif
                                        </select>
                                    @endforeach
                                    @foreach($userData as $userDatum)
                                        <input id="current-access-level" class="hidden-items" type="text" style="visibility: hidden" value="{{ $userDatum->access_level }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    @foreach($userData as $userDatum)
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $userDatum->name }}" required autocomplete="name" autofocus
                                               onkeypress="return (event.charCode > 64 &&  event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
                                        <input id="current-name" class="hidden-items" type="text" style="visibility: hidden" value="{{ $userDatum->name }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">Phone Number</label>

                                <div class="col-md-6">
                                    @foreach($userData as $userDatum)
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{ $userDatum->phone }}" required maxlength="10" minlength="10" onkeypress="return (event.charCode > 47 &&  event.charCode < 58)">
                                        <input id="current-phone" class="hidden-items" type="text" style="visibility: hidden" value="{{ $userDatum->phone }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                                <div class="col-md-6">
                                    @foreach($userData as $userDatum)
                                        <input id="username" type="text" class="form-control" name="username" value="{{ $userDatum->username }}" required maxlength="30">
                                        <input id="current-username" class="hidden-items" type="text" style="visibility: hidden" value="{{ $userDatum->username }}">
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password" minlength="6">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirm-new-password" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="confirm-new-password" type="password" class="form-control" name="new-password-confirmation" minlength="6">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" onclick="changePasswordMatchCheck()">
                                        Save Changes
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
            alert("User data successfully saved.");
            window.location.href = "{{ url('/add-new-user') }}";
        }

        function submitEditUser() {

            $.ajax({
                type: "GET",
                url: "{{ url('/submit-edit-user') }}",
                data: {
                    "access-level": document.getElementById("access-level").value,
                    "current-access-level": document.getElementById("current-access-level").value,
                    "name": document.getElementById("name").value,
                    "current-name": document.getElementById("current-name").value,
                    "phone": document.getElementById("phone").value,
                    "current-phone": document.getElementById("current-phone").value,
                    "username": document.getElementById("username").value,
                    "current-username": document.getElementById("current-username").value,
                    "new-password": document.getElementById("new-password").value
                },

                success:function (status) {
                    if (status == 1){
                        alert("Changes successfully saved.");
                    }else {
                        alert("Something went wrong. Please check network connection and try again.");
                    }
                }
            })
        }
    </script>
@endsection
