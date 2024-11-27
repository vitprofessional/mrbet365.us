@extends('otikaAdmin.include')

@section('otikaTitle')
    Dashboard
@endsection

@section('otikaContent')
@php
    $carbonDate = \Carbon\Carbon::now()->format('Y-m-d');
    $customer     = \App\Models\BetUser::all();
    $daysCustomer = \App\Models\BetUser::where('created_at','like', '%'.$carbonDate.'%')->get();
    $daysBetCustomer = \App\Models\UserBet::where('created_at','like', '%'.$carbonDate.'%')->get();
    $daysBetAmount = \App\Models\UserBet::where('created_at','like', '%'.$carbonDate.'%')->get()->sum('betAmount');
    $daysDeposit  = \App\Models\Deposit::where('updated_at','like', '%'.$carbonDate.'%')->where('status','Accept')->get()->sum('amount');
    $pendingDeposit  = \App\Models\Deposit::where('status','Pending')->get()->sum('amount');
    $daysWithdraw = \App\Models\WithdrawalRequest::where('updated_at','like', '%'.$carbonDate.'%')->where('status','Paid')->get()->sum('amount');
    $pendingWithdraw = \App\Models\WithdrawalRequest::where('status','Pending')->orWhere('status','Processing')->get()->sum('amount');
    $totalCustomer      = count($customer);
    $todayCustomer      = count($daysCustomer);
    $todayDepositCustomer   = count($daysDeposit);
    $todayWithdrawCustomer  = count($daysWithdraw);
    $todayBetCustomer       = count($daysBetCustomer);
    
    
    $superAdmin     = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Super Admin'])->first();
    $financeAdmin   = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level One'])->first();
    $betAdmin       = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level Two'])->first();
    $name           = $admin->adminid;
    $mediaurl   = url('/');
    $mainurl    = $mediaurl;
@endphp
        <section class="section">
          <div class="section-body">
            @if(!empty($superAdmin) && count($superAdmin)>0)
              <div class="row ">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15">Site Total Customer</h5>
                              <h2 class="mb-3 font-18">{{ $totalCustomer }}</h2>
                              <p class="mb-0"><span class="col-green">{{ $todayCustomer }}</span> Today</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/2.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15"> Days Deposit Amount</h5>
                              <h2 class="mb-3 font-18">{{ $daysDeposit }}</h2>
                              <p class="mb-0"><span class="col-orange">{{ $pendingDeposit }}</span> Pending</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/deposit.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15">Days Withdrawal</h5>
                              <h2 class="mb-3 font-18">{{ $daysWithdraw }}</h2>
                              <p class="mb-0"><span class="col-orange">{{ $pendingWithdraw }}</span>
                                Pending</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/withdraw.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15">Days Bet Amount</h5>
                              <h2 class="mb-3 font-18">{{ $daysBetAmount }}</h2>
                              <p class="mb-0"><span class="col-green">{{ $todayBetCustomer }}</span> Bet Today</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/4.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @elseif(!empty($financeAdmin) && count($financeAdmin)>0)
              <div class="row ">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15"> Days Deposit Amount</h5>
                              <h2 class="mb-3 font-18">{{ $daysDeposit }}</h2>
                              <p class="mb-0"><span class="col-orange">{{ $pendingDeposit }}</span> Pending</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/deposit.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15">Days Withdrawal</h5>
                              <h2 class="mb-3 font-18">{{ $daysWithdraw }}</h2>
                              <p class="mb-0"><span class="col-orange">{{ $pendingWithdraw }}</span>
                                Pending</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/withdraw.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            @elseif(!empty($betAdmin) && count($betAdmin)>0)
              <div class="row ">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15">Site Total Customer</h5>
                              <h2 class="mb-3 font-18">{{ $totalCustomer }}</h2>
                              <p class="mb-0"><span class="col-green">{{ $todayCustomer }}</span> Today</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/2.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15">Days Bet Amount</h5>
                              <h2 class="mb-3 font-18">{{ $daysBetAmount }}</h2>
                              <p class="mb-0"><span class="col-green">{{ $todayBetCustomer }}</span> Bet Today</p>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                              <img src="{{ asset('/') }}otikaAdmin/assets/img/banner/4.png" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @else
                <div class="alert alert-warning">
                    You have no permission to view this page
                </div>
            @endif
            
            @if(count($superAdmin)>0 || count($betAdmin)>0)
            <div class="row">
                @php
                    $category = \App\Models\Category::all();
                    if(count($category)>0):
                        $x=1;
                        foreach($category as $cat):
                            $liveMatch = \App\Models\Matche::where(['category'=>$cat->id,'status'=>1])->orderBy('matchTime','ASC')->get();
                @endphp
                <div class="col-12">
                    <div class="card">
                        <div class="card-header @if($x%2==0) bg-primary @elseif($x%3==0) bg-danger @else bg-success @endif text-white fw-bold">Live {{ $cat->name }}</div>
                        <div class="card-body row g-2">
                            @if(count($liveMatch)>0)
                                @foreach($liveMatch as $lm)
                                <div class="col-12 col-md-4">
                                    <div class="@if($x%2==0) bg-primary @else bg-success @endif text-white p-3 rounded my-2 text-center border-dotted border-3 border-white">
                                        <p class="font-18 text-white">{{ $lm->matchName }}</p>
                                        <p><span class="bg-dark p-2 text-white rounded">{{ \Carbon\Carbon::parse($lm->matchTime)->format('j M Y, g:i:s A') }}</span></p>
                                        <a href="{{ route('liveRoom',['id'=>$lm->id]) }}" class="btn btn-danger my-2"><i class="fas fa-tv"></i> Live Room</a>
                                        <a href="{{ route('profitLoss',['id'=>$lm->id]) }}" class="btn btn-warning my-2"><i class="fas fa-money-bill-alt"></i> Profit/Loss</a>
                                        <a href="{{ route('matchBetHistory',['id'=>$lm->id]) }}" class="btn btn-dark my-2"><i class="fas fa-gamepad"></i> Bets</a>
                                    <a href="{{ route('matchStatus',['id'=>$lm->id,'tournament'=>$lm->tournament,'status'=>2]) }}" class="btn @if($x%2==0) btn-success @else btn-primary @endif">@if($lm->status==1)<i class="fas fa-eye-slash"></i> Unpublish @else<i class="fas fa-eye"></i>  Publish @endif</a>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="alert alert-info fw-bold">Sorry! No live match found in fixture</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @php
                        $x++;
                        endforeach;
                    endif;
                @endphp
            </div><!--end row-->
            @endif
          </div>
        </section>
@endsection