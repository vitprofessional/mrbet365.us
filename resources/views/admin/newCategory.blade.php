@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Category</h4>
                                    <p class="text-muted mb-0">Create a category to this page
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveCategory') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="catName">Category Name</label>
                                            <input type="text" name="catName" class="form-control" placeholder="Enter category name" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="catName">Icon Image</label>
                                            <input type="file" name="catLogo" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection