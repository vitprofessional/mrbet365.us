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
                                                    $option = \App\Models\BetOption::find($optionId);
                                                @endphp
                                                <div class="card-header">
                                                    <h4 class="card-title">Individual Bettings-{{ $catname }} | {{ $match->matchName }} | {{ \Carbon\Carbon::parse($match->matchTime)->format('j M Y h:i:s A') }}</h4>
                                                    <p class="text-danger fw-bold mb-0"> 
                                                    Q: {{ $option->optionName }}
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <div class="row">
                                                        <div class='form-group p-2 col-4'>
                                                            <label>Individual Amount</label>
                                                            <input type="text" class="text-success fw-bold form-control" value="{{ $bets }}" readonly>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('matchQuestionList',['id'=>$match->id]) }}" class="btn btn-dark">Live Room/Manage</a>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
@endsection