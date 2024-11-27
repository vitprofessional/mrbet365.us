@extends('front-ui.include')
@section('uititle')
    My Follower
@endsection
@section('uicontent')
    <div class="row align-items-center my-4">
            <div class="col-10 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fas fa-users"></i> My Follower List</h2>
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
                                    <th>Sl</th>
                                    <th>Join Date</th>
                                    <th>Follower</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($Details)>0)
                                @php 
                                    $x=1; 
                                @endphp
                                @foreach($Details as $co)
                                @php 
                                    $timestamp = strtotime($co->created_at);
                                @endphp
                                <tr class="border-bottom border-table">
                                    <th>{{ $co->id }}</th>
                                    <td>{{ date('d-m-y h:i A',$timestamp) }}</td>
                                    <td>{{ $co->userid }}</td>
                                    <td>{{ $co->phone }}</td>
                                    <td>@if($co->status==5) Active @else Block @endif</td>
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