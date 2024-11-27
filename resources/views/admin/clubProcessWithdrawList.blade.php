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
                                                    <h4 class="card-title">Club Withdraw Request Processing List</h4>
                                                    <p class="text-muted mb-0">All club withdrawal request are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Request Date</th>
                                                                <th>Request User</th>
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
                                                                $profile    = \App\Models\BettingClub::find($d->club);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $d->id }}</td>
                                                                <td>{{ $d->updated_at }}</td>
                                                                <td>{{ $profile->clubid }}</td>
                                                                <td>{{ $d->toNumber }}</td>
                                                                <td>{{ $d->amount }}</td>
                                                                <td>
                                                                    <a href="{{ route('clubAcceptWithdraw',['id'=>$d->id]) }}" class="btn btn-primary btn-sm"><i class="fas fa-check-square"></i></a>
                                                                    <a href="{{ route('clubRejectWithdraw',['id'=>$d->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-window-close"></i></a>
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
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection