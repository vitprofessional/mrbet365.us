@extends('front-ui.include')
@section('uititle')
    User Register
@endsection
@section('uicontent')
@php
    $sd = \App\Models\SiteConfig::orderBy('id', 'desc')->first();
@endphp
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('submitClubWithdraw') }}" autocomplete="off" method="POST">
            {{ csrf_field() }}
            <div class="col-10 col-md-6 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fab fa-google-wallet"></i> Make Withdraw</h2>
                    <p>Withdrawal time 9.00 AM-9.00 PM</p>
                    <a href="{{ route('clubWithdrawHistory',['club'=>$clubDetails->id]) }}" class="btn btn-dark mt-4 fw-bold">History</a>
                </div> 
                <div class="card-body row">
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
                    <div class="alert alert-warning fw-bold">Minimum withdrawal amount {{ $sd->minWithdraw }} & Maximum {{ $sd->maxWithdraw }}</div>
                    <input type="hidden" name="clubid" value="{{ $clubDetails->id }}">
                    <div class="col-12 mx-auto">
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-donate"></i></div>
                            <input type="number" class="form-control border border-dark" name="amount" placeholder="Number of coins*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="password" class="form-control border border-dark" name="password" placeholder="Enter account password" required>
                        </div>
                        
                        <div class="input-group d-grid gap-2 mb-2">
                            <button type="submit" class="btn btn-dark model-btn"><i class="fas fa-sign-in-alt"></i> Submit Request</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
@endsection