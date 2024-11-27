@extends('front-ui.include')
@section('uititle')
    Deposit History
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-12 card shadow mx-auto sitemodel p-0">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-list"></i> Deposit History</h2>
                    <a href="{{ route('makeDeposit') }}" class="btn btn-dark mt-4 fw-bold">Make Deposit</a>
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
                        <table id="datatable" class="table table-bordered user-table">
                            <thead class="fw-bold">
                                <tr class="border-bottom border-table fw-bold">
                                    <th>SL</th>
                                    <th>Amount</th>
                                    <th>From Number</th>
                                    <th>To Number</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($history)>0)
                                @php 
                                    $x=1; 
                                @endphp
                                @foreach($history as $co)
                                @php 
                                    $timestamp = strtotime($co->updated_at);
                                @endphp
                                <tr class="border-bottom border-table fw-bold text-dark">
                                    <th>{{ $co->id }}</th>
                                    <th>{{ $co->amount }}</th>
                                    <th>{{ $co->fromNumber }}</th>
                                    <th>{{ $co->toNumber }}</th>
                                    <th>{{ $co->status }}</th>
                                    <th>{{ date('d-m-Y h:i:s A',$timestamp) }}</th>
                                </tr>
                                @php
                                    $x++;
                                @endphp
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8"><div class="alert alert-info">Sorry! No data found</div></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
    </div>
@endsection