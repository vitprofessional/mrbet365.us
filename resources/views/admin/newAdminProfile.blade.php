@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Admin</h4>
                                    <p class="text-muted mb-0">Create a new admin profile to manage the system
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveAdminProfile') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="adminId">Admin ID</label>
                                            <input type="text" name="adminId" class="form-control" placeholder="Enter admin login ID" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter admin email" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" name="mobile" class="form-control" placeholder="Enter admin mobile number" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="adminPass">Password</label>
                                            <input type="password" name="adminPass" class="form-control" placeholder="Enter admin password" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="adminRule">Admin Rule</label>
                                            <select name="adminRule" class="form-control" required>
                                                <option value="Super Admin">Super Admin</option>
                                                <option value="Level One">Finance Admin</option>
                                                <option value="Level Two">Bet Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="status">Admin Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Create Admin">
                                            <a href="{{ route('manageAdmin') }}" class="btn btn-dark">Manage Admin</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection