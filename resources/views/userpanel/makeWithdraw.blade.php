@extends('front-ui.include')
@section('uititle')
    Withdraw Request
@endsection
@section('uicontent')
@php
    $sc = \App\Models\SiteConfig::first();
@endphp
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('withdrawRequest') }}" autocomplete="off" method="POST">
            {{ csrf_field() }}
            <div class="col-10 col-md-6 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fab fa-google-wallet"></i> Make Withdraw</h2>
                    @if($sc->userWithdrawStatus==1)
                    <p>Withdrawal {{ $sc->depositMessage }}</p>
                    @endif
                    <a href="{{ route('withdrawHistory') }}" class="btn btn-dark mt-4 fw-bold">History</a>
                </div> 
                <div class="card-body row">
                @if($sc->userWithdrawStatus==2)
                    <div class="alert alert-warning">Sorry! User withdrawal system is now remain close</div>
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
                    <div class="alert alert-warning fw-bold">Minimum withdrawal amount {{ $sc->minWithdraw }} & Maximum {{ $sc->maxWithdraw }}</div>
                    <div class="col-12 mx-auto">
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-list"></i></div>
                            <select name="paymentType" class="form-control border border-dark" required>
                                <option value="Bkash Personal">Bkash Personal</option>
                                <!--<option value="Nagad Personal">Nagad Personal</option>-->
                                <!--<option value="Rocket Personal">Rocket Personal</option>-->
                                <option value="Bkash Agent">Bkash Agent</option>
                                <!--<option value="Nagad Agent">Nagad Agent</option>-->
                                <!--<option value="Rocket Agent">Rocket Agent</option>-->
                            </select>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-donate"></i></div>
                            <input type="number" class="form-control border border-dark" name="amount" placeholder="Number of coins*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-phone"></i></div>
                            <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" name="toNumber" class="form-control border border-dark" placeholder="Account Number" maxlength="11" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="password" class="form-control border border-dark" name="password" placeholder="Enter account password" required>
                        </div>
                        
                        <div class="input-group d-grid gap-2 mb-2">
                            <button type="submit" class="btn btn-dark model-btn"><i class="fas fa-sign-in-alt"></i> Submit Request</button>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </form>
    </div>
@endsection