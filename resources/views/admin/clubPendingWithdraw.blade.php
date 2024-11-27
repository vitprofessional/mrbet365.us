@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Club Pending Withdraw</h4>
                                                    <p class="text-muted mb-0">All club withdrawal request are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Action </th>
                                                                <th>Club</th>
                                                                <th>C.Balance</th>
                                                                <th>T.Bonus</th>
                                                                <th>T.Withdraw</th>
                                                                <th>Receiving Phone</th>
                                                                <th>Current Withdraw</th>
                                                                <th>Payment Type </th>
                                                                <th>Club Statement </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                @if(count($withdraw)>0)
                @php
                    $x=1;
                @endphp
                @foreach($withdraw as $d)
                @php
                    $profile    = \App\Models\BettingClub::find($d->club);
                    $tWithdraw  = \App\Models\ClubWithdraw::where(['club'=>$profile->id,'status'=>'Paid'])->sum('amount');
                    $tbonus  = \App\Models\ClubStatement::where(['club'=>$profile->id])->sum('transAmount');
@endphp
                                        <tr>
                                            <td>{{ $d->id }}</td>
                                            <td style="min-width:150px">
                                                <a href="{{ route('clubProcessWithdraw',['id'=>$d->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-check-square" title="Lock for Processing"></i></a>
                                                <a href="{{ route('clubAcceptWithdraw',['id'=>$d->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-check-square" title="Accept Withdrawal"></i></a>
                                                <a href="{{ route('clubRejectWithdraw',['id'=>$d->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-window-close" title="Reject Withdrawal"></i></a>
                                            </td>
                                            <td>{{ $profile->clubid }}</td>
                                            <td>{{ $profile->balance }}</td>
                                            <td>{{ $tWithdraw }}</td>
                                            <td>{{ $tBonus }}</td>
                                            <td>{{ $d->toNumber }}</td>
                                            <td>{{ $d->amount }}</td>
                                            <td>{{ $d->paymentType }}</td>
                                            <td><a href="{{ route('checkClubStmt',['id'=>$profile->id]) }}" class="btn btn-dark btn-sm">Check Statement</a></td>
                                        </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! Nothing to withdrawal</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
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