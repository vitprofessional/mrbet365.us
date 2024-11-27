@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Bet Option</h4>
                                    <p class="text-muted mb-0">Create a new bet option for place betting
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveBetOption') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="catId">Category</label>
                                            <select name="catId" class="form-control border-dark" required>
                                                <option value="">-</option>
                                                @php
                                                    $category = \App\Models\Category::all();
                                                @endphp
                                                @if(count($category)>0)
                                                    @foreach($category as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach   
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="optName">Option Name</label>
                                            <input type="text" name="optName" class="form-control border-dark" placeholder="Enter bet question" required>
                                        </div>
                                        <div class='form-group pb-2'>
                                            <label for='optType'>Option Type</label>
                                            <select name="optType" class="form-control border-dark" id="optVal" onchange="optChng()" required>
                                                <option value="3">Custom Answer</option>
                                                <option value="1">Two Option</option>
                                                <option value="2">Three Option</option>
                                            </select>
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