@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Admin Profile</h4>
                                    <p class="text-muted mb-0">Update an existing admin profile
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                @if(count($adminUser)>0)
                                    <form class="form" method="Post" action="{{ route('updateAdminProfile') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="adminProfileId" value="{{ $adminUser->id }}">
                                        <div class="form-group pb-2">
                                            <label for="adminId">Admin ID</label>
                                            <input type="text" name="adminId" class="form-control" placeholder="Enter admin login ID" value="{{ $adminUser->adminid }}" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ $adminUser->email }}" placeholder="Enter admin email" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" name="mobile" class="form-control" value="{{ $adminUser->phone }}" placeholder="Enter admin mobile number" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="adminPass">Password <span class="text-danger fw-bold">(Leave this filed blank if no need to change password)</span></label>
                                            <input type="text" name="adminPass" class="form-control" placeholder="Enter admin new password(Optional)">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="adminRule">Admin Rule</label>
                                            <select name="adminRule" class="form-control" required>
                                                <option value="{{ $adminUser->rule }}">@if($adminUser->rule=="Level One") Finance Admin @elseif($adminUser->rule=="Level Two") Bet Amin @else Super Admin @endif</option>
                                                <option value="Super Admin">Super Admin</option>
                                                <option value="Level One">Finance Admin</option>
                                                <option value="Level Two">Bet Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="status">Admin Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="{{ $adminUser->status }}">{{ $adminUser->status }}</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Update Profile">
                                            <a href="{{ route('manageAdmin') }}" class="btn btn-dark">Manage Admin</a>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning">Sorry! No profile found to update</div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection