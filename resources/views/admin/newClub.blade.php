@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Club</h4>
                                    <p class="text-muted mb-0">Create a club for the sponsors
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveClub') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="clubName">Name</label>
                                            <input type="text" name="clubName" class="form-control" placeholder="Enter a club name" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="loginID">Login ID</label>
                                            <input type="text" name="loginID" class="form-control" placeholder="Enter club login ID" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="loginPass">Password</label>
                                            <input type="password" name="loginPass" class="form-control" placeholder="Enter club login password">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="confirmPass">Confirm Password</label>
                                            <input type="password" name="confirmPass" class="form-control" placeholder="Confirm club login password">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Create Club">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection