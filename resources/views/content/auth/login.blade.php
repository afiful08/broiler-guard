@extends('layout.app')

@section('title', 'Login | Broiler Guard')

@section('body')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{ url('/')}}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('logo/chicken-farm-light.png') }}" alt="" width="180px">
                                </a>
                                <p class="text-center">Broiler Guard helps you manage your farm</p>
                                @error('auth')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  {{$message}}
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                                <form action="{{ url('/auth/login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="field-email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="field-email" aria-describedby="emailFeedback" value="{{ old('email') }}">
                                        @error('email')
                                            <div id="emailFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="field-password" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="field-password" aria-describedby="passwordFeedback">
                                        @error('password')
                                            <div id="passwordFeedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
