@extends('admin.include')
@section('admincontent')
                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Profile details</h4>
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($customer)>0)
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                                                <input type="text" class="form-control border border-dark" value="{{ $customer->userid }}" readonly>
                                            </div>
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-list"></i></div>
                                                <input class="form-control border border-dark" value="{{ $customer->country }}" readonly>
                                            </div>
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-id-card-alt"></i></div>
                                                <input type="text" class="form-control border border-dark" value="{{ $customer->sponsor }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-envelope"></i></div>
                                                <input type="email" class="form-control border border-dark" value="{{ $customer->email }}" readonly>
                                            </div>
                        
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-phone-square"></i></div>
                                                <input type="text" class="form-control border border-dark" value="{{ $customer->phone }}" readonly>
                                            </div>
                        
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-building"></i></div>
                                                <input class="form-control border border-dark" value="{{ $customer->club }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-info mb-4">A2C= Account to Customer, A2A = Account to Admin</div>
                                    <a href="{{ route('changePassword',['id'=>$customer->id]) }}" class="btn btn-danger mb-2 mb-md-0">Change Password</a>
                                    <a href="{{ route('a2cTransfer',['id'=>$customer->id]) }}" class="btn btn-success mb-2 mb-md-0">A2C Coin Transfer</a>
                                    <a href="{{ route('a2aTransfer',['id'=>$customer->id]) }}" class="btn btn-primary mb-2 mb-md-0">A2A Coin Transfer</a>
                                    <a href="{{ route('activeUser') }}" class="btn btn-dark mb-2 mb-md-0">Go Active Profile</a>
                                    <a href="{{ route('bannedUser') }}" class="btn btn-warning mb-2 mb-md-0">Go Banned Profile</a>
                                    @else
                                        <div class="alert alert-warning">Sorry! No data found with your query</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection