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
                                                    <h4 class="card-title">Tournament List</h4>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Category</th>
                                                                <th>Tournament Title</th>
                                                                <th>Create Date </th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($tournament)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($tournament as $tm)
                                                                @php
                                                                    $ctg = \App\Models\Category::find($tm->catId);
                                                                    if(count($ctg)>0):
                                                                        $catname    = $ctg->name;
                                                                    else:
                                                                        $catname    = "-";
                                                                    endif;
                                                                @endphp
                                                            <tr>
                                                                <td>{{ $tm->id }}</td>
                                                                <td>{{ $catname }}</td>
                                                                <td>{{ $tm->cupName }}</td>
                                                                <td>{{ $tm->updated_at }}</td>
                                                                <td>
                                                                    <a href="{{ route('editTournament',['id'=>$tm->id]) }}" class="btn btn-primary btn-sm" onclick="return confirm('are you sure to update this record?')">
                                                                        <i class="fas fa-pen-square"></i>
                                                                    </a>
                                                                    <a href="{{ route('deleteTournament',['id'=>$tm->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! No data found</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('newTournament') }}" class="btn btn-dark">Add New</a>
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