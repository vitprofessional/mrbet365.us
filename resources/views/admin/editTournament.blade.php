@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Tournament</h4>
                                    <p class="text-muted mb-0">Update a tournament to this page
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    @if(count($tournament)>0)
                                    <form class="form" method="Post" action="{{ route('updateTournament') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="tId" value="{{ $tournament->id }}">
                                        <div class="form-group pb-2">
                                            <label for="catId">Category </label>
                                            <select name="catId" class="form-control" required>
                                                @php
                                                    $ctg =  \App\Models\Category::find($tournament->catId);
                                                @endphp
                                                @if(count($ctg)>0)
                                                <option value="{{ $ctg->id }}">{{ $ctg->name }}</option>
                                                @else
                                                <option value="">-</option>
                                                @endif
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
                                            <label for="tName">Tournament Name</label>
                                            <input type="text" name="cupName" class="form-control" placeholder="Enter tournament name" value="{{ $tournament->cupName }}" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Update">
                                        </div>
                                    </form>
                                    @else
                                        <div class="alert alert-warning">Sorry! No data found with your query</div>
                                    @endif
                                    <a href="{{ route('tournamentList') }}" class="btn btn-dark">Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection