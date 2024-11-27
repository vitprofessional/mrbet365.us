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
                                                    <h4 class="card-title">Match List-{{ $catname }}</h4>
                                                    <p class="text-muted mb-0"> 
                                                    All the matches are listed here
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
                                                                <td class="text-center">
                                                                    <div class="mb-2 text-center">
                                                                        <a href="{{ route('liveRoom',['id'=>$mtc->id]) }}" class="btn btn-success btn-sm" title="Live Room">
                                                                            <i class="fas fa-tv"></i>
                                                                        </a>
                                                                        <a href="{{ route('profitLoss',['id'=>$mtc->id]) }}" class="btn btn-warning btn-sm" title="Profit/Loss" target="_blank"><i class="fas fa-money-bill-alt"></i></a>
                                                                        <a href="{{ route('editMatch',['id'=>$mtc->id]) }}" class="btn btn-primary btn-sm" onclick="return confirm('are you sure to update this record?')" title="Update Match">
                                                                            <i class="fas fa-pen-square"></i>
                                                                        </a>
                                                                    </div>
                                                                    @if($mtc->status==1 || $mtc->status==2 || $mtc->status==3)
                                        <a href="{{ route('matchFinish',['id'=>$mtc->id,'tournament'=>$mtc->tournament]) }}" onclick="return confirm('are you sure to finish this record?')" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-exclamation-triangle"></i>              Finish Match
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
                                                    <a href="{{ route('newMatch') }}" class="btn btn-primary btn-lg">Add New</a>
                                                    @if(!empty($catId))
                                                    <a href="{{ route('finishMatchList',['catId'=>$catId]) }}" class="btn btn-danger"><i class="fas fa-exclamation-triangle"></i> Finish Match List</a>
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