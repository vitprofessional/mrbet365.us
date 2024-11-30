@extends('admin.include')
@section('admincontent')
                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Admin Profile</h4>
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(!empty($admin)>0)
                                    <div class="card-header">
                                        <h4 class="card-title">Update Details</h4>
                                        </p>
                                    </div><!--end card-header-->
                                    <form class="row form my-2" method="POST" action="{{ route('updateAdmin') }}">
                                        @csrf
                                        <input type="hidden" name="adminId" value="{{ $admin->id }}">
                                        <div class="col-12 col-md-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-unlock"></i></div>
                                                <input type="text" class="form-control border border-dark" value="{{ $admin->adminid }}" readonly>
                                            </div>
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-list"></i></div>
                                                <input class="form-control border border-dark" value="{{ $admin->email }}" readonly>
                                            </div>
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-phone-square"></i></div>
                                                <input type="text" class="form-control border border-dark" value="{{ $admin->phone }}" name="phone">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-envelope"></i></div>
                                                <input type="email" class="form-control border border-dark" value="{{ $admin->rule }}" readonly>
                                            </div>
                        
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fab fa-google-wallet"></i></div>
                                                <input type="text" class="form-control border border-dark" value="{{ $admin->accountBalance }}" readonly>
                                            </div>
                                        </div>
                        
                                        <div class="input-group mb-4">
                                            <input type="submit" class="btn btn-success mb-2 mb-md-0" value="Update">
                                        </div>
                                    </form>
                                    <div class="card-header my-4">
                                        <h4 class="card-title">Change Password</h4>
                                        </p>
                                    </div><!--end card-header-->
                                    <form class="row form" method="POST" action="{{ route('updateAdminPass') }}">
                                        @csrf
                                        <input type="hidden" name="adminId" value="{{ $admin->id }}">
                                        <div class="col-7 mx-auto">
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                                                <input type="password" class="form-control border border-dark" name="oldPass" placeholder="Enter your current password">
                                            </div>
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                                                <input type="password" class="form-control border border-dark" name="newPass" placeholder="Enter your desire new password">
                                            </div>
                                            <div class="input-group mb-4">
                                                <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                                                <input type="password" class="form-control border border-dark" name="confirmPass" placeholder="Confirm new password">
                                            </div>
                        
                                            <div class="input-group mb-4">
                                                <input type="submit" class="btn btn-success mb-2 mb-md-0" value="Update" >
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                        <div class="alert alert-warning">Sorry! No data found with your query</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection