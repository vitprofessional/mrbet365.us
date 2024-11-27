@extends('front-ui.include')
@section('uititle')
    Deposit History
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-12 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-list"></i> Account Statement</h2>
                </div> 
                <div class="card-body row">
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
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Note</th>
                                    <th>Trans. Type</th>
                                    <th>Blance</th>
                                </tr>
                            </thead>
                        <tbody>
                            @if(count($stmt)>0)
                                @foreach($stmt as $st)
                                <tr>
                                <th>{{ $st->id }}</th>
                                <th>{{ $st->created_at->format('Y-m-d h:i:s A') }}</th>
                                <th>{{ number_format($st->transAmount,2) }}</th>
                                <th>@if($st->note=='C2C') 
                                        @php 
                                            if($st->transType=='Credit'):
                                                $coinUser = \App\Models\CoinTransfer::where(['c2cUser'=>$details->userid])->first(); 
                                                if(!empty($coinUser)): 
                                                    $transferUser = \App\Models\BetUser::find($coinUser->user);
                                                    $listUser = $transferUser->userid."(Coin Receive)";
                                                else:
                                                    $listUser = "-";
                                                endif;
                                            elseif($st->transType=='Debit'):
                                                $coinUser = \App\Models\CoinTransfer::where(['user'=>$st->user,'amount'=>$st->transAmount])->first(); 
                                                if(!empty($coinUser)): 
                                                    $listUser = $coinUser->c2cUser."(Coin Transfer)";
                                                else:
                                                    $listUser = "-";
                                                endif;
                                            endif;
                                        @endphp 
                                        {!! $listUser !!} 
                                    @else 
                                        {{ $st->note }}
                                    @endif</th>
                                <th>{{ $st->transType }}</th>
                                <th>{{ number_format($st->currentBalance,2) }}</th>
                                @endforeach
                            @else
                                <tr><th colspan="13"><div class="alert alert-info">Sorry! No data found</div></th></tr>
                            @endif
                        </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
    </div>
@endsection