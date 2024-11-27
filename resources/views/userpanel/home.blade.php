@extends('front-ui.include')
@section('uititle') Dashboard @endsection
@section('uicontent')
    <div class="row align-items-center my-4">
        <div class="col-12 col-md-8 card shadow mx-auto sitemodel p-4">
            <div class="card-header fw-bold text-center">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <a href="{{ route('makeDeposit') }}" class="btn btn-dark mt-4 fw-bold"><i class="fab fa-google-wallet"></i> Make Deposit</a>
                <h2 class="mt-2 mt-md-3 text-start"><u>Account Details</u></h2>
            </div> 
            <div class="card-body row">
                <div class="col-12 mx-auto fw-bold font-15">
                    <p class="my-2" title="User ID"><i class="fas fa-user-circle"></i> {{ $details->userid }}</p>
                    <p class="my-2" title="Current Balance"><i class="fas fa-donate"></i> {{ number_format($details->balance,2) }}</p>
                    <p class="my-2" title="Account Mobile Number"><i class="fas fa-phone-square"></i> {{ $details->phone }}</p>
                    <p class="my-2" title="Account Email"><i class="fas fa-envelope"></i> {{ $details->email }}</p>
                    <p class="my-2" title="Sponsor ID"><i class="fas fa-user-secret"></i> @if(empty($details->sponsor)) N/A @else {{ $details->sponsor }} @endif</p>
                    <p class="my-2" title="Member of The Club"><i class="fas fa-building"></i> {{ $details->club }}</p>
                </div>
            </div> 
            <div class="card-header fw-bold text-center">
                <h2><u>Recent Activity</u></h2>
            </div> 
            <div class="card-body row">
                <div class="table-responsive">
                    <div class="fw-bold"><u>Deposit Request</u></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From Account</th>
                                <th>Amount</th>
                                <th>To Account</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $deposit = \App\Models\Deposit::where(['user'=>$details->id])->orderBy('updated_at','desc')->take(5)->get();
                            @endphp
                            @if(count($deposit)>0)
                                @foreach($deposit as $d)
                                <tr>
                                    <td>{{ $d->updated_at }}</td>
                                    <td>{{ $d->fromNumber }}</td>
                                    <td>{{ $d->amount }}</td>
                                    <td>{{ $d->toNumber }}</td>
                                    <td>{{ $d->status }}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5">No recent activity</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="fw-bold mt-4"><u>Withdrawal Request</u></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>To Account</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $withdraw = \App\Models\WithdrawalRequest::where(['user'=>$details->id])->orderBy('updated_at','desc')->take(5)->get();
                            @endphp
                            @if(count($withdraw)>0)
                                @foreach($withdraw as $w)
                                <tr>
                                    <td>{{ $w->updated_at }}</td>
                                    <td>{{ $w->toNumber }}</td>
                                    <td>{{ $w->amount }}</td>
                                    <td>{{ $w->status }}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5">No recent activity</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection