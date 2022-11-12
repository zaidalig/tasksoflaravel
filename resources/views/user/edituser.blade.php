@extends('auth.layout')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">User Info</div>
                        <div class="card-body">

                            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" value="{{ $user->name }}" minlength="8"
                                            class="form-control" name="name" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" value="{{ $user->email }}"
                                            class="form-control" name="email" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">



                                    <label class="col-md-4 col-form-label text-md-right">Profile
                                        Image</label>
                                    <div class="col-md-6">
                                        <img src="{{ asset('thumbnails/' . $user->image) }}" alt="profile"
                                            style=" padding: 10px; margin: 0px; ">

                                    </div>
                                </div>

                                <div class="form-group row">



                                    <label for="image" class="col-md-4 col-form-label text-md-right"> Update Profile
                                        Image</label>
                                    <div class="col-md-6">
                                        <input type="file" name="image">
                                    </div>
                                </div>


                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection