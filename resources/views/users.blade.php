@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Authorized Users</div>

                    <div class="card-body">
                        <table style="width: 100%">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Phone Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->access_level }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <a href="{{ url('/get-user-data/'.$user->id) }}" class="btn btn-primary" style="color: #FFF; font-weight: 500; width: 70px">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" data-user-id="{{ $user->id }}" style="color: #FFF; font-weight: 500; width: 70px; background-color: red; border-color: red" onclick="confirmDeleteUser(this.getAttribute('data-user-id'))">Delete</a>
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
        function confirmDeleteUser(user_id) {
            if(confirm("Are you sure you want to delete this user from the system?")){
                $.ajax({
                    type: "GET",
                    url: "{{ url('/delete-user/') }}/"+user_id,
                    data: {"user-id": user_id},

                    success:function (status) {
                        console.log(status);
                        if (status == 1) {
                            alert("User deleted successfully.");
                            window.location.href = "{{ url('/get-users') }}";
                        }
                        else
                            alert("Unable to perform operation at this time.");
                    }
                })
            }
        }
    </script>
@endsection
