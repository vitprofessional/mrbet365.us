@extends('front-ui.include')
@section('uititle')
    Club Login
@endsection
@php
    session_start();
    session_destroy();
    $clubDetails   = \App\Models\BettingClub::all();
@endphp
@section('uicontent')
    <div class="row align-items-center my-4">
        <div class="col-10 card shadow col-md-4 mx-auto sitemodel p-4 my-4">
            <div class="card-header fw-bold text-center">
                <h2><i class="fas fa-building"></i> Club Login</h2>
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
                <form class="form" action="{{ route('confirmClubLogin') }}" method="POST">
                      {{ csrf_field() }}
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                        <input type="text" class="form-control border border-dark" name="clubId" placeholder="Enter club id or email">
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                        <input type="password" class="form-control border border-dark" name="loginPass" placeholder="Enter login password">
                    </div>
                    <div class="input-group d-grid gap-2 mb-2">
                        <input type="submit" class="btn btn-dark font-15 fw-bold" value="Login to Club" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection