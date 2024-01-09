@extends('layout.default')
@push('after-style')
    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ $file }}">
    @endforeach
@endpush
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        /* margin: auto; */
        text-align: center;
        font-family: arial;
        }
        .card2 {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 500px;
        /* margin: auto; */
        text-align: center;
        font-family: arial;
        margin-left:15px; 
        }

        .title {
        color: grey;
        font-size: 18px;
        }

        button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
        }

        a {
        text-decoration: none;
        font-size: 22px;
        color: black;
        }

        button:hover, a:hover {
        opacity: 0.7;
        }
    </style>
    <section class="section dashboard">
        <div class="row">
            <h3><b>MY PROFILE</b></h3>
            <hr><br>
            <div class="card">
                <div class="showfoto">

                </div>
                <h1 class="name"></h1>
                <p class="role">{{ $role }}</p>
                
                {{-- <p><button>Contact</button></p> --}}
            </div>
            <div class="card2">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Foto Profile </label>
                    <div class="col-sm-9">
                        <form role="form" class="" id="formfoto" method="post" type="post" enctype="multipart/form-data">
                            <input id="form-file" name="form-file" accept="image/*" type="file" class="inputan form-control" name="foto-file">
                        </form>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input id="form-nama" name="form-nama" type="text" class="inputan form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">No Handphone</label>
                    <div class="col-sm-9">
                        <input id="form-handphone" name="form-handphone" type="number" min=='0d q' class="inputan form-control">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button type="submit" id="save-btn" class="btn btn-primary">Update</button>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
@endsection
@push('after-script')
    <script> 
        @foreach ($varJs as $varjsi)
            {!! $varjsi !!}
        @endforeach
    </script>        
    @foreach ($javascriptFiles as $file)
        <script src="{{ $file }}"></script>
    @endforeach
@endpush