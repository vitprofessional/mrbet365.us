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
                                                    <h4 class="card-title">Withdraw Request | Confirmation Page</h4>
                                                    <p class="text-muted mb-0">Transaction details are here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                @if($getData==0)
                    <div class="alert alert-warning">Sorry! No data found</div>
                @else
                @php
                    $profile    = \App\Models\BetUser::find($getData->user);
                    $tWithdraw  = \App\Models\ClubWithdraw::where(['club'=>$profile->id,'status'=>'Paid'])->sum('amount');
                    $tBonus  = \App\Models\BetUserStatement::where(['user'=>$profile->id,'note'=>'SponsorBonus'])->sum('transAmount');
                @endphp
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Action </th>
                                    <th>User</th>
                                    <th>C.Balance</th>
                                    <th>T.S.B</th>
                                    <th>T.Withdraw</th>
                                    <th>Receiving Phone</th>
                                    <th>Current Withdraw</th>
                                    <th>Payment Type </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $getData->id }}</td>
                                    <td style="min-width:150px">
                                        <a href="{{ route('processingWithdrawal',['id'=>$getData->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-check-square" title="Lock for Processing"></i></a>
                                        <a href="{{ route('rejectWithdrawal',['id'=>$getData->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-window-close" title="Reject Withdrawal"></i></a>
                                    </td>
                                    <td>{{ $profile->userid }}</td>
                                    <td>{{ $profile->balance }}</td>
                                    <td>{{ $tBonus }}</td>
                                    <td>{{ $tWithdraw }}</td>
                                    <td>{{ $getData->toNumber }}</td>
                                    <td>{{ $getData->amount }}</td>
                                    <td>{{ $getData->paymentType }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form class="form col-4" method="POST" action="{{ route('confirmWithdrawal') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="transid" value="{{ $getData->id }}">
                            <div class="form-group pb-2">
                                <label for="teamName">Reference Number</label>
                                <input type="text" name="trans_id" class="form-control border-dark" placeholder="Enter reference number" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Confirm Withdrawal">
                            </div>
                        </form>
                    @endif
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