@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Team</h4>
                                    <p class="text-muted mb-0">Create a team to this page
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveTeam') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="catId">Category</label>
                                            <select name="catId" class="form-control" required>
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
                                            <label for="teamName">Team Name</label>
                                            <input type="text" name="teamName" class="form-control" placeholder="Enter team name" required>
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