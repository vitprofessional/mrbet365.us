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
                                        <h4 class="card-title">Withdraw Request Processing List</h4>
                                        <p class="text-muted mb-0">All customer withdrawal request are listed here
                                        </p>
                                    </div><!--end card-header-->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SL</th>
                                                        <th>Request Date</th>
                                                        <th>Request User</th>
                                                        <th>Payment Type </th>
                                                        <th>To Account </th>
                                                        <th>Amount </th>
                                                        <th>Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($withdraw)>0)
                                                    @php
                                                        $x=1;
                                                    @endphp
                                                    @foreach($withdraw as $d)
                                                    @php
                                                        $profile    = \App\Models\BetUser::find($d->user);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $d->id }}</td>
                                                        <td>{{ $d->created_at->format('d-m-y h:i A') }}</td>
                                                        <td>{{ $profile->userid }}</td>
                                                        <td>{{ $d->paymentType }}</td>
                                                        <td>{{ $d->toNumber }}</td>
                                                        <td>{{ $d->amount }}</td>
                                                        <td>
                                                            <a href="{{ route('acceptWithdrawal',['id'=>$d->id]) }}" class="btn btn-success btn-sm mx-2"><i class="fas fa-check-square"></i></a>
                                                            <a href="{{ route('rejToPenWithdraw',['id'=>$d->id]) }}" class="btn btn-danger btn-sm mx-2"><i class="fas fa-window-close"></i></a>
                                                        </td>
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
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection