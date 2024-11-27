@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-8 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">                     Server Coin
                                                    </h4>
                                                    <p class="text-muted mb-0">
                                                        Server Coin History
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                                    <p class="fw-bold text-success">Current Amount: {{ $adminDetails->accountBalance; }}</p>
                                                    <form class="form" method="Post" action="{{ route('createServerCoin') }}" enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="form-group pb-2">
                                                            <label for="coinAmount">New Amount</label>
                                                            <input type="number" name="coinAmount" class="form-control" placeholder="Enter coin amount" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="submit" class="btn btn-primary" value="Create Coin">
                                                        </div>
                                                    </form>
                                                    <p class="h-2 fw-bold">Coin History</p>
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($coin)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($coin as $c)
                                                            <tr>
                                                                <td>{{ $c->id }}</td>
                                                                <td>{{ $c->amount }}</td>
                                                                <td>{{ $c->created_at }}</td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! No details found</td>
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