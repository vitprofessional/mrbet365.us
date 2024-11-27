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
                                            <a target="_blank" href="{{ route('matchManage',['id'=>$match->id]) }}" class="btn btn-primary" title="Bets"><i class="fas fa-tasks"></i></i> Match Manage</a>
                                            <a target="_blank" href="{{ route('liveRoom',['id'=>$match->id]) }}" class="btn btn-success mt-3 mt-md-0" title="Live Room"><i class="fas fa-question-circle"></i> Live Room</a>
                                        </div>
                                    </div>
                                    <a data-bs-toggle="modal" data-bs-target="#matchQuestionModel" class="btn btn-primary btn-lg mb-4" id="addQuestion">Add Option</a>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="unpublishQuestionTab" data-bs-toggle="tab" data-bs-target="#unpublishQuestion" type="button" role="tab" aria-controls="unpublishQuestion" aria-selected="false">Unpublish Question</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <!-- All published result will goes here -->
    <div class="tab-pane fade show active" id="unpublishQuestion" role="tabpanel" aria-labelledby="unpublishQuestionTab">
        
        @php							
            $PFQuestion = \App\Models\FixedQuestion::where(['matchId'=>$match->id,'status'=>4])->get();
            //dd($fixedanswer);
        @endphp
        <div class="accordion accordion-publish row" id="publishmatchQuestion">
        @if(count($PFQuestion)>0)
            @foreach($PFQuestion as $pfa)
                @php $getPublishFixedQuestion   = \App\Models\BetOption::find($pfa->quesId); @endphp
                <div class="col-6 my-2">
                    <div class="accordion-item">
                        <h5 class="accordion-header rounded-0 m-0" id="publish-answer{{ $pfa->id }}">
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary collapsed fw-semibold p-3 font-20" type="button" data-bs-toggle="collapse" data-bs-target="#publish-collapse{{ $pfa->id }}" aria-expanded="false" aria-controls="publish-collapse{{ $pfa->id }}">
                                    {{ $getPublishFixedQuestion->optionName }}
                                </button>
                            </div>
                        </h5>
                        <div id="publish-collapse{{ $pfa->id }}" class="accordion-collapse collapse" aria-labelledby="publish-answer{{ $pfa->id }}" data-bs-parent="#publishmatchQuestion">
                            <div class="accordion-body">
                                <div class="row my-2">
                                    {{ csrf_field() }}
                                    <div class="col-6 mx-auto"> 
                                        <label>{{ $teamA->team }}</label>
                                        <input type="text" class="form-control border-dark" readonly value="{{ $pfa->teamA }}" name="teamA">
                                    </div>
                                    <div class="col-6 mx-auto"> 
                                        <label>{{ $teamB->team }}</label>
                                        <input type="text" class="form-control border-dark" readonly value="{{ $pfa->teamB }}" name="teamB">
                                    </div>
                                    @if(!empty($pfa->draw))
                                    <div class="col-6 mx-auto"> 
                                        <label>Draw/Tie</label>
                                        <input type="text" class="form-control border-dark" readonly value="{{ $pfa->draw }}" name="tie">
                                    </div>
                                    @endif
                                    <div class="col-12 mx-auto my-2">     
                                        <a href="{{ route('fqUnpublish',['id'=>$pfa->id,'matchId'=>$match->id,'tournament'=>$match->tournament]) }}" class="btn btn-danger btn-sm"> <i class="fas fa-eye-slash"></i> Unpublish Question</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <!-- Custom question answer -->
        @php
        $pCQuestion = \App\Models\MatchQuestion::where(['matchId'=>$match->id,'status'=>4])->get();
        $x = 1;
        @endphp
        @if(count($pCQuestion)>0)
            @foreach($pCQuestion as $pubcq)
                @php $pubCustomQues   = \App\Models\BetOption::find($pubcq->quesId); @endphp
                <div class="col-6 my-2">
                    <div class="accordion-item">
                        <h5 class="accordion-header rounded-0 m-0" id="publish-headingNo-{{ $pubcq->id }}">
                            <div class="d-grid gap-2">
                                <button class="btn btn-secondary collapsed fw-semibold p-3 font-20" type="button" data-bs-toggle="collapse" data-bs-target="#publish-collapseNo-{{ $pubcq->id }}" aria-expanded="false" aria-controls="publish-collapseNo-{{ $pubcq->id }}">
                                    {{ $pubCustomQues->optionName }}
                                </button>
                            </div>
                        </h5>
                        <div id="publish-collapseNo-{{ $pubcq->id }}" class="accordion-collapse collapse" aria-labelledby="publish-headingNo-{{ $pubcq->id }}" data-bs-parent="#publishmatchQuestion">
                            <div class="accordion-body">
                                <div class="row my-2">
                                    {{ csrf_field() }}
                                    @php
                                        $pubCustomAns = \App\Models\MatchAnswer::where(['quesId'=>$pubcq->id])->get();
                                    @endphp
                                    <div class="field_wrap{{ $pubcq->id }}-{{$pubcq->quesId}}">
                                        @foreach($pubCustomAns as $pubca)
                                            <div id="optionRemove{{ $pubca->id }}-{{$pubca->quesId}}" class="form-group my-2">
                                                <div class="row g-1">
                                                    <div class="col-6">
                                                        <label for="option">Option</label>
                                                        <input type="text" class="form-control border-dark" name="optVal[]" readonly value="{{ $pubca->answer }}" placeholder="Enter Option" required />
                                                </div>
                                                <div class="col-6">
                                                        <label for="option">Rate</label><input type="number" class="form-control border-dark" name="returnVal[]" value="{{ $pubca->returnValue }}" readonly step="any" placeholder="Enter return value" required />
                                                </div>
                                                </div>
                                        </div>
                                        @endforeach
                                        @php
                                            $x++;
                                        @endphp
                                    </div>
                                    <div class="col-12 mx-auto my-2"> 
                                        <!--<button type="submit" class="btn btn-primary btn-sm my-2"><i class="fab fa-get-pocket"></i> Update</button>-->
                                        <a href="{{ route('cqUnpublish',['id'=>$pubcq->id,'matchId'=>$match->id,'tournament'=>$match->tournament]) }}" class="btn btn-danger btn-sm"> <i class="fas fa-eye-slash"></i> Unpublish Question</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        </div>
        @if(empty($pCQuestion) && empty($PFQuestion))
            <div class="alert alert-info">No publish question found to unpublish</div>
        @endif
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