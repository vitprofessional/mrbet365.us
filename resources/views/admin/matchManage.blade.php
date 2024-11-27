@extends('admin.include')
@section('admincontent')

<div class="container-fluid">
    @include('admin.pagetitle')
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12 mx-auto">
            <div class="card card-default shadow">
                <div class="card-body">
                @if($match->status==1 || $match->status==2 || $match->status==3 || $match->status==5)
                    @php
                        $category = \App\Models\Category::find($match->category);
                        $siteConfig = \App\Models\SiteConfig::first();
                    @endphp 
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Match Management | {{ $category->name }}-{{ $match->matchName }} | {{ \Carbon\Carbon::parse($match->matchTime)->format('j M Y h:i:s A') }}</h4>
                                    <p class="text-muted mb-0"> 
                                    All the question of the matches are listed here
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 p-2">
                                            <a target="_blank" href="{{ route('matchBetHistory',['id'=>$match->id]) }}" class="btn btn-light" title="Bets"><i class="fas fa-gamepad"></i> Bet History</a>
                                            <a target="_blank" href="{{ route('profitLoss',['id'=>$match->id]) }}" class="btn btn-info" title="Profit/Loss"><i class="fas fa-money-bill-alt"></i> Profit/Loss</a>
                                            <a target="_blank" href="{{ route('liveRoom',['id'=>$match->id]) }}" class="btn btn-success" title="live room"><i class="fas fa-tasks"></i></i> Live Room</a>
                                            <a target="_blank" href="{{ route('unpublishQuestion',['id'=>$match->id]) }}" class="btn btn-warning mt-3 mt-md-0" title="Unpublish Question"><i class="fas fa-question-circle"></i> Unpublish Question</a>
                                        </div>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#matchQuestionModel" class="btn btn-primary btn-lg mb-4" id="addQuestion">Add Option</a>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="liveRoomTabs" data-bs-toggle="tab" data-bs-target="#liveRoom" type="button" role="tab" aria-controls="liveRoom" aria-selected="true">Match Manage</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <!-- Live room activities will goes here -->
    <div class="tab-pane fade show active" id="liveRoom" role="tabpanel" aria-labelledby="liveRoomTab">
        @php							
            $FQuestion = \App\Models\FixedQuestion::where(['matchId'=>$match->id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])->orWhere(['status'=>3]);
        })->get();
            $lfaquesId = 0;
            //dd($fixedanswer);
        @endphp
        <div class="accordion accordion-live row" id="livematchQuestion">
        @if(count($FQuestion)>0)
            @foreach($FQuestion as $lfa)
                @php 
                    $lfaquesId = $lfa->quesId;
                    if(empty($lfaquesId)):
                        $lfaquesId = 0;
                    endif;
                    $getLiveFixedQuestion   = \App\Models\BetOption::find($lfaquesId); 
                @endphp
                <div class="col-6 my-2">
                    <div class="accordion-item">
                        <h5 class="accordion-header rounded-0 m-0" id="live-answer{{ $lfaquesId }}">
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary collapsed fw-semibold p-3 font-20" type="button" data-bs-toggle="collapse" data-bs-target="#live-collapse{{ $lfaquesId }}" aria-expanded="false" aria-controls="live-collapse{{ $lfaquesId }}">
                                    {{ $getLiveFixedQuestion->optionName }}
                                </button>
                            </div>
                        </h5>
                        <div id="live-collapse{{ $lfaquesId }}" class="accordion-collapse collapse" aria-labelledby="live-answer{{ $lfaquesId }}" data-bs-parent="#livematchQuestion">
                            <div class="accordion-body">
                                <form class="form" method="POST" action="{{ route('fQupdate') }}">
                                    <div class="row my-2 align-items-center">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="qId" value="{{ $lfa->id }}">
                                        <div class="col-12 mx-auto row"> 
                                            <div class="col-12">
                                                <label>{{ $teamA->team }}</label>
                                                <input type="text" class="form-control border-dark" value="{{ $lfa->teamA }}" name="teamA">
                                            </div>
                                            <div class="col-8">
                                                @if($lfa->status==1 || $lfa->status==2 || $lfa->status==3)
                                                <span class="input-group-text mt-4">
                                                    <a href="{{ route('publishSingleResult',['team'=>$teamA->team,'id'=>$lfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament]) }}" class="btn btn-success btn-sm" onclick="return confirm('are you sure to publish result?')" title="Publish Result"><i class="fab fa-pinterest"></i> Publish</a>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 mx-auto row"> 
                                            <div class="col-12">
                                                <label>{{ $teamB->team }}</label>
                                                <input type="text" class="form-control border-dark" value="{{ $lfa->teamB }}" name="teamB">
                                            </div>
                                            <div class="col-8">
                                                @if($lfa->status==1 || $lfa->status==2 || $lfa->status==3)
                                                <span class="input-group-text mt-3">
                                                    <a href="{{ route('publishSingleResult',['team'=>$teamB->team,'id'=>$lfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament]) }}" class="btn btn-success btn-sm" onclick="return confirm('are you sure to publish result?')" title="Publish Result"><i class="fab fa-pinterest"></i> Publish</a>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!empty($lfa->draw))
                                        <div class="col-12 mx-auto row"> 
                                            <div class="col-12">
                                                <label>Draw/Tie</label>
                                                <input type="text" class="form-control border-dark" value="{{ $lfa->draw }}" name="tie">
                                            </div>
                                            <div class="col-8">
                                                @if($lfa->status==1 || $lfa->status==2 || $lfa->status==3)
                                                <span class="input-group-text mt-3">
                                                    <a href="{{ route('publishSingleResult',['team'=>'draw','id'=>$lfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament]) }}" class="btn btn-success btn-sm" onclick="return confirm('are you sure to publish result?')" title="Publish Result"><i class="fab fa-pinterest"></i> Publish</a>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-12 mx-auto"> 
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary my-2"><i class="fab fa-get-pocket"></i> Update</button>
                                            </div>
            
                                            @if($lfa->status==1 || $lfa->status==2)
                                                <a href="{{ route('fqHideShow',['id'=>$lfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye-slash"></i> Hide User/Live Room </a>
                                            @else
                                                <a href="{{ route('fqHideShow',['id'=>$lfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}" class="btn btn-success btn-sm"> <i class="fas fa-tv"></i> Show User/Live Room</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                <a href="{{ route('pertialPublish',['id'=>$lfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'quesId'=>$lfaquesId,'betOn'=>'FQ','pertialAmount'=>$siteConfig->partialOne]) }}" class="btn btn-dark btn-sm" onclick="return confirm('are you sure to publish result?')"><i class="fas fa-gamepad"></i> Pertial Publish ({{ $siteConfig->partialOne }})</a>

                                <a href="{{ route('betReturn',['matchId'=>$match->id,'qId'=>$lfaquesId]) }}" class="btn btn-warning btn-sm" ><i class="fas fa-reply"></i> Bet Return</a>
                                @if($lfa->status==3)
                                <a href="{{ route('deleteSingleQuestion',['id'=>$lfa->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')" title="Delete Match"><i class="fas fa-trash-alt"></i> Delete Question</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <!-- Custom question answer -->
        @php
        $livecustomquestion = \App\Models\MatchQuestion::where(['matchId'=>$match->id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])->orWhere(['status'=>3]);
        })->get();
        $x = 1;
        @endphp
        @if(count($livecustomquestion)>0)
            @foreach($livecustomquestion as $lcq)
                @php 
                    $lcqquesId = $lcq->quesId;
                    if(empty($lcqquesId)):
                        $lcqquesId = 0;
                    endif;
                    $livecustomQuestion   = \App\Models\BetOption::find($lcqquesId); 
                @endphp
                <div class="col-6 my-2">
                    <div class="accordion-item">
                        <h5 class="accordion-header rounded-0 m-0" id="live-headingNo-{{ $lcq->id }}">
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary collapsed fw-semibold p-3 font-20" type="button" data-bs-toggle="collapse" data-bs-target="#live-collapseNo-{{ $lcq->id }}" aria-expanded="false" aria-controls="live-collapseNo-{{ $lcq->id }}">
                                    {{ $livecustomQuestion->optionName }}
                                </button>
                            </div>
                        </h5>
                        <div id="live-collapseNo-{{ $lcq->id }}" class="accordion-collapse collapse" aria-labelledby="live-headingNo-{{ $lcq->id }}" data-bs-parent="#livematchQuestion">
                            <div class="accordion-body">
                                <form class="form" method="POST" action="{{ route('cQupdate') }}">
                                    <div class="row my-2">
                                        {{ csrf_field() }}
                                        @php
                                            $livecustomanswer = \App\Models\MatchAnswer::where(['quesId'=>$lcq->id])->get();
                                        @endphp
                                        <input type="hidden" name="qId" value="{{ $lcq->id }}">
                                        <input type="hidden" name="mId" value="{{ $lcq->matchId }}">
                                        <input type="hidden" name="tournament" value="{{ $lcq->tournament }}">
                                        <div class="field_wrap{{ $lcq->id }}-{{$lcqquesId}}">
                                            <div class="form-group my-2"><a href="javascript:void(0);" onclick="addField({{ $lcq->id }},{{$lcqquesId}})" class="add_field mb-4" title="Add field"> Add Option</a></div>
                                            @foreach($livecustomanswer as $lca)
                                                <div id="optionRemove{{ $lca->id }}-{{$lca->quesId}}" class="form-group my-2">
                                                    <div class="row g-1">
                                                        <div class="col-12">
                                                            <input type="text" class="form-control border-dark" name="optVal[]" value="{{ $lca->answer }}" placeholder="Enter Option" required />
                                                    </div>
                                                    <div class="col-12"><input type="number" class="form-control border-dark" name="returnVal[]" value="{{ $lca->returnValue }}" step="any" placeholder="Enter return value" required />
                                                    </div>
                                                    <div class="col-12 text-md-start text-end">
                                                        @if($lcq->status == 1 || $lcq->status == 2 || $lcq->status==3)
                                                        <a href="{{ route('publishCQResult',['answer'=>$lca->answer,'id'=>$lcq->id,'matchId'=>$match->id,'tournament'=>$match->tournament]) }}" class="btn btn-success btn-sm" title="Publish Result" onclick="return confirm('are you sure to publish result?')"><i class="fab fa-pinterest"></i> Publish</a>
                                                        @endif
                                                        </div>
                                                    </div>
                                            </div>
                                            @endforeach
                                            @php
                                                $x++;
                                            @endphp
                                        </div>
                                        <div class="col-12 mx-auto"> 
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-primary my-2"><i class="fab fa-get-pocket"></i> Update</button>
                                            </div>
            
                                            @if($lcq->status==1 || $lcq->status==2)
                                                <a href="{{ route('cqHideShow',['id'=>$lcq->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}" class="btn btn-warning btn-sm"><i class="fas fa-eye-slash"></i> Hide User/Live Room </a>
                                            @else
                                                <a href="{{ route('cqHideShow',['id'=>$lcq->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}" class="btn btn-success btn-sm"> <i class="fas fa-tv"></i> Show User/Live Room</a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                <a href="{{ route('pertialPublish',['id'=>$lcq->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'quesId'=>$lcqquesId,'betOn'=>'CQ','pertialAmount'=>$siteConfig->partialOne]) }}" class="btn btn-dark btn-sm" onclick="return confirm('are you sure to publish result?')"><i class="fas fa-gamepad"></i> Pertial Publish ({{ $siteConfig->partialOne }})</a>
                                
                                <a href="{{ route('betReturn',['matchId'=>$match->id,'qId'=>$lcqquesId]) }}" class="btn btn-warning btn-sm" ><i class="fas fa-reply"></i> Bet Return</a>
                                @if($lcq->status==3)
                                <a href="{{ route('deleteCustomQuestion',['id'=>$lcq->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('are you sure to delete this record?')" title="Delete"><i class="fas fa-trash-alt"></i> Delete Question</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-6 col-md-4">
                    @php
                        $getFQ  = \App\Models\FixedQuestion::where(['matchId'=>$match->id])->where(function($query) {
                            $query->where(['status'=>1])
                            ->orWhere(['status'=>2]);
                        })->get();
                        $getCQ  = \App\Models\MatchQuestion::where(['matchId'=>$match->id])->where(function($query) {
                            $query->where(['status'=>1])
                            ->orWhere(['status'=>2]);
                        })->get();
                    @endphp
                    @if($match->status==1)
                        @if(count($getFQ)>0 || count($getCQ)>0)
                        <a class="btn btn-danger mt-4 mt-md-0" href="{{ route('allBetHideShow',['id'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}" onclick="return confirm('are you sure to change the status?')"><i class="fas fa-eye-slash"></i> All Bet Hide</a>
                        @else
                        <a class="btn btn-success mt-4 mt-lg-0" href="{{ route('allBetHideShow',['id'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}" onclick="return confirm('are you sure to change the status?')"><i class="fas fa-tv"></i> All Bet Show</a>
                        @endif
                    @endif
                </div>
            </div>
        @endif
        </div>
    </div>
</div>


                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                    @else
                                        <div class="alert alert-warning">Sorry! Match not found or match already finish</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
                
<!-- Question Model -->
<!-- Modal -->
<div class="modal fade" id="matchQuestionModel" tabindex="-1" aria-labelledby="matchBetQuestion" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="matchBetQuestion">Add Bet Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-default shadow">
                    <div class="card-body">
                        <form class="form" method="Post" action="{{ route('saveMatchQuestion') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="catId" value="{{ $match->category }}">
                            <input type="hidden" name="matchId" id="matchId" value="{{ $match->id }}">
                            <input type="hidden" name="tournament" value="{{ $match->tournament }}">
                            <div class="form-group pb-2">
                                <label for="catId">Category</label>
                                <select name="catId" id="catValue" class="form-control border-dark" required>
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    <option value="">-</option>
                                </select>
                            </div>
                            <div id="optionType" class="optionType">
                                <div class='form-group pb-2'>
                                    <label for='optType'>Option Type</label>
                                    <select name="optType" class="form-control border-dark" id="optVal" required>
                                        <option value="">-</option>
                                        <option value="1">Two Option</option>
                                        <option value="2">Three Option</option>
                                        <option value="3">Custom Answer</option>
                                    </select>
                                </div>
                            </div>
                            <div id="bOption"></div>
                            <div id="oAnswer"></div>
                            <div id="twoOption"></div>
                            <div id="threeOption"></div>
                            
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Add Question">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
  </div>
</div>
<!-- end page title end breadcrumb -->
<script type="text/javascript">

$(window).on('load', function() {
    x   = $("#catValue").val();
    if(x==""){
        $("#optionType").hide();
        $("#twoOption").html('');
        $("#threeOption").html('');
    }else{
        $("#twoOption").html('');
        $("#threeOption").html('');
        $("#optionType").show();
    }
});
$('#addQuestion').on('click', function (e) {
        $("#twoOption").html('');
        $("#threeOption").html('');
        $("#oAnswer").html("");
        $("#bOption").html("");
});
$('#catValue').on('change', function (e) {
  var y = this.value;
    if(y==""){
        $("#optionType").hide();
        $("#twoOption").html('');
        $("#threeOption").html('');
        $("#oAnswer").html("");
        $("#bOption").html("");
    }else{
        $("#optionType").show();
    }
});

$('#optVal').on('change', function (e) {
  var y = $('#catValue').val();
  var z = this.value;
    if(z==""){
        $("#twoOption").html('');
        $("#threeOption").html('');
        $("#oAnswer").html("");
        $("#bOption").html("<div class='text-danger'>Please select question type to get data</div>");
    }else if(z==1){
        $("#twoOption").html('<div class="row my-2"><div class="col-6 mx-auto"> <label>{{ $teamA->team }}</label><input type="text" class="form-control border-dark" value="1.90" name="teamA"></div><div class="col-6 mx-auto"> <label>{{ $teamB->team }}</label><input type="text" class="form-control border-dark" value="1.90" name="teamB"></div></div>');
        $("#threeOption").html('');
        $("#oAnswer").html("");
        
        
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById('bOption').innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getFixedOption/"+document.getElementById('catValue').value+"/"+document.getElementById('optVal').value);
          xhttp.send();
    }else if(z==2){
        $("#oAnswer").html("");
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById('bOption').innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getFixedOption/"+document.getElementById('catValue').value+"/"+document.getElementById('optVal').value);
          xhttp.send();
        $("#threeOption").html('<div class="row my-2"><div class="col-6 mx-auto"> <label>{{ $teamA->team }}</label><input type="text" class="form-control border-dark" value="1.90" name="teamA"></div><div class="col-6 mx-auto"> <label>{{ $teamB->team }}</label><input type="text" class="form-control border-dark" value="1.90" name="teamB"></div><div class="col-6 mx-auto"> <label>Tie/Draw</label><input type="text" class="form-control border-dark" value="1.90" name="tie"></div></div>');
        $("#twoOption").html('');
    }else if(z==3){
        $("#twoOption").html("");
        $("#threeOption").html("");
        
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById('bOption').innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getFixedOption/"+document.getElementById('catValue').value+"/"+document.getElementById('optVal').value);
          xhttp.send();
    }
});

function answerChange() {
  var x = document.getElementById('optId').value;
    if(x==""){
        //$(".tournamentHideShow").hide();
        document.getElementById("oAnswer").innerHTML = "<div class='text-danger'>Please select an option to find answer list</div>";w
    }else{
        //$("bAnswer").show();
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById("oAnswer").innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getAnswerData/"+document.getElementById('optId').value);
          xhttp.send();
    }
    
    
}
function removeField(Aid,Qid){
    $('#optionRemove'+Aid+'-'+Qid).remove();
}

function addField(Aid,Qid){
    var fieldHTML = '<div id="optionRemove'+Aid+'-'+Qid+'" class="form-group my-2"><div class="row g-1"><div class="col-7"><label for="option">Option</label><input type="text" class="form-control border-dark" name="optVal[]" value="" placeholder="Enter Option" required /></div><div class="col-5"><label for="option">Return Value</label><input type="number" class="form-control border-dark" name="returnVal[]" step="any" value="" placeholder="Enter return value" required /></div></div><a href="javascript:void(0);" onclick="removeField('+Aid+','+Qid+')" class="remove_button mb-4 text-danger fw-bold" title="Remove field"> Remove</a></div>'; //New input field html 
    $('.field_wrap'+Aid+'-'+Qid).append(fieldHTML); // Add field html
    
}
$(document).ready(function(){

    var maxField = 15; //Input fields increment limitation
    var wrapper = $('#oAnswer'); //Input field wrapper
    //var wrapper2 = $('#field_wrapper'); //Input field wrapper
    var fieldHTML = '<div id="optRemove" class="form-group my-2"><div class="row g-1"><div class="col-7"><label for="option">Option</label><input type="text" class="form-control border-dark" name="optVal[]" value="" placeholder="Enter Option" required /></div><div class="col-5"><label for="option">Return Value</label><input type="number" class="form-control border-dark" name="returnVal[]" step="any" value="" placeholder="Enter return value" required /></div></div><a href="javascript:void(0);" class="remove_button mb-4 text-danger fw-bold" title="Remove field"> Remove</a></div>'; //New input field html 
    var y = 0; //Initial field counter is 1
    $(wrapper).on('click', '.add_button',function(){
        if(y < maxField){ //Check maximum number of input fields
            y++; //Increment field counter
            $('#oAnswer > #field_wrapper').append(fieldHTML); // Add field html
            console.log("add button click")
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        document.getElementById('optRemove').remove(); //Remove field html
        y--; //Decrement field counter
    });
});
</script>
@endsection