@extends('auth.layout')

@section('content')
    <main class="upload-images">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">


                    <div class="card-header d-flex justify-content-between">
                        <h4>All Users</h4>


                        <a href="{{ url('users/create') }}">Create New User</a>


                    </div>
                    <div class="form-group ">

                        @if (session('status'))
                            <div class="alert alert-info alert-dismissible">
                                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('status') }}
                                <span aria-hidden="true">&times;</span>

                            </div>
                    </div>
                    {{ session()->forget('status') }}
                @else
                </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th width="50px">Action</th>
                            <th width="50px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->name }}</td>
                                <td><img src="{{ asset('thumbnails/' . $user->image) }}" alt="profile"
                                        style=" padding: 10px; margin: 0px; "></td>


                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="Post">
                                        <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                        @csrf
                                </td>
                                <td>
                                    @method('DELETE')
                                    <button type="submit" onclick="confirm('Are you sure to delete this user ?')"
                                        class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $users->links('pagination::bootstrap-5') !!}




            </div>
        </div>
        </div>
        </div>
        </div>
    </main>
@endsection

