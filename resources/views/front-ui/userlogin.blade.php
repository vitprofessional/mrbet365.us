@extends('front-ui.include')
@section('uititle')
    Homepage Bet
@endsection
@include('front-ui.loginregistermodal')
@section('uicontent')
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('confirmLogin') }}" method="POST">
              {{ csrf_field() }}
            <div class="col-10 card shadow col-md-4 mx-auto sitemodel p-4 my-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-paper-plane"></i> User Login</h2>
                </div>
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
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                        <input type="text" class="form-control border border-dark" name="userId" placeholder="Enter your email or user id">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                        <input type="password" class="form-control border border-dark" name="loginPass" placeholder="Enter your login password">
                    </div>
                    <div class="input-group d-grid gap-2 mb-2">
                        <input type="submit" class="btn btn-dark btn-lg" value="Submit" />
                    </div>
                    <div class="text-center">
                        <a href="{{ route('userRegister') }}" class="text-dark"><i class="fas fa-users"></i> Don't have an account? <span class="btn btn-primary btn-sm">Join Now</span> </a>
                    </div>
                    
                </div>
                
            </div>
        </form>
    </div>
@endsection