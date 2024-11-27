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
                                                    <h4 class="card-title">Club  Unpaid Withdraw List</h4>
                                                    <p class="text-muted mb-0">All club withdrawal request are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Request Date</th>
                                                                <th>Request Club</th>
                                                                <th>To Account </th>
                                                                <th>Amount </th>
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
                                                                $profile    = \App\Models\BettingClub::find($d->club);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $d->id }}</td>
                                                                <td>{{ $d->updated_at }}</td>
                                                                <td>{{ $profile->clubid }}</td>
                                                                <td>{{ $d->toNumber }}</td>
                                                                <td>{{ $d->amount }}</td>
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