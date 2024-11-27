@extends('front-ui.include')
@section('uititle')
    Admin Login
@endsection
@php
    $admindetails   = \App\Models\AdminUser::all();
@endphp
@section('uicontent')
    <div class="row align-items-center my-4">
        <div class="col-10 card shadow col-md-4 mx-auto sitemodel p-4 my-4">
            @if(count($admindetails)>0)
            <div class="card-header fw-bold text-center">
                <h2><i class="fas fa-paper-plane"></i> Admin Login</h2>
            </div>
            @else
            <div class="card-header fw-bold text-center">
                <h2><i class="fas fa-paper-plane"></i> Admin Signup</h2>
            </div>
            @endif
            <div class="card-body"> 
                @if(Session::get('success'))
                  <div class="alert alert-success border-0">
                    <span>{!! Session::get('success') !!}</span>
                  </div>
                @endif
                @if(Session::get('error'))
                  <div class="alert alert-danger border-0">
                    <span>{!! Session::get('error') !!}</span>
                  </div>
                @endif
                @if(count($admindetails)>0)
                <form class="form" action="{{ route('confirmAdminLogin') }}" method="POST">
                      {{ csrf_field() }}
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                        <input type="text" class="form-control border border-dark" name="adminId" placeholder="Enter admin id or admin email">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                        <input type="password" class="form-control border border-dark" name="loginPass" placeholder="Enter login password">
                    </div>
                    <div class="input-group d-grid gap-2 mb-2">
                        <input type="submit" class="btn btn-dark font-15 fw-bold" value="Procced to Login" />
                    </div>
                </form>
                @else
                <form class="form" action="{{ route('confirmSuperAdminRegister') }}" method="POST">
                      {{ csrf_field() }}
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-building"></i></div>
                        <input type="text" class="form-control border border-dark" name="company" placeholder="Enter company name">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                        <input type="text" class="form-control border border-dark" name="adminId" placeholder="Super admin id">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-envelope"></i></div>
                        <input type="text" class="form-control border border-dark" name="adminEmail" placeholder="Super admin email">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                        <input type="password" class="form-control border border-dark" name="loginPass" placeholder="Enter login password">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                        <input type="password" class="form-control border border-dark" name="conPass" placeholder="Confirm login password">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-phone-square"></i></div>
                        <input type="text" class="form-control border border-dark" name="phoneNumber" placeholder="Enter super admin mobile number">
                    </div>
                    <div class="input-group d-grid gap-2 mb-2">
                        <input type="submit" class="btn btn-dark font-15 fw-bold" value="Create Admin Account" />
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection