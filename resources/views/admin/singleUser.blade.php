@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Search User</h4>
                                                    <p class="text-muted mb-0">Search result are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                            <th>SL</th>
                                                            <th>Statement</th>
                                                            <th>User</th>
                                                            <th>Password</th>
                                                            <th>Balance</th>
                                                            <th>T.Lose</th>
                                                            <th>Member Form</th>
                                                            <th>Club</th>
                                                            <th>T.Deposit</th>
                                                            <th>C.Received</th>
                                                            <th>S.Bonus</th>
                                                            <th>T.Profit</th>
                                                            <th>C.Transfer</th>
                                                            <th>T.Withdraw</th>
                                                            <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @if(count($customer)>0)
                                                    @php
                                                        $profile    = \App\Models\BetUser::find($customer->id);
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
                                                            <tr>
                                                                <td>{{ $customer->id }}</td>
                                                        <td><a href="{{ route('checkUserStmt',['id'=>$customer->id]) }}" class="btn btn-dark btn-sm">Check Data</a></td>
                                                                <td>{{ $customer->userid }}</td>
                                                                <td>{{ $customer->plainpassword }}</td>
                                                                <td>{{ round($customer->balance,2) }}</td>
                                                        <td>{{ $userLose }}</td>
                                                                <td>{{ $customer->created_at }}</td>
                                                        <td>{{ $profile->club }}</td>
                                                        <td>{{ round($tDeposit,2) }}</td>
                                                        <td>{{ round($cReceived,2) }}</td>
                                                        <td>{{ round($sponsorBonus,2) }}</td>
                                                        <td>{{ round($userTotalProfit,2) }}</td>
                                                        <td>{{ round($cTransfer,2) }}</td>
                                                        <td>{{ round($tWithdraw,2) }}</td>
                                                                <td>
                                                                    <a href="{{ route('editUser',['id'=>$customer->id]) }}" class="btn btn-primary"><i class="fas fa-pen-square" title="Update Profile"></i></a>
                                                                    @if($customer->status==5)
                                                                    <a href="{{ route('bannedStatus',['id'=>$customer->id]) }}" onclick="return confirm('are you sure to banned this profile?')" class="btn btn-danger" title="Banned Profile"><i class="fas fa-eye-slash"></i></a>
                                                                    @else
                                                                    <a href="{{ route('activeStatus',['id'=>$customer->id]) }}" onclick="return confirm('are you sure to active this profile?')" class="btn btn-success" title="Active Profile"><i class="fas fa-check-square"></i></a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! No user found to database</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="#" class="btn btn-dark">Add New</a>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection