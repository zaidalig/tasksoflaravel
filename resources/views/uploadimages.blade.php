@extends('auth.layout')

@section('content')
    <main class="upload-images">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Upload Images</div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                                {{ session()->forget('success') }}
                            @endif

                            <form action="{{ route('storeimages') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label text-md-right">Your
                                        Images</label>
                                    <div class="col-md-6">
                                        <input type="file" name="images[]" required multiple />
                                    </div>
                                </div>



                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Upload
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
