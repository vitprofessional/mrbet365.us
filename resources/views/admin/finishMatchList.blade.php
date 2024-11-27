@extends('admin.include')
@section('admincontent')
                    <div class="row">
                        <div class="col-12 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                @php
                                                
                                                    //Category details
                                                    $cat    = \App\Models\Category::find($catId);
                                                    if(count($cat)>0):
                                                        $catname  = $cat->name;
                                                    else:
                                                        $catname  = "-";
                                                    endif;
                                                @endphp
                                                <div class="card-header">
                                                    <h4 class="card-title">Finish Match-{{ $catname }}</h4>
                                                    <p class="text-muted mb-0"> 
                                                    All the finish matches are listed here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Action </th>
                                                                <th>Match name</th>
                                                                <th>Match Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($match)>0)
                                                            @php
                                                                $x=1;
                                                            @endphp
                                                            @foreach($match as $mtc)
                                                            <tr>
                                                                <td>{{ $mtc->id }}</td>
                                                                <td>
                                                                    @if($mtc->status==5)
                                        <a href="{{ route('matchStatus',['id'=>$mtc->id,'tournament'=>$mtc->tournament,'status'=>1]) }}" class="btn btn-success btn-sm">
                                                    <i class="fas fa-tv"></i>              Go Live Match
                                            </a>
                                            @endif
                                            @if($adminDetails->rule=="Super Admin" && $mtc->status==5)
                                                                    <a href="{{ route('deleteMatch',['id'=>$mtc->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')" title="Delete Match">
                                                                        <i class="fas fa-trash-alt"></i> Delete Match
                                                                    </a>
                                            @endif
                                                                </td>
                                                                <td>{{ $mtc->matchName }}</td>
                                                                <td>
                                                                    {{ $mtc->matchTime }}
                                                                    <div>
                                                                        @if($mtc->status==1) 
                                                                            <span class="text-success fw-bold">Match Live</span>   
                                                                        @elseif($mtc->status==2) 
                                                                            <span class="text-primary fw-bold">Match Unpublish</span> 
                                                                        @elseif($mtc->staus==3)  
                                                                            <span class="text-warning fw-bold">Waiting for Result</span>
                                                                        @else 
                                                                            <span class="text-danger fw-bold">Result Publish</span>   
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="6">Sorry! No records found</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('newMatch') }}" class="btn btn-dark">Add New</a>
                                                    @if(!empty($catId))
                                                    <a href="{{ route('matchList',['catId'=>$catId]) }}" class="btn btn-success"><i class="fas fa-tv"></i> Live Match List</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
@endsection