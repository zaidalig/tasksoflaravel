@extends('auth.layout')

@section('content')
    <main class="upload-images">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Your Images</h4>

                            <form action="{{ route('storeimages') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="file" name="images[]" required multiple />

                                <button type="submit" class="btn btn-primary">
                                    Upload
                                </button>

                            </form>
                        </div>

                        <div class="card-body">
                            <div class="form-group ">

                                @if (session('data'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('data') }}
                                    </div>
                                    {{ session()->forget('data') }}
                                @else

                                    <div class="Container">
                                        <div class="row row-cols-auto">
                                            @foreach ($images as $image)
                                                <div class="col-sm-3">

                                                    {{-- {{ dd($image->images) }} --}}
                                                    <img src="{{ asset('thumbnails/' . $image->images) }}" alt="profile"
                                                        style=" padding: 10px; margin: 0px; ">

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
