@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Category</h4>
                                    <p class="text-muted mb-0">Update a category to this page
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($category)>0)
                                    <form class="form" method="Post" action="{{ route('updateCategory') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="catId" value="{{ $category->id }}">
                                        <div class="form-group pb-2">
                                            <label for="catName">Category Name</label>
                                            <input type="text" name="catName" class="form-control" placeholder="Enter category name" value="{{ $category->name }}" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <img class="img-fluid img-thumbnail" src="/public/{{ $category->catLogo }}" alt="{{ $category->catName }}">
                                            </div>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="catName">Icon Image</label>
                                            <input type="file" name="catLogo" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </form>
                                    @else
                                        <div class="alert alert-warning">Sorry! No data found with your query</div>
                                    @endif
                                    <a href="{{ route('categoryList') }}" class="btn btn-dark">Back to Category</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection