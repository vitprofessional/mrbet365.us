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
                                                    <h4 class="card-title">Deposit Unpaid List</h4>
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
                                                                <th>From Account/th>
                                                                <th>To Account</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
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
                                                                <td>{{ $d->status }}</td>
                                                                <td><a title="Return Back to Pending List" href="{{ route('returnDeposit',['id'=>$d->id]) }}" class="btn btn-danger btn-sm"><i class="fas fa-reply"></i> </a></td>
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