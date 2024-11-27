@extends('front-ui.include')
@section('uititle')
    Deposit History
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-12 card shadow mx-auto sitemodel p-0">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-list"></i> Betting History</h2>
                </div> 
                <div class="card-body row p-0">
                    <div class="col-12 mx-auto table-responsive">
                        @if(Session::get('success'))
                          <div class="alert alert-success text-center rounded-0">
                              {!! Session::get('success') !!}
                          </div>
                        @endif
                        @if(Session::get('error'))
                          <div class="alert alert-warning text-center rounded-0">
                              {!! Session::get('error') !!}
                          </div>
                        @endif
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Match</th>
                                    <th>Option</th>
                                    <th>Amount</th>
                                    <th>Rate</th>
                                    <th>Return</th>
                                    <th>Status </th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                        <tbody>
                            @if(count($betData)>0)
                                @foreach($betData as $BD)
                                @php
                                    $betOption = \App\Models\BetOption::find($BD->betOption);
                                    $match = \App\Models\Matche::find($BD->matchId);
                                    $tournament = \App\Models\Tournament::find($BD->tournament);
                                @endphp 
                                <tr>
                                    <th>{{ $BD->id }}</th>
                                    <th>{{ $match->matchName }}</th>
                                    <th>Q. {{$betOption->optionName}}<br>Ans: {{ ucfirst($BD->betAnswer) }}</th>
                                    <th>{{ round($BD->betAmount,2) }}</th>
                                    <th>{{ $BD->betRate }}</th>
                                    <th>{{ round($BD->betRate*$BD->betAmount,2) }}</th>
                                    <th>@if($BD->status==1) 
                                            On Going 
                                        @elseif($BD->status==2) 
                                            @if($BD->betAnswer==$BD->winAnswer)
                                                Winner 
                                            @else 
                                                Loser 
                                            @endif 
                                        @else 
                                            Bet Return 
                                        @endif
                                    </th>
                                    <th>{{ $BD->created_at->format('Y-m-d h:i:s A') }}</th>
                                </tr>
                                @endforeach
                            @else
                                <tr><td colspan="13"><div class="alert alert-info">Sorry! No data found</div></td></tr>
                            @endif
                        </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
    </div>
@endsection
