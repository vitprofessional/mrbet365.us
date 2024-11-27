@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card shadow row">
                                <div class="col-12">
                                    <div class="card-header">
                                        <h4 class="card-title">Withdraw Request-Pending List</h4>
                                        <p class="text-muted mb-0">All customer withdrawal request are listed here
                                        </p>
                                    </div><!--end card-header-->
                                    <div class="card-body table-responsive">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered">
                                                <thead class="text-center">
                                                    <th>SL</th>
                                                    <th>Statement </th>
                                                    <th>Amount</th>
                                                    <th>Payment Type </th>
                                                    <th>Payment Number</th>
                                                    <th>Action </th>
                                                    <th>Club</th>
                                                    <th>User</th>
                                                    <th>C.Balance</th>
                                                    <th>T.Deposit</th>
                                                    <th>C.Received</th>
                                                    <th>S.Bonus</th>
                                                    <th>T.Profit</th>
                                                    <th>T.Loss</th>
                                                    <th>C.Transfer</th>
                                                    <th>T.Withdraw</th>
                                                    <th>Date</th>
                                                </thead>
                                                <tbody>
                                                    @if(count($withdraw)>0)
                                                    @php
                                                        $x=1;
                                                    @endphp
                                                    @foreach($withdraw as $d)
                                                    
                                                    @php
                                                        $profile    = \App\Models\BetUser::find($d->user);
                                                        $tDeposit   = \App\Models\Deposit::where(['user'=>$profile->id,'status'=>'Accept'])->sum('amount');
                                                        $cReceived  = \App\Models\CoinTransfer::where(['c2cUser'=>$profile->userid,'status'=>'Complete'])->sum('amount');
                                                        $userLose  = \App\Models\UserBet::where(['user'=>$profile->id,'status'=>'2'])->sum('siteProfit');
                                                        $userProfit  = \App\Models\UserBet::where(['user'=>$profile->id,'status'=>'2','siteProfit'=>NULL])->sum('returnAmount');
                                                        $userBetTotal  = \App\Models\UserBet::where(['user'=>$profile->id,'status'=>'2','siteProfit'=>NULL])->sum('betAmount');
                                                        $userTotalProfit = $userProfit-$userBetTotal;
                                                        
                                                        $cTransfer  = \App\Models\CoinTransfer::where(['user'=>$profile->id,'status'=>'Complete'])->sum('amount');
                                                        $sponsorBonus  = \App\Models\BetUserStatement::where(['user'=>$profile->id,'note'=>'SponsorBonus'])->sum('transAmount');
                                                        $tWithdraw  = \App\Models\WithdrawalRequest::where(['user'=>$profile->id,'status'=>'Paid'])->sum('amount');
                                                    @endphp
                                                    <tr class="text-center p-1">
                                                        <td>{{ $d->id }}</td>
                                                        <td><a href="{{ route('checkUserStmt',['id'=>$profile->id]) }}" class="btn btn-dark btn-sm">Check Statement</a></td>
                                                        <td>{{ $d->amount }}</td>
                                                        <td class="h6">{{ $d->paymentType }}</td>
                                                        <td>{{ $d->toNumber }}</td>
                                                        <td style="min-width:100px">
                                                            <a href="{{ route('processingWithdrawal',['id'=>$d->id]) }}" class="btn btn-warning btn-sm m-3"><i class="fas fa-check-square" title="Lock for Processing"></i></a>
                                                            <a href="{{ route('rejectWithdrawal',['id'=>$d->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-window-close" title="Reject Withdrawal"></i></a>
                                                        </td>
                                                        <td>{{ $profile->club }}</td>
                                                        <td>{{ $profile->userid }}</td>
                                                        <td>{{ round($profile->balance,2) }}</td>
                                                        <td>{{ round($tDeposit,2) }}</td>
                                                        <td>{{ round($cReceived,2) }}</td>
                                                        <td>{{ round($sponsorBonus,2) }}</td>
                                                        <td>{{ round($userTotalProfit,2) }}</td>
                                                        <td>{{ round($userLose,2) }}</td>
                                                        <td>{{ round($cTransfer,2) }}</td>
                                                        <td>{{ round($tWithdraw,2) }}</td>
                                                        <td style="min-width:140px;font-size:12px;">{{ $d->created_at->format('d-m-y h:i A') }}</td>
                                                    </tr>
                                                    @php
                                                        $x++;
                                                    @endphp
                                                    @endforeach
                                                    @else
                                                    <tr class="success">
                                                        <td colspan="15">Sorry! Nothing to withdrawal</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection