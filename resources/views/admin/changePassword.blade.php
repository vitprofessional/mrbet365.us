@extends('admin.include')
@section('admincontent')
                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update password of the profile <span class="text-danger fw-bold">{{ $customer->userid }}</span></h4>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($customer)>0)
                                    <a href="{{ route('editUser',['id'=>$customer->id]) }}" class="btn btn-dark">View Profile</a>
                                    <div class="row">
                                        <div class="col-12 col-md-6 mx-auto">
                                            <h3>Change Password</h3>
                                            <form class="form" method="POST" action="{{ route('changeUserPass') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="profileid" value="{{ $customer->id }}">
                                                <div class="input-group mb-4">
                                                    <div class="input-group-text border border-warning text-warning"><i class="fas fa-key"></i></div>
                                                    <input type="password" class="form-control border border-warning" name="newpass" placeholder="Enter new password*" required>
                                                </div>
                                                <div class="input-group mb-4">
                                                    <div class="input-group-text border border-success text-success"><i class="fas fa-key"></i></div>
                                                    <input type="password" class="form-control border border-success" name="conpass" placeholder="Confirm password again*" required>
                                                </div>
                                                <div class="input-group d-grid gap-2 mb-2">
                                                    <input type="submit" class="btn btn-dark model-btn" value="Update Password" />
                                                </div>
                                            </form>
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