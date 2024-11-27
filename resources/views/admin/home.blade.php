@extends('admin.include')
@section('admincontent')
@php
    $carbonDate = \Carbon\Carbon::now()->format('Y-m-d');
    $customer     = \App\Models\BetUser::all();
    $daysCustomer = \App\Models\BetUser::where('created_at','like', '%'.$carbonDate.'%')->get();
    $daysBetCustomer = \App\Models\UserBet::where('created_at','like', '%'.$carbonDate.'%')->get();
    $daysBetAmount = \App\Models\UserBet::where('created_at','like', '%'.$carbonDate.'%')->get()->sum('betAmount');
    $daysDeposit  = \App\Models\Deposit::where('updated_at','like', '%'.$carbonDate.'%')->where('status','Accept')->get()->sum('amount');
    $daysWithdraw = \App\Models\WithdrawalRequest::where('updated_at','like', '%'.$carbonDate.'%')->where('status','Paid')->get()->sum('amount');
    $totalCustomer      = count($customer);
    $todayCustomer      = count($daysCustomer);
    $todayBetCustomer   = count($daysBetCustomer);
    
    
    $superAdmin     = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Super Admin'])->first();
    $financeAdmin   = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level One'])->first();
    $betAdmin       = \App\Models\AdminUser::where(['id'=>Session::get('BetAdmin'),'rule'=>'Level Two'])->first();
    $name           = $admin->adminid;
    $mediaurl   = url('/');
    $mainurl    = $mediaurl;
@endphp
                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                    @if(!empty($superAdmin) && count($superAdmin)>0)
                        <div class="col-6 col-md-4">
                            <div class="bg-primary info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fas fa-users"></i> Total User
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $totalCustomer }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-success info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fas fa-users"></i> Today User
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $todayCustomer }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-danger info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fas fa-credit-card"></i> Deposit Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $daysDeposit }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-dark info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fas fa-donate"></i> Withdrawal Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $daysWithdraw }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-info info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fab fa-cc-diners-club"></i> Bet User Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $todayBetCustomer }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="bg-secondary info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fab fa-cc-diners-club"></i> Total Bet Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $daysBetAmount }}
                                </div>
                            </div>
                        </div>
                    @elseif(count($financeAdmin)>0)
                        <div class="col-6 col-lg-4 mx-auto">
                            <div class="bg-danger info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fas fa-credit-card"></i> Deposit Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $daysDeposit }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 mx-auto">
                            <div class="bg-dark info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fas fa-donate"></i> Withdrawal Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $daysWithdraw }}
                                </div>
                            </div>
                        </div>
                    @elseif(count($betAdmin)>0)
                        <div class="col-6 col-lg-4 mx-auto">
                            <div class="bg-info info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fab fa-cc-diners-club"></i> Bet User Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $todayBetCustomer }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-4 mx-auto">
                            <div class="bg-secondary info-box row align-items-center g-0">
                                <div class="col-12 col-md-8">
                                    <i class="fab fa-cc-diners-club"></i> Total Bet Today
                                </div>
                                <div class="col-12 col-md-4 text-end">
                                    {{ $daysBetAmount }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            You have no permission to view this page
                        </div>
                    @endif
                    </div>
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
                                        <div class="col-6 col-md-4">
                                            <div class="@if($x%2==0) bg-primary @else bg-success @endif text-white p-3 rounded my-2 text-center border-dotted border-3 border-white">
                                                <p class="fw-bold">{{ $lm->matchName }}</p>
                                                <p><span class="bg-dark p-2">{{ \Carbon\Carbon::parse($lm->matchTime)->format('j M Y, g:i:s A') }}</span></p>
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
    
                </div><!-- container -->
@endsection