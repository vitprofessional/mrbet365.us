@extends('front-ui.include')
@section('uititle')
    Homepage Bet
@endsection
@include('front-ui.loginregistermodal')
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
   
    <div class="row align-items-center">
        <div id="carouselExampleCaptions" class="carousel slide col-12" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @php
                    $slider = \App\Models\Slider::orderBy('id','DESC')->get();
                @endphp
                @if(count($slider)>0)
                @php
                    $a = 0;
                @endphp
                @foreach($slider as $carButton)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $a }}"@if($a==0) class="active" aria-current="true" @endif aria-label="{{ $carButton->heading }}"></button>
                @php
                $a++;
                @endphp
                @endforeach
                @else
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                @endif
            </div>
            <div class="carousel-inner mobile-slider">
                @if(count($slider)>0)
                @php
                    $x = 1;
                @endphp
                @foreach($slider as $slid)
                <div class="carousel-item @if($x==1) active @endif">
                    <img src="{{ $slid->slider }}" class="d-block w-100" style="max-height:450px" alt="{{ $slid->heading }}" />
                    <div class="carousel-caption row align-items-center slider-bg">
                        <div class="col-12 col-md-4 d-none d-md-block mx-auto">
                            @if(!empty($slid->heading))
                            <h5 class="text-uppercase display-5 fw-bold">{{ $slid->heading }}</h5>
                            @endif
                            @if(!empty($slid->details))
                            <p>{{ $slid->details }}</p>
                            @endif
                            @if(!empty($slid->btnTxt))
                            <a href="#betSection" class="btn btn-primary">{{ $slid->btnTxt }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                @php
                    $x++;
                @endphp
                @endforeach
                @else
                <div class="carousel-item active">
                    <img src="{{ asset('/') }}assets/images/slider/slider-1.jpg" class="d-block w-100" style="max-height:450px" alt="..." />
                    <div class="carousel-caption row align-items-center slider-bg">
                        <div class="col-12 col-md-4 d-none d-md-block mx-auto">
                            <h5 class="text-uppercase display-5 fw-bold">mrbet365.us</h5>
                            <p>Welcome to mrbet365.us, We are the best online betting service provider over the world</p>
                            <a href="#betSection" class="btn btn-primary">Bet Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('/') }}assets/images/slider/slider-3.jpg" class="d-block w-100" style="max-height:450px" alt="..." />
                    <div class="carousel-caption row align-items-center slider-bg">
                        <div class="col-12 col-md-4 d-none d-md-block mx-auto">
                            <h5 class="text-uppercase display-5 fw-bold">Highest Odds</h5>
                            <p>We provides the best and highest odd for you to more win</p>
                            <a href="#betSection" class="btn btn-primary">Bet Now</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    
    <div class="container-fluid" id="app">
        <div class="row">
            @if(!empty($siteConfig->siteNotice))
                <div class="col-12 bg-dark text-white p-3 fw-bold"><marquee scrolldelay="200">{{ $siteConfig->siteNotice }}</marquee></div>
            @endif
            <div class="col-12 col-md-9" id="betSection">
                <keep-alive>
                    <leaderboard></leaderboard>
                </keep-alive>
            </div>
            <div class="col-12 col-md-3">
                <!-- <iframe src="https://widget.crictimes.org/" style="width:100%;min-height: 450px;" frameborder="0" scrolling="yes"></iframe> -->
                <div class="card bg-category text-white p-3 h-100">
                    <div class="card-header bg-upcoming text-white fw-bold text-center mb-4">Upcoming</div>
                    @php
                        $today = date('Y-m-d');
                        $upcoming = \App\Models\Matche::where(['status'=>2])->whereDate('matchTime', '>=', $today)->get();
                    @endphp
                    @if(count($upcoming)>0)
                        @foreach($upcoming as $upc)
                        @php
                            $category = \App\Models\Category::find($upc->category);
                            $tournament = \App\Models\Tournament::find($upc->tournament);
                            $teamA = \App\Models\Team::find($upc->teamA);
                            $teamB = \App\Models\Team::find($upc->teamB);
                        @endphp
                        <div class="bg-upcoming p-2 mb-4 text-center fw-bold row">
                            <div class="alert up-tournament-title">
                                {{ $category->name }} : {{ $tournament->cupName }} - {{ $teamA->team }} VS {{ $teamB->team }}
                            </div>
                            <div class="col-12">
                                <div class="alert bg-primary">
                                    {{ date('d M Y h:i A', strtotime($upc->matchTime)) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="alert alert-secondary">
                        No upcoming match available
                    </div>
                    @endif
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
    <script>
        
        
    //Single Bet Data Bet Placed
    function estAmtCount(e){
        var amount = document.getElementById("betAmount"+e).value;
        var rate = document.getElementById("answerRate"+e).value;
        var returnAmount = amount*rate;
        document.getElementById("estReturn"+e).innerHTML = returnAmount;
    }
    function sestAmtCount(e){
        var amount = document.getElementById("sbetAmount"+e).value;
        var rate = document.getElementById("sanswerRate"+e).value;
        var returnAmount = amount*rate;
        document.getElementById("sestReturn"+e).innerHTML = returnAmount;
    }
    //Fixed Question Query
    function fqSubmit(e){
        console.log("#fqForm "+e+" submitted")
        var formValues= $("#fqForm"+e+">form").serialize();
            // $("#fqSuccess"+e).html("<div class='alert alert-success'>Bet are processing. Please wait.....</div>");
            document.getElementById("fqBetProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
            $("#betBtn"+e).prop("disabled", true);

        $.post("{{ route('fqBetPlace') }}", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.fieldIndex)
            $("#fqSuccess"+data.fieldIndex).html(data.message);
            document.getElementById("fqBetProcess"+e).innerHTML = "";
            document.getElementById("estReturn"+e).innerHTML = "0.00";
            $("#betBtn"+e).prop("disabled", false);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    }
    
    function cqSubmit(e){
        console.log("#cqForm "+e+" submitted")
        var formValues= $("#cqForm"+e+">form").serialize();
        document.getElementById("cqBetProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
        $("#betBtn"+e).prop("disabled", true);
    
        $.post("{{ route('cqBetPlace') }}", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.message)
            $("#cqSuccess"+data.fieldIndex).html(data.message);
            document.getElementById("cqBetProcess"+e).innerHTML = "";
            document.getElementById("estReturn"+e).innerHTML = "0.00";
            $("#betBtn"+e).prop("disabled", false);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));
                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });

    }

    function sfqSubmit(e){
        console.log("#sfqForm "+e+" submitted")
        var formValues= $("#sfqForm"+e+">form").serialize();
        document.getElementById("sfqBetProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
        $("#sbetBtn"+e).prop("disabled", true);

        $.post("{{ route('fqBetPlace') }}", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.fieldIndex)
            $("#sfqSuccess"+data.fieldIndex).html(data.message);
            document.getElementById("sfqBetProcess"+e).innerHTML = "";
            document.getElementById("sestReturn"+e).innerHTML = "0.00";
            $("#sbetBtn"+e).prop("disabled", false);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    }
    
    function scqSubmit(e){
        console.log("#scqForm "+e+" submitted")
        var formValues= $("#scqForm"+e+">form").serialize();
        document.getElementById("scqBetProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
        $("#sbetBtn"+e).prop("disabled", true);
    
        $.post("{{ route('cqBetPlace') }}", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.message)
            $("#scqSuccess"+data.fieldIndex).html(data.message);
            document.getElementById("scqBetProcess"+e).innerHTML = "";
            document.getElementById("sestReturn"+e).innerHTML = "0.00";
            $("#sbetBtn"+e).prop("disabled", false);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));
                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });

    }
    
    </script>
    @endif
@endsection