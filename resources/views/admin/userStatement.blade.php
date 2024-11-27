@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Statement</h4>
                                                    <p class="text-muted mb-0">Customer account statement history will goes here
                                                    </p>
                                                </div><!--end card-header-->
                                                <div class="card-body table-responsive">
                                                    <table id="datatable" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Date</th>
                                                                <th>Prev. Balance</th>
                                                                <th>Trans. Amount</th>
                                                                <th>Note</th>
                                                                <th>Trans. Type</th>
                                                                <th>Current Blance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($statement)>0)
                                                                @foreach($statement as $st)
                                                                <tr>
                                                                <td>{{ $st->id }}</td>
                                                                <td>{{ $st->created_at->format('d-m-y h:i A') }}</td>
                                                                <td>{{ round($st->prevBalance,2) }}</td>
                                                                <td>{{ $st->transAmount }}</td>
                                                                <td>
                                                                    @if($st->note=='C2C') 
                                                                        @php 
                                                                            if($st->transType=='Credit'):
                                                                                $coinUser = \App\Models\CoinTransfer::where(['c2cUser'=>$details->userid])->first(); 
                                                                                if(!empty($coinUser)): 
                                                                                    $transferUser = \App\Models\BetUser::find($coinUser->user);
                                                                                    $listUser = $transferUser->userid."<br /> (Coin Receive)";
                                                                                else:
                                                                                    $listUser = "-";
                                                                                endif;
                                                                            elseif($st->transType=='Debit'):
                                                                                $coinUser = \App\Models\CoinTransfer::where(['user'=>$st->user,'amount'=>$st->transAmount])->first(); 
                                                                                if(!empty($coinUser)): 
                                                                                    $listUser = $coinUser->c2cUser."<br /> (Coin Transfer)";
                                                                                else:
                                                                                    $listUser = "-";
                                                                                endif;
                                                                            endif;
                                                                        @endphp 
                                                                        {!! html_entity_decode($listUser) !!} 
                                                                    @else 
                                                                        {{ $st->note }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $st->transType }}</td>
                                                                <td>{{ round($st->currentBalance,2) }}</td>
                                                                @endforeach
                                                            @else
                                                                <tr><td colspan="13"><div class="alert alert-info">Sorry! No data found</div></td></tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection