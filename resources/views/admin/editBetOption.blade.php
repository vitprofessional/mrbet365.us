@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Bet Option</h4>
                                    <p class="text-muted mb-0">Update an existing bet option
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($option)>0)
                                    <form class="form" method="Post" action="{{ route('updateBetOption') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="optionId" value="{{ $option->id }}">
                                        <div class="form-group pb-2">
                                            <label for="catId">Category</label>
                                            <select name="catId" class="form-control border-dark" required>
                                                @php
                                                    $singcat = \App\Models\Category::find($option->catId);
                                                @endphp
                                                @if(count($singcat)>0)
                                                        <option value="{{ $singcat->id }}">{{ $singcat->name }}</option>
                                                @endif
                                                @php
                                                    //All category
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
                                            <input type="text" name="optName" class="form-control border-dark" value="{{ $option->optionName }}" placeholder="Enter bet question" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </form>
                                    <a href="{{ route('betOptions') }}" class="btn btn-primary">Option List</a>
                                    @else
                                        <div class="alert alert-danger">Sory! no data found with your query</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection