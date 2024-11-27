@extends('front-ui.include')
@section('uititle')
   Make Deposit
@endsection
@php
    $siteConfig = \App\Models\SiteConfig::first();
@endphp
@section('uicontent')
    <div class="row align-items-center my-4">
        <form class="form" action="{{ route('depositRequest') }}" method="POST">
            {{ csrf_field() }}
            <div class="col-12 col-md-6 card shadow mx-auto sitemodel p-4">
                <div class="card-header fw-bold text-center">
                    <h2><i class="fab fa-google-wallet"></i> Make Deposit</h2>
                    @if($siteConfig->userDepositStatus==1)
                    <p>Deposit {{ $siteConfig->depositMessage }}</p>
                    @endif
                    <a href="{{ route('depositHistory') }}" class="btn btn-dark mt-4 fw-bold">History</a>
                </div> 
                <div class="card-body row">
                @if($siteConfig->userDepositStatus==2)
                    <div class="alert alert-warning">Sorry! User deposit system is now remain close</div>
                @else
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
                    <div class="alert alert-warning fw-bold">Minimum deposit {{ $siteConfig->minDeposit }} & Maximum deposit {{ $siteConfig->maxDeposit }}</div>
                    <div class="col-12 mx-auto">
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-list"></i></div>
                            <select name="method" id="paymentMethod" onchange="myFunction()" class="form-control border border-dark" required>
                                <option value="1">Select Payment Method</option>
                                @php
                                    $bankChanel  = \App\Models\BankChanel::where(['status'=>'Active'])->get();
                                @endphp
                                @if(count($bankChanel)>0)
                                    @foreach($bankChanel as $bc)
                                    <option value="{{ $bc->paymentType }}">{{ $bc->paymentType }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-donate"></i></div>
                            <input type="number" class="form-control border border-dark" min="{{ $siteConfig->minDeposit }}" max="{{ $siteConfig->maxDeposit }}" name="amount" placeholder="Number of coins*" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-phone"></i></div>
                            <input type="number" name="fromNumber" class="form-control border border-dark" placeholder="Phone from" data-maxlength="11" oninput="this.value=this.value.slice(0,this.dataset.maxlength)" required>
                        </div>
                        <div class="depositNumberShowMsg" style="display: block;text-align: left;">
                            <b class="text-danger">Please select payment method for deposit number</b>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><small><i class="fas fa-phone-square"></i><span id="paymentType"></span><span class="text-danger"> * </span></small> </div>
                            <input type="number" name="toNumber" id="phoneTo" class="form-control border border-dark" placeholder="Deposit number" onkeydown="event.preventDefault()" required>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text border border-dark"><i class="fas fa-key"></i></div>
                            <input type="password" class="form-control border border-dark" name="password" placeholder="Enter account password" required>
                        </div>
                        
                        <div class="input-group d-grid gap-2 mb-2">
                            <button type="submit" class="btn btn-dark model-btn" ><i class="fas fa-sign-in-alt"></i> Submit Request</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
<script>

$(window).on('load', function() {
    document.getElementById("paymentType").innerHTML = "";
    var valueSelected = $("#paymentMethod").val();
    if(valueSelected == 0){
        $(".depositNumberHideShow").hide();
        $(".depositNumberShowMsg").show();
    }
});
function myFunction() {
  var x = document.getElementById("paymentMethod").value;
  
  @php
    $bkashPersonal  = \App\Models\BankChanel::where(['paymentType'=>'Bkash Personal','status'=>'Active'])->first();
    $bkashAgent = \App\Models\BankChanel::where(['paymentType'=>'Bkash Agent','status'=>'Active'])->first();
    $nagodPersonal  = \App\Models\BankChanel::where(['paymentType'=>'Nagod Personal','status'=>'Active'])->first();
    $nagodAgent     = \App\Models\BankChanel::where(['paymentType'=>'Nagod Agent','status'=>'Active'])->first();
    $rocketPersonal = \App\Models\BankChanel::where(['paymentType'=>'Rocket Personal','status'=>'Active'])->first();
    $rocketAgent    = \App\Models\BankChanel::where(['paymentType'=>'Rocket Agent','status'=>'Active'])->first();
  @endphp
  var bkPersonal    = "{{ $bkashPersonal->accountNumber; }}"
  var bkAgent       = "{{ $bkashAgent->accountNumber; }}"
  var nagPersonal   = "{{ $nagodPersonal->accountNumber; }}"
  var nagAgent      = "{{ $nagodAgent->accountNumber; }}"
  var rocPersonal   = "{{ $rocketPersonal->accountNumber; }}"
  var rocAgent      = "{{ $rocketAgent->accountNumber; }}"
   if(x == 1){
        $(".depositNumberHideShow").hide();
        $(".depositNumberShowMsg").show();
        document.getElementById("paymentType").innerHTML = "";
        document.getElementById("phoneTo").value = "";
    }else if(x == "Bkash Personal"){
        $(".depositNumberHideShow").show();
        $(".depositNumberShowMsg").hide();
        var phoneTolabel = (x);
        document.getElementById("paymentType").innerHTML =" "+ phoneTolabel;
        document.getElementById("phoneTo").value = bkPersonal;
    }else if(x == "Bkash Agent") {
        $(".depositNumberHideShow").show();
        $(".depositNumberShowMsg").hide();
        var phoneTolabel = (x);
        document.getElementById("paymentType").innerHTML =" "+ phoneTolabel;
        document.getElementById("phoneTo").value = bkAgent;
    }else if(x == "Nagod Personal"){
        $(".depositNumberHideShow").show();
        $(".depositNumberShowMsg").hide();
        var phoneTolabel = (x);
        document.getElementById("paymentType").innerHTML =" "+ phoneTolabel;
        document.getElementById("phoneTo").value = nagPersonal;
    }else if(x == "Nagod Agent") {
        $(".depositNumberHideShow").show();
        $(".depositNumberShowMsg").hide();
        var phoneTolabel = (x);
        document.getElementById("paymentType").innerHTML =" "+ phoneTolabel;
        document.getElementById("phoneTo").value = nagAgent;
    }else if(x == "Rocket Personal"){
        $(".depositNumberHideShow").show();
        $(".depositNumberShowMsg").hide();
        var phoneTolabel = (x);
        document.getElementById("paymentType").innerHTML =" "+ phoneTolabel;
        document.getElementById("phoneTo").value = rocPersonal;
    }else if(x == "Rocket Agent") {
        $(".depositNumberHideShow").show();
        $(".depositNumberShowMsg").hide();
        var phoneTolabel = (x);
        document.getElementById("paymentType").innerHTML =" "+ phoneTolabel;
        document.getElementById("phoneTo").value = rocAgent;
    }
    
    var y = x;
    if(y == 0){
        //$(".tournamentHideShow").hide();
        document.getElementById("TO").innerHTML = "Text Here";
    }else{
        //$(".tournamentHideShow").show();
         document.getElementById("TO").innerHTML = "<select name='tournament' id='tournament' class='form-control border border-dark' required>" @php $tournament = \App\Models\Tournament::where(['catId'=>3])->orderBy('updated_at','DESC')->get(); if(count($tournament)>0): foreach($tournament as $t): @endphp + "<option value='{{ $t->id }}'>{{ $t->cupName }}</option>" @php endforeach; endif; @endphp +"</select>";
    }
    
}
</script>
@endsection