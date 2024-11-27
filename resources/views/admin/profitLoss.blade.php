@extends('admin.include')
@section('admincontent')
                <style type="text/css">
                    th{
                        font-weight:bold !important;
                    }
                </style>
                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-lg-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Profit/Loss</h4>
                                    @php
                                        //Category details
                                        $cat    = \App\Models\Category::find($catId);
                                        if(count($cat)>0):
                                            $catname  = $cat->name;
                                        else:
                                            $catname  = "-";
                                        endif;
                                    @endphp
                                    <p class="text-muted">{{ $catname }} | {{ $match->matchName }} | {{ \Carbon\Carbon::parse($match->matchTime)->format('j M Y h:i:s A') }}</p>
                                    <a href="{{ route('liveRoom',['id'=>$match->id]) }}" class="btn btn-success"><i class="fas fa-tv"></i> Live Room</a>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Total Bets</th>
                                                    <td>
                                                        {{ count($betUser) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total Bet Amount</th>
                                                    <td>{{ round($betAmount,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Unpublished Item</th>
                                                    <td>
                                                        {{ count($unpublishItem) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Unpublished Amount</th>
                                                    <td>
                                                        {{ round($unpublishAmount,2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Bet Return</th>
                                                    <td>{{ count($betReturn) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Bet Return Amount</th>
                                                    <td>{{ round($betReturnAmount,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Club Get Paid</th>
                                                    <td>
                                                        {{ round($clubGetPaid,2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Sponsor Bonus</th>
                                                    <td>
                                                        {{ round($sponsorBonus,2) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>User Profit</th>
                                                    <td>{{ round($userProfit,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Site Profit</th>
                                                    <td>{{ round($siteProfit,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pertial Amount</th>
                                                    <td>{{ round($pertialAmount,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">
                                                        @php
                                                            $siteProfitTotal = round($siteProfit,2)+round($pertialAmount,2);
                                                            $siteLossTotal = round($userProfit,2)+round($sponsorBonus,2)+round($clubGetPaid,2);
                                                        @endphp
                                                        Total Profit (User Profit + Sponsor Bonus + Club Get Paid)-(Site Profit + Pertial) = {{ round($siteProfitTotal-$siteLossTotal,2) }}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection