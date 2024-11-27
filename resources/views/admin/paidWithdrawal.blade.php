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
                                                    <h4 class="card-title">Withdraw Request Paid List</h4>
                                                    <p class="text-muted mb-0">All customer withdrawal request are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Date</th>
                                                                <th>User</th>
                                                                <th>Method </th>
                                                                <th>Account </th>
                                                                <th>Tk </th>
                                                                <th>Reference </th>
                                                                <th>Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($withdraw)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($withdraw as $d)
                                                            @php
                                                            $date=date_create($d->updated_at);
                                                            $trnas_time=  date_format($date,"Y/m/d h:i:s A");
                                                                $profile    = \App\Models\BetUser::find($d->user);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $d->id }}</td>
                                                                <td>{{ $trnas_time }}</td>
                                                                <td>{{ $profile->userid }}</td>
                                                                <td>{{ $d->paymentType }}</td>
                                                                <td>{{ $d->toNumber }}</td>
                                                                <td>{{ $d->amount }}</td>
                                                                <td>{{ $d->trans_id }}</td>
                                                                <td>{{ $d->status }}</td>
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