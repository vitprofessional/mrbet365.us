@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Club</h4>
                                    <p class="text-muted mb-0">Update club details
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($club)>0)
                                        <form class="form" method="Post" action="{{ route('updateClub') }}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="clubid" value="{{ $club->id }}">
                                            <div class="form-group pb-2">
                                                <label for="clubName">Name</label>
                                                <input type="text" name="clubName" value="{{ $club->fullname }}" class="form-control" placeholder="Enter a club name" required>
                                            </div>
                                            <div class="form-group pb-2">
                                                <label for="loginID">Login ID</label>
                                                <input type="text" name="loginID" value="{{ $club->clubid }}" class="form-control" placeholder="Enter club login ID" required>
                                            </div>
                                            <div class="form-group pb-2">
                                                <label for="loginPass">Password(Leave this field blank if not interested to change password)</label>
                                                <input type="text" name="loginPass" class="form-control" placeholder="Enter club login password">
                                            </div>
                                            <div class="form-group pb-2">
                                                <label for="clubEmail">Email</label>
                                                <input type="text" name="clubEmail" value="{{ $club->email }}" class="form-control" placeholder="Enter club email" required>
                                            </div>
                                            <div class="form-group pb-2">
                                                <label for="clubMobile">Mobile</label>
                                                <input type="text" name="clubMobile" value="{{ $club->phone }}" class="form-control" placeholder="Enter club mobile" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Update Club">
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">Sorry! No club found for update</div>
                                    @endif 
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection