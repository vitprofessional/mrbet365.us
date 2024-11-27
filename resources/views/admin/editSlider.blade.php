@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Slider</h4>
                                    <p class="text-muted mb-0">Update an existing slider
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($slider)>0)
                                    <form class="form" method="Post" action="{{ route('updateSlider') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="slideId" value="{{ $slider->id }}">
                                        <div class="form-group pb-2">
                                            <label for="heading">Banner Title</label>
                                            <input type="text" name="heading" class="form-control" placeholder="Enter banner title" value="{{ $slider->heading }}">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="details">Banner Details</label>
                                            <input type="text" name="details" class="form-control" placeholder="Enter banner details" value="{{ $slider->details }}">
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="btnTxt">Button Text</label>
                                            <input type="text" name="btnTxt" class="form-control" placeholder="Enter button text" value="{{ $slider->btnTxt }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <img class="img-fluid img-thumbnail" src="{{ $slider->slider }}" alt="{{ $slider->heading }}">
                                            </div>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="slide">Media</label>
                                            <input type="file" name="slide" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </form>
                                    @else
                                        <div class="alert alert-warning">Sorry! No data found with your query</div>
                                    @endif
                                    <a href="{{ route('sliderList') }}" class="btn btn-light">Slider List</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection