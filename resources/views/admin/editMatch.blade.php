@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Update Match</h4>
                                    <p class="text-muted mb-0">Update match for correction
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                @if(count($match)>0)
                                    <form class="form" method="Post" action="{{ route('updateMatch') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $match->id }}" name="matchid">
                                        <input type="hidden" id="teamA" value="{{ $match->teamA }}">
                                        <input type="hidden" id="teamB" value="{{ $match->teamB }}">
                                        <div class="form-group pb-2">
                                            <label for="matchName">Name</label>
                                            <input type="text" name="matchName" value="{{ $match->matchName }}" class="form-control border border-dark" placeholder="Enter a match name" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="category">Category</label>
                                            <select name="category" id="catValue" onchange="categoryChange()" class="form-control border border-dark" required>
                                                @php
                                                    $cat    = \App\Models\Category::find($match->category);
                                                    if(count($cat)>0):
                                                        $catid    = $cat->id;
                                                        $catname  = $cat->name;
                                                    else:
                                                        $catid    = "";
                                                        $catname  = "None";
                                                    endif;
                                                @endphp
                                                <option value="{{ $catid }}">{{ $catname }}</option>
                                                @php
                                                    $category = \App\Models\Category::orderBy('updated_at','DESC')->get();
                                                    if(count($category)>0):
                                                        foreach($category as $ct):
                                                @endphp
                                                    <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                                @php
                                                        endforeach;
                                                    endif;
                                                @endphp
                                                <option value="">-</option>
                                            </select>
                                        </div>
                                        <div id="tOption">
                                            <div class="form-group pb-2">
                                                <label for="tournament">Tournament</label>
                                                <select name="tournament" id="tournament" onchange="changeTournament()" class="form-control border border-dark" required>
                                                    @php
                                                        $trn    = \App\Models\Tournament::find($match->tournament);
                                                        if(count($trn)>0):
                                                            $tid    = $trn->id;
                                                            $tn      = $trn->cupName;
                                                        else:
                                                            $tid    = "";
                                                            $tn     = "None";
                                                        endif;
                                                    @endphp
                                                    <option value="{{ $tid }}">{{ $tn }}</option>
                                                    @php
                                                        $tournament = \App\Models\Tournament::where(['catId'=>$match->category])->orderBy('updated_at','DESC')->get();
                                                        if(count($tournament)>0):
                                                            foreach($tournament as $t):
                                                    @endphp
                                                        <option value="{{ $t->id }}">{{ $t->cupName }}</option>
                                                    @php
                                                            endforeach;
                                                        endif;
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                            
                                        <div id="team">
                                            <div class="form-group pb-2">
                                                <label for="ateam">Home Team</label>
                                                <select name="ateam" class="form-control border border-dark" required>
                                                    @php
                                                        $ta    = \App\Models\Team::find($match->teamA);
                                                        if(count($ta)>0):
                                                            $teamaid    = $ta->id;
                                                            $teama      = $ta->team;
                                                        else:
                                                            $teamaid    = "";
                                                            $teama      = "None";
                                                        endif;
                                                    @endphp
                                                    <option value="{{ $teamaid }}">{{ $teama }}</option>
                                                    @php
                                                        $ateam = \App\Models\Team::where(['catId'=>$match->category])->orderBy('updated_at','DESC')->get();
                                                        if(count($ateam)>0):
                                                            foreach($ateam as $at):
                                                    @endphp
                                                        <option value="{{ $at->id }}">{{ $at->team }}</option>
                                                    @php
                                                            endforeach;
                                                        endif;
                                                    @endphp
                                                </select>
                                            </div>
                                            <div class="form-group pb-2">
                                                <label for="bteam">Away Team</label>
                                                <select name="bteam" id="teamB" class="form-control border border-dark" required>
                                                    @php
                                                        $tb    = \App\Models\Team::find($match->teamB);
                                                        if(count($tb)>0):
                                                            $teambid    = $tb->id;
                                                            $teamb      = $tb->team;
                                                        else:
                                                            $teambid    = "";
                                                            $teamb      = "None";
                                                        endif;
                                                    @endphp
                                                    <option value="{{ $teambid }}">{{ $teamb }}</option>
                                                    @php
                                                        $bteam = \App\Models\Team::where(['catId'=>$match->category])->orderBy('updated_at','DESC')->get();
                                                        if(count($bteam)>0):
                                                            foreach($bteam as $bt):
                                                    @endphp
                                                        <option value="{{ $bt->id }}">{{ $bt->team }}</option>
                                                    @php
                                                            endforeach;
                                                        endif;
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                            
                                        <div class="form-group pb-2">
                                            <label for="matchTime">Match Time</label>
                                            <input type="datetime-local" name="matchTime" value="{{ $match->matchTime }}" class="form-control border border-dark" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Update Match">
                                            <a href="{{ route('matchList',['catId'=>$catid]) }}" class="btn btn-dark">Match List</a>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning">Sorry! No data found with your query</div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
<script>

function categoryChange() {
  var x = document.getElementById('catValue').value;
    if(x==""){
        $("#tOption").hide();
        $("#team").hide();
        document.getElementById("tOption").innerHTML = "<div class='text-danger'>Please select a category to find tournament</div>";
    }else{
        const xhttp = new XMLHttpRequest();
        $("#team").hide();
          xhttp.onload = function() {
            document.getElementById("tOption").innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getTournament/"+document.getElementById('catValue').value);
          xhttp.send();
    }
    
}

function changeTournament() {
  var x = document.getElementById('catValue').value;
//   var y = document.getElementById('teamA').value;
//   var z = document.getElementById('teamB').value;
    if(x==""){
        //$(".tournamentHideShow").hide();
        document.getElementById("team").innerHTML = "<div class='text-danger'>Please select a tournament to find team list</div>";
    }else{
        $("#team").show();
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById("team").innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getTeam/"+document.getElementById('catValue').value);
          xhttp.send();
    }
    
}
</script>
@endsection