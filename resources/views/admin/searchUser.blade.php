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
                                                    <h4 class="card-title">Search User</h4>
                                                    <p class="text-muted mb-0">Enter user details for enquary
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <form class="form" method="POST" action="{{ route('singleUser') }}">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="userId">UserId/Email</label>
                                                            <input type="text" name="userid" class="form-control" placeholder="Enter user id or email for enquary">
                                                        </div>
                                                        <div class="mb-4">
                                                            <input type="submit" class="btn btn-primary" value="Search Here">
                                                        </div>
                                                    </form>
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