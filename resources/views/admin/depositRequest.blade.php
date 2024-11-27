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
                                                    <h4 class="card-title">Deposit Request</h4>
                                                    <p class="text-muted mb-0">All customer deposit request are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Request Date</th>
                                                                <th>Request User</th>
                                                                <th>From Account</th>
                                                                <th>To Account </th>
                                                                <th>Amount </th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($deposit)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($deposit as $d)
                                                            @php
                                                                $profile    = \App\Models\BetUser::find($d->user);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $d->id }}</td>
                                                                <td>{{ $d->updated_at->format('d-M-y H:i:s A') }}</td>
                                                                <td>{{ $profile->userid }}</td>
                                                                <td>{{ $d->fromNumber }}</td>
                                                                <td>{{ $d->toNumber }}</td>
                                                                <td>{{ $d->amount }}</td>
                                                                <td>
                                                                    <a href="{{ route('acceptDeposit',['id'=>$d->id]) }}" class="text-success" onclick="return confirm('are you sure to accept this transaction?')"><i class="fas fa-check-square" title="Accept Deposit"></i></a>
                                                                    <a href="{{ route('rejectDeposit',['id'=>$d->id]) }}" class="text-danger" onclick="return confirm('are you sure to reject this transaction?')"><i class="fas fa-window-close" title="Reject Deposit"></i></a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! Nothing to deposit</td>
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