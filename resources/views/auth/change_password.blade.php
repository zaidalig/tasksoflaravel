@extends('auth.layout')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Update Password</div>
                        <div class="card-body">

                            <form action="{{ route('check_and_update_password') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="old_password" class="col-md-4 col-form-label text-md-right"> Old
                                        Password</label>
                                    <div class="col-md-6">
                                        <input minlength="8" type="password" id="old_password" class="form-control"
                                            name="old_password" required>
                                        @if ($errors->has('old_password'))
                                            <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="new_password" class="col-md-4 col-form-label text-md-right">New
                                        Password</label>
                                    <div class="col-md-6">
                                        <input minlength="8" type="password" id="new_password" class="form-control"
                                            name="new_password" required>
                                        @if ($errors->has('new_password'))
                                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                        @endif
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
