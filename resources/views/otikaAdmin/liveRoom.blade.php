@extends('otikaAdmin.include')
@section('otikaTitle') Live Room @endsection
@section('otikaContent')

        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <h4 class="card-title col-12">Live Room | {{ $category->name }}-{{ $match->matchName }} | {{ \Carbon\Carbon::parse($match->matchTime)->format('j M Y h:i:s A') }}</h4>
                        <p class="text-muted mb-0 col-12"> 
                        All the live question of the matches are listed here
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 p-2">
                                <a target="_blank" href="{{ route('matchBetHistory',['id'=>$match->id]) }}" class="btn btn-light font-weight-bold" title="Bets"><i class="fas fa-gamepad"></i> Bet History</a>
                                <a target="_blank" href="{{ route('profitLoss',['id'=>$match->id]) }}" class="btn btn-primary font-weight-bold" title="Profit/Loss"><i class="fas fa-money-bill-alt"></i> Profit/Loss</a>
                            @if($match->status==1)
                                <a href="{{ route('matchStatus',['id'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}" class="btn btn-danger font-weight-bold"><i class="fas fa-eye-slash"></i> Hide User Page</a>
                            @elseif($match->status==2 || $match->status==3)
                                <a href="{{ route('matchStatus',['id'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}" class="btn btn-success font-weight-bold"><i class="fas fa-tv"></i> Go Dashboard</a>
                            @endif
                                <a target="_blank" href="{{ route('matchManage',['id'=>$match->id]) }}" class="btn btn-primary font-weight-bold" title="Bets"><i class="fas fa-tasks"></i> Match Manage</a>
                                <a target="_blank" href="{{ route('unpublishQuestion',['id'=>$match->id]) }}" class="btn btn-warning font-weight-bold mt-3 mt-md-0" title="Profit/Loss"><i class="fas fa-question-circle"></i> Unpublish Question</a>
                            </div>
                            <div class="col-12 p-2">
                                <a data-toggle="modal" data-target="#matchQuestionModel" class="btn btn-success btn-lg font-weight-bold font-20 mb-4 text-white" id="addQuestion">Add Option</a>
                            </div>
                        </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="liveRoom-tab" data-toggle="tab" href="#liveRoom" role="tab"
                          aria-controls="liveRoom" aria-selected="true">LiveRoom</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="individualBet-tab" data-toggle="tab" href="#individualBet" role="tab"
                          aria-controls="individualBet" aria-selected="false">Individual Bets</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="liveRoom" role="tabpanel" aria-labelledby="liveRoom-tab">
                            @php
                            $fixedanswer = \App\Models\FixedQuestion::where(['matchId'=>$match->id])->where(function($query) {
                            	$query->where(['status'=>1])
                            	->orWhere(['status'=>2]);
                            })->get();
                            @endphp
                            <div class="row mt-2">
                                <div class="col-12">
                                    @php
                                        $liveFQ  = \App\Models\FixedQuestion::where(['matchId'=>$match->id,'status'=>1])->get();
                                        $liveCQ  = \App\Models\MatchQuestion::where(['matchId'=>$match->id,'status'=>1])->get();
                                        $hideFQ  = \App\Models\FixedQuestion::where(['matchId'=>$match->id,'status'=>2])->get();
                                        $hideCQ  = \App\Models\MatchQuestion::where(['matchId'=>$match->id,'status'=>2])->get();
                                    @endphp
                                    @if($match->status==1)
                                        @if(count($liveFQ)>0 || count($liveCQ)>0)
                                        <a class="btn btn-danger" href="{{ route('liveBetOnOff',['id'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}"><i class="fas fa-toggle-off"></i> All Bet Off</a>
                                        @elseif(count($hideFQ)>0 || count($hideCQ)>0)
                                        <a class="btn btn-success" href="{{ route('liveBetOnOff',['id'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}"><i class="fas fa-toggle-on"></i> All Bet On</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div id="accordion" class="mt-4 row">
                            @if(count($fixedanswer)>0)
                                @foreach($fixedanswer as $fa)
                                    @php $getFixedQuestion   = \App\Models\BetOption::find($fa->quesId); 
                                    @endphp
                                  <div class="accordion col-md-6 col-12">
                                    <div class="card card-primary border-0">
                                        <div class="accordion-header btn btn-primary btn-block" role="button" data-toggle="collapse" data-target="#fixedQuestion{{ $fa->id }}">
                                          <h3 class="h4 text-center my-0">{{ $getFixedQuestion->optionName }}</h3>
                                        </div>
                                        <div class="accordion-body collapse card-body" id="fixedQuestion{{ $fa->id }}" data-parent="#accordion">
                                            <div class="@if($fa->status==4) d-none @endif">
                                                <form class="form" method="POST" action="{{ route('fQupdate') }}">
                                                    <div class="row my-2">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="qId" value="{{ $fa->id }}">
                                                        <div class="col-12 mx-auto form-group my-1"> 
                                                            <label class="font-weight-bold font-20">{{ $teamA->team }}</label>
                                                            <input type="text" class="form-control border-dark font-20 font-weight-bold" value="{{ $fa->teamA }}" name="teamA">
                                                        </div>
                                                        <div class="col-12 mx-auto form-group my-1"> 
                                                            <label class="font-weight-bold font-20">{{ $teamB->team }}</label>
                                                            <input type="text" class="form-control border-dark font-20 font-weight-bold" value="{{ $fa->teamB }}" name="teamB">
                                                        </div>
                                                        @if(!empty($fa->draw))
                                                        <div class="col-12 mx-auto form-group my-1">
                                                            <label class="font-weight-bold font-20">Draw/Tie</label>
                                                            <input type="text" class="form-control border-dark font-20 font-weight-bold" value="{{ $fa->draw }}" name="tie">
                                                        </div>
                                                        @endif
                                                        <div class="col-12 mx-auto"> 
                                                            <button type="submit" class="btn btn-primary my-2 btn-block"><i class="fab fa-get-pocket"></i> Update</button>
                                                        </div>
                                                        <div class="col-12 mx-auto">
                                                            @if($fa->status==1)
                                                                <a href="{{ route('fqStatusChange',['id'=>$fa->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}" class="btn btn-danger btn-block" > <i class="fas fa-toggle-off"></i> Turn Off </a>
                                                            @else
                                                                <a href="{{ route('fqStatusChange',['id'=>$fa->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}" class="btn btn-success btn-block" > <i class="fas fa-toggle-on"></i> Turn On </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="@if($fa->status==4) d-block @else d-none @endif">
                                                <div class="alert alert-info">Result already publish for this question</div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                @endforeach
                            @endif
                            <!--Custom question answer will goes here-->
                            @php
                            $customquestion = \App\Models\MatchQuestion::where(['matchId'=>$match->id])->where(function($query) {
                            	$query->where(['status'=>1])
                            	->orWhere(['status'=>2]);
                            })->get();
                            $x = 1;
                            @endphp
                            @if(count($customquestion)>0)
                            @foreach($customquestion as $cq)
                                @php $customQuestion   = \App\Models\BetOption::find($cq->quesId); @endphp
                                  <div class="accordion col-md-6 col-12">
                                    <div class="card card-primary border-0">
                                        <div class="accordion-header btn btn-primary btn-block" role="button" data-toggle="collapse" data-target="#customQuestion{{ $cq->id }}">
                                          <h3 class="h4 text-center my-0">{{ $customQuestion->optionName }}</h3>
                                        </div>
                                        <div class="accordion-body collapse card-body" id="customQuestion{{ $cq->id }}" data-parent="#accordion">
                                            <div class="@if($fa->status==4) d-none @endif">
                                                <form class="form" method="POST" action="{{ route('cQupdate') }}">
                                                    <div class="row my-2">
                                                        <input type="hidden" name="qId" value="{{ $cq->id }}">
                                                        <input type="hidden" name="mId" value="{{ $cq->matchId }}">
                                                        <input type="hidden" name="tournament" value="{{ $cq->tournament }}">
                                                        {{ csrf_field() }}
                                                        @php
                                                            $customanswer = \App\Models\MatchAnswer::where(['quesId'=>$cq->id])->get();
                                                        @endphp
                                                        
                                                        <div class="field_wrap{{ $cq->id }}-{{$cq->quesId}} col-12">
                                                            @foreach($customanswer as $ca)
                                                            <div class="my-1">
                                                                <input type="text" class="form-control border-dark" name="optVal[]" value="{{ $ca->answer }}" placeholder="Enter Option" readonly />
                                                            </div>
                                                            <div class="my-1">
                                                                <input type="number" class="form-control border-dark" name="returnVal[]" value="{{ $ca->returnValue }}" step="any" placeholder="Enter return value" required />
                                                            </div>
                                                            @endforeach
                                                            @php
                                                                $x++;
                                                            @endphp
                                                        </div>
                                                        <div class="col-12 mx-auto"> 
                                                            <button type="submit" class="btn btn-primary my-2 btn-block"><i class="fab fa-get-pocket"></i> Update</button>
                                                        </div>
                                                        <div class="col-12 mx-auto">
                                                            @if($cq->status==1)
                                                                <a href="{{ route('cqStatusChange',['id'=>$cq->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>2]) }}" class="btn btn-danger btn-block" > <i class="fas fa-toggle-off"></i> Turn Off </a>
                                                            @else
                                                                <a href="{{ route('cqStatusChange',['id'=>$cq->id,'matchId'=>$match->id,'tournament'=>$match->tournament,'status'=>1]) }}" class="btn btn-success btn-block" > <i class="fas fa-toggle-on"></i> Turn On </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="@if($cq->status==4) d-block @else d-none @endif">
                                                <div class="alert alert-info">Result already publish for this question</div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                @endforeach
                            @endif
                            </div>
                      </div>
                      <!--Live room are ends here-->
                      <div class="tab-pane fade" id="individualBet" role="tabpanel" aria-labelledby="individualBet-tab">
                        Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis
                        quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus.
                        Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur,
                        eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget
                        scelerisque tellus pharetra a.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>                
<!-- Question Model -->
<!-- Modal -->
<div class="modal fade" id="matchQuestionModel" tabindex="-1" aria-labelledby="matchBetQuestion" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="matchBetQuestion">Add Bet Question</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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