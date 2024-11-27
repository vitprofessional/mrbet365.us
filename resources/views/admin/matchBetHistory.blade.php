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
                                                    <h4 class="card-title">Bettings-{{ $catname }} | {{ $match->matchName }} | {{ \Carbon\Carbon::parse($match->matchTime)->format('j M Y h:i:s A') }}</h4>
                                                    <p class="text-muted mb-0"> 
                                                    Betting list of the match
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered bethistory-table">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Date </th>
                                                                <th>Action </th>
                                                                <th>User</th>
                                                                <th>Club</th>
                                                                <th>Option</th>
                                                                <th>Answer</th>
                                                                <th>Status</th>
                                                                <th>Amount</th>
                                                                <th>Rate</th>
                                                                <th>Return</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @if(count($bets)>0)
                                                            @php
                                                                $x=1;
                                                            foreach($bets as $bts):
                                                            $user = \App\Models\BetUser::find($bts->user);
                                                            $option = \App\Models\BetOption::find($bts->betOption);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $bts->id }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($bts->created_at)->format('j M y, g:i:s A') }}</td>
                                                                <td>
                                                                    @if($bts->status==1) <a href="{{ route('returnBets',['id'=>$bts->id]) }}" class="btn btn-danger btn-sm" title="Bet Return">
                                                                        <i class="fas fa-reply"></i>
                                                                    </a>
                                                                    @elseif($bts->status==2 || $bts->status==3)
                                                                    <p class="bg-primary text-white p-1 rounded text-center">Published</p>
                                                                    @elseif($bts->status=="Pertial")
                                                                    <p class="bg-primary p-1 rounded text-white text-center">Publish</p>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $user->userid }}</td>
                                                                <td>{{ $user->club }}</td>
                                                                <td>{{ $option->optionName }}</td>
                                                                <td>@if($bts->betAnswer=='draw') Tie/Draw @else {{ $bts->betAnswer }} @endif</td>
                                                                <td>@if($bts->status==1) <span class="fw-bold text-primary">Live</span> @elseif($bts->status==2) @if( $bts->betAnswer == $bts->winAnswer) <span class="fw-bold text-success">Winer</span> @else <span class="fw-bold text-danger">Loser</span> @endif @elseif($bts->status=="Pertial")<span class="fw-bold text-warning">Pertial</span> @elseif($bts->status==3)<span class="fw-bold text-warning">Bet Return</span>  @endif</td>
                                                                <td>{{ $bts->betAmount }}</td>
                                                                <td>{{ $bts->betRate }}</td>
                                                                <td>{{ $bts->betAmount*$bts->betRate }}</td>
                                                            </tr>
                                                            @php
                                                                $x++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <tr class="success">
                                                                <td colspan="10">Sorry! No records found</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <a href="{{ route('liveRoom',['id'=>$match->id]) }}" class="btn btn-success"><i class="fas fa-tv"></i> Live Room</a>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
@endsection