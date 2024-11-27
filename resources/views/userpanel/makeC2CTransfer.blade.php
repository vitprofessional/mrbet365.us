@extends('front-ui.include')
@section('uititle')
    Coin Transfer
@endsection
@php
    $siteConfig = \App\Models\SiteConfig::first();
@endphp
@section('uicontent')
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('C2CTransferRequest') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-10 col-md-6 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fab fa-google-wallet"></i> Coin Transfer</h2>
                    <a href="{{ route('C2CTransferHistory') }}" class="btn btn-dark mt-4 fw-bold">History</a>
                </div> 
                <div class="card-body row">
                @if($siteConfig->coinTransferStatus==2)
                    <div class="alert alert-warning">Sorry! Coin to coin transfer system is now remain close</div>
                @else
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
                    <div class="alert alert-warning fw-bold">Minimum c2c transfer {{ $siteConfig->minCoinTransfer }} & Maximum c2c transfer {{ $siteConfig->maxCoinTransfer }}</div>
                    <div class="col-12 mx-auto">
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-user-secret"></i></div>
                            <input type="text" name="userid" class="form-control border border-dark" placeholder="C2C user id" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-donate"></i></div>
                            <input type="number" class="form-control border border-dark" min="{{ $siteConfig->minCoinTransfer }}" max="{{ $siteConfig->maxCoinTransfer }}" name="amount" placeholder="Number of coins*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="password" class="form-control border border-dark" name="password" placeholder="Enter account password" required>
                        </div>
                        
                        <div class="input-group d-grid gap-2 mb-2">
                            <button type="submit" class="btn btn-dark model-btn"><i class="fas fa-sign-in-alt"></i> Transfer Coin </button>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </form>
    </div>
@endsection