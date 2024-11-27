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
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Placed Date</th>
                                                                <th>Bet Option</th>
                                                                <th>Bet Amount</th>
                                                                <th>Bet Rate</th>
                                                                <th>Return Amount</th>
                                                                <th>Match</th>
                                                                <th>Tournament</th>
                                                                <th>Win Option</th>
                                                                <th>Profit/Loss </th>
                                                                <th>Partial Amount</th>
                                                                <th>Partial Rate</th>
                                                                <th>Status</th>
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
                                                                <td>{{ $d->updated_at }}</td>
                                                                <td>{{ $profile->userid }}</td>
                                                                <td>{{ $d->fromNumber }}</td>
                                                                <td>{{ $d->toNumber }}</td>
                                                                <td>{{ $d->amount }}</td>
                                                                <td>
                                                                    <a href="{{ route('acceptDeposit',['id'=>$d->id]) }}" class="btn btn-primary btn-sm" onclick="return confirm('are you sure to accept this transaction?')"><i class="fas fa-check-square"></i></a>
                                                                    <a href="{{ route('rejectDeposit',['id'=>$d->id]) }}" class="btn btn-warning btn-sm" onclick="return confirm('are you sure to reject this transaction?')"><i class="fas fa-window-close"></i></a>
                                                                    <a href="{{ route('deleteDeposit',['id'=>$d->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')"><i class="fas fa-trash"></i></a>
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