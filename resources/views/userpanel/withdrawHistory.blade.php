@extends('front-ui.include')
@section('uititle')
    Withdrawal History
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-12 card shadow mx-auto sitemodel p-0">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-list"></i> Withdrawal History</h2>
                    <a href="{{ route('makeWithdraw') }}" class="btn btn-dark mt-4 fw-bold">Make Withdrawal</a>
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
                        <table id="datatable" class="table table-bordered dataTable">
                            <thead class="fw-bold">
                                <tr>
                                    <th>ID</th>
                                    <th>Action</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                    <th>Ref.</th>
                                    <th>Status</th>
                                    <th>Date</th>
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
                                <tr class="">
                                    @if($co->status=="Pending")
                                    <th>{{ $co->id }}</th>
                                    <th>
                                        <a title="Refund Amount" href="{{ route('refundWithdraw',['id'=>$co->id]) }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-reply"></i> 
                                        </a>
                                    </th>
                                    @else
                                    <th>N/A</th>
                                    @endif
                                    <th>{{ $co->amount }}</th>
                                    <th>{{ $co->toNumber }}</th>
                                    <th>{{ $co->trans_id }}</th>
                                    <th>{{ $co->status }}</th>
                                    <th>{{ $co->updated_at->format('Y-m-d h:i:s A') }}</th>
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