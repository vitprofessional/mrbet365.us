@extends('front-ui.include')
@section('uititle')
    Homepage Bet
@endsection
@section('uicontent')
@php
    $siteConfig = \App\Models\SiteConfig::first();
@endphp

        @if(Session::get('success'))
            <div class="alert alert-success border-0">
            <span>{!! Session::get('success') !!}</span>
            </div>
        @endif
        @if(Session::get('error'))
            <div class="alert alert-danger border-0">
            <span>{!! Session::get('error') !!}</span>
            </div>
        @endif
   
    <div class="row align-items-center page-heading">
        <div class="col-12 transparentbg">
            <a href="{{ url('/') }}">Home</a> / Advance Bet
        </div>
    </div>

    
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12 col-md-10 mx-auto text-center tabbable">
                <nav class="navtabs mt-0 text-center mb-4">
                    <div class="nav nav-tabs bet-icon" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true"><img src="\assets\images\trophy.png" alt="All Sports"><br>All Sports</a>
                        @php
                            $categoryList = \App\Models\Category::all();
                        @endphp
                        @foreach($categoryList as $catList)
                        <a class="nav-link" id="nav-{{ $catList->id }}-tab'" data-bs-toggle="tab" data-bs-target="#nav-{{ $catList->id }}" type="button" role="tab" aria-controls="nav-{{ $catList->id }}" aria-selected="true"> <img src="{{ $catList->catLogo }}" alt="{{ $catList->name }}"><br>{{ $catList->name }}</a>
                        @endforeach
                    </div> 
                </nav>
                <div class="tab-content text-center" id="nav-tabContent">
                    <div id="nav-all" class="tab-pane fade  show active" role="tabpanel" aria-labelledby="nav-all-tab">
                        @foreach($categoryList as $catData)
                        <div class="col-4 col-md-2 text-center mx-auto text-uppercase category-title">
                            {{ $catData->name }}
                        </div>
                        @php
                            $today = date('Y-m-d');
                            $matchList = \App\Models\Matche::where(['category'=>$catData->id])->where(['status'=>2])->whereDate('matchTime', '>=', $today)->orderBy('matchTime','DESC')->get()
                        @endphp
                        @if(count($matchList)>0)
                            @foreach($matchList as $ml)
                            <div class="bg-category mb-4">
                                @php
                                    $tournament = \App\Models\Tournament::find($ml->tournament);
                                @endphp
                                <section class="text-start">
                                    <!-- Tournament Title -->
                                    <div class="tournament-title text-white">
                                        <h3><div class="mb-2">{{$tournament->cupName}} | {{ \Carbon\Carbon::parse($ml->matchTime)->format('l jS F Y | H:i A') }}</div><div class="mt-1">--{{$ml->matchName}}</div></h3>
                                    </div>
                                    <div class="bet-question row g-0 pb-3">
                                        @include('front-ui.advanceFixedQuestion')
                                    </div>
                                    <div class="bet-question row g-0 pb-3">
                                        @include('front-ui.advanceCustomQuestion')
                                    </div>
                                </section>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-category mb-4">
                                <div class="alert">
                                    No Avaliable bets in {{ $catData->name }}
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                    @foreach($categoryList as $catTabs)
                    <div id="nav-{{ $catTabs->id }}" class="tab-pane fade" role="tabpanel" aria-labelledby="nav-all-tab">
                        <div class="col-4 col-md-2 text-center mx-auto text-uppercase category-title">
                            {{ $catTabs->name }}
                        </div>
                        @php
                            $today = date('Y-m-d');
                            $matchLists = \App\Models\Matche::where(['category'=>$catTabs->id])->where(['status'=>2])->whereDate('matchTime', '>=', $today)->orderBy('matchTime','DESC')->get()
                        @endphp
                        @if(count($matchLists)>0)
                            @foreach($matchLists as $sml)
                            <div class="bg-category mb-4">
                                @php
                                    $stournament = \App\Models\Tournament::find($sml->tournament);
                                @endphp
                                <section class="text-start">
                                    <!-- Tournament Title -->
                                    <div class="tournament-title text-white">
                                        <h3><div class="mb-2">{{$stournament->cupName}} | {{ \Carbon\Carbon::parse($sml->matchTime)->format('l jS F Y | H:i A') }}</div><div class="mt-1">--{{$sml->matchName}}</div></h3>
                                    </div>
                                    <div class="bet-question row g-0 pb-3">
                                        @include('front-ui.singleFixedQuestion')
                                    </div>
                                    <div class="bet-question row g-0 pb-3">
                                        @include('front-ui.singleCustomQuestion')
                                    </div>
                                </section>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-category mb-4">
                                <div class="alert">
                                    No Avaliable bets in {{ $catTabs->name }}
                                </div>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
@php
    $details    = \App\Models\BetUser::find(Session::get('betuser'));
    $clubDetails    = \App\Models\BettingClub::find(Session::get('BettingClub'));
@endphp
    @if(count($details)>0))
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!--<script src="{{ asset('/') }}adm-assets/js/customFunction.js"></script>-->
    <script>
    //Form reset function
    function cqFormReset(a) {
        document.getElementById("cqBetAmount"+a).value  = "";
        document.getElementById("cqReturn"+a).innerHTML = "0.00";
    }
    function fqFormReset(a) {
        document.getElementById("fqBetAmount"+a).value  = "";
        document.getElementById("fqReturn"+a).innerHTML = "0.00";
    }
    function scqFormReset(a) {
        document.getElementById("scqBetAmount"+a).value  = "";
        document.getElementById("scqReturn"+a).innerHTML = "0.00";
    }
    function sfqFormReset(a) {
        document.getElementById("sfqBetAmount"+a).value  = "";
        document.getElementById("sfqReturn"+a).innerHTML = "0.00";
    }
    
    //Est return function
    function cqestReturn(a) {
      var x = document.getElementById("cqansRate"+a).value;
      var y = document.getElementById("cqBetAmount"+a).value;
      document.getElementById("cqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    function scqestReturn(a) {
      var x = document.getElementById("scqansRate"+a).value;
      var y = document.getElementById("scqBetAmount"+a).value;
      document.getElementById("scqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    function fqestReturn(a) {
      var x = document.getElementById("fqansRate"+a).value;
      var y = document.getElementById("fqBetAmount"+a).value;
      document.getElementById("fqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    function sfqestReturn(a) {
      var x = document.getElementById("sfqansRate"+a).value;
      var y = document.getElementById("sfqBetAmount"+a).value;
      document.getElementById("sfqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    </script>
    @endif
@endsection