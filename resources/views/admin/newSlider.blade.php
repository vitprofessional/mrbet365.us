@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Slider</h4>
                                    <p class="text-muted mb-0">Add new slider to homepage banner
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveSlider') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="heading">Banner Title</label>
                                            <input type="text" name="heading" class="form-control" placeholder="Enter slider title">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="details">Banner Details</label>
                                            <input type="text" name="details" class="form-control" placeholder="Enter slider details">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="btnTxt">Button Text</label>
                                            <input type="text" name="btnTxt" class="form-control" placeholder="Enter button text">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="slider">Banner</label>
                                            <input type="file" name="slider" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                        </div>
                                    </form>
                                    <a href="{{ route('sliderList') }}" class="btn btn-light">Slider List</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection