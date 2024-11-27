@extends('front-ui.include')
@section('uititle')
    Coin Transfer History
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-10 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-list"></i> Coin Transfer History</h2>
                    <a href="{{ route('makeC2CTransfer') }}" class="btn btn-dark mt-4 fw-bold">Coin Transfer</a>
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
                        <table id="datatable" class="table table-bordered user-table">
                            <thead class="fw-bold">
                                <tr class="border-bottom border-table fw-bold">
                                    <th>SL</th>
                                    <th>Time</th>
                                    <th>To Account</th>
                                    <th>Amount</th>
                                    <th>Status</th>
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
                                <tr class="border-bottom border-table">
                                    <th>{{ $co->id }}</th>
                                    <th>{{ $co->updated_at->format('d-m-Y h:i:s A') }}</th>
                                    <th>{{ $co->c2cUser }}</th>
                                    <th>{{ $co->amount }}</th>
                                    <th>{{ $co->status }}</th>
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