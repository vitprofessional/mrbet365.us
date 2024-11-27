@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header text-center">
                                    <h3 class="text-white fw-bold display-6">Reports from {{ $formDate }} - {{ $toDate }}</h3>
                                </div>
                                @php
                                    if(count($DepositReport)>0 && count($WithdrawReport)>0):
                                        $sumDeposit = $DepositReport->sum('amount');
                                        $sumWithdraw = $WithdrawReport->sum('amount');
                                    elseif(count($DepositReport)>0):
                                        $sumDeposit = $DepositReport->sum('amount');
                                    elseif(count($WithdrawReport)>0):
                                        $sumWithdraw = $WithdrawReport->sum('amount');
                                    else:
                                        $sumDeposit = "";
                                        $sumWithdraw = "";
                                    endif;
                                @endphp
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                        @if(!empty($DepositReport) && count($DepositReport)>0)
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Deposit Report</h4>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>UserID</th>
                                                                <th>Method</th>
                                                                <th>Amount</th>
                                                                <th>Form</th>
                                                                <th>To</th>
                                                                <th>AdminID</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($DepositReport as $dp)
                                                            @php
                                                                $userId = \App\Models\BetUser::find($dp->user);
                                                                $adminId = \App\Models\AdminUser::find($dp->acceptBy);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $dp->id }}</td>
                                                                <td>{{ $userId->userid }}</td>
                                                                <td>{{ $dp->method }}</td>
                                                                <td>{{ $dp->amount }}</td>
                                                                <td>{{ $dp->fromNumber }}</td>
                                                                <td>{{ $dp->toNumber }}</td>
                                                                <td>{{ $adminId->adminid }}</td>
                                                                <td>{{ $dp->created_at->format('d-m-y h:i A') }}</td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <p>Total Data: {{ count($DepositReport) }} | Total Amount: {{ $sumDeposit }}</p>
                                        @endif
                                        @if(!empty($WithdrawReport) && count($WithdrawReport)>0)
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Withdrawal Report</h4>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>UserID</th>
                                                                <th>Method</th>
                                                                <th>Amount</th>
                                                                <th>Number</th>
                                                                <th>TxnId</th>
                                                                <th>AdminID</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($WithdrawReport as $wd)
                                                            @php
                                                                $userId = \App\Models\BetUser::find($wd->user);
                                                                $adminId = \App\Models\AdminUser::find($wd->acceptBy);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $x }}</td>
                                                                <td>{{ $userId->userid }}</td>
                                                                <td>{{ $wd->paymentType }}</td>
                                                                <td>{{ $wd->amount }}</td>
                                                                <td>{{ $wd->toNumber }}</td>
                                                                <td>{{ $wd->trans_id }}</td>
                                                                <td>{{ $adminId->adminid }}</td>
                                                                <td>{{ $wd->created_at->format('d-m-y h:i A') }}</td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <p>Total Data: {{ count($WithdrawReport) }} | Total Amount: {{ $sumWithdraw }}</p>
                                        @endif
                                        <div class="bg-dark text-white p-2 my-3">
                                            Profit/Loss: (Deposit {{ $sumDeposit }} - Withdrawal {{ $sumWithdraw }}) = {{ $sumDeposit-$sumWithdraw }}
                                        </div>
                                        <a href="{{ route('customerReport') }}" class="btn btn-dark">Go Back</a>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection