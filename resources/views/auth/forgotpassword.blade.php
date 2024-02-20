@extends('layouts.user_type.guest')

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Reset Password</h3>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="{{ route('linkforgot') }}">
                    @csrf

                    @if (\Session::has('success'))
                        <h1 class="text-success" style="font-size: medium;">{!! \Session::get('success') !!}</h1>
                    @endif
                    @if (\Session::has('error'))
                        <h1 class="text-danger" style="font-size: medium;">{!! \Session::get('error') !!}</h1>
                    @endif
                    {{-- @error('email')
                      <h1 class="text-danger" style="font-size: medium;">{{ $message }}</h1>
                    @enderror --}}
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                      {{-- @error('email')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror --}}
                    </div>
                    
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Reset Password</button>
                    </div>
                    <p class="text-sm mt-3 mb-0">Sudah Reset / Ingat Password? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Masuk</a></p>

                  </form>
                </div>
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/loginbg.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
