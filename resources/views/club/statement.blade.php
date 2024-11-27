@extends('front-ui.include')
@section('uititle')
    Statement
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-12 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-list"></i> Club Statement</h2>
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
                                    <th>Blance</th>
                                </tr>
                            </thead>
                        <tbody>
                            @if(count($stDetails)>0)
                                @foreach($stDetails as $st)
                                    @php
                                        $follower = \App\Models\BetUser::where('userid','generateBy')->first();
                                    @endphp
                                <tr>
                                <th>{{ $st->id }}</th>
                                <th>{{ $st->created_at->format('d-m-y h:i A') }}</th>
                                <th>{{ $st->transAmount }}</th>
                                <th>{{ $st->generateBy }}</th>
                                <th>{{ round($st->currentBalance,2) }}</th>
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