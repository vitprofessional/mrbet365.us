@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row font-20">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">New Match</h4>
                                    <p class="text-muted mb-0">Create match for place betting
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveMatch') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="matchName">Name</label>
                                            <input type="text" name="matchName" class="form-control border border-dark" placeholder="Enter a match name" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="category">Category</label>
                                            <select name="category" id="catValue" onchange="categoryChange()" class="form-control border border-dark" required>
                                                <option value="">Select</option>
                                                @php
                                                    $category = \App\Models\Category::orderBy('updated_at','ASC')->get();
                                                    if(count($category)>0):
                                                        foreach($category as $ct):
                                                @endphp
                                                    <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                                @php
                                                        endforeach;
                                                    endif;
                                                @endphp
                                            </select>
                                        </div>
                                        
                                        <div id="tOption"></div>
                                        <div id="team"></div>
                                        
                                        <div class="form-group pb-2">
                                            <label for="matchTime">Match Time</label>
                                            <input type="datetime-local" name="matchTime" class="form-control border border-dark" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Create Match">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
                
<script>

function categoryChange() {
  var x = document.getElementById('catValue').value;
    // var IDSes= x;
    // //'<%Session["IDDiv"] = "' + $(this).attr('id') + '"; %>';
    // '<%Session["IDSes"] = "' + IDSes+ '"; %>';
    //  alert('<%=Session["IDSes"] %>');
    //document.cookie('catVal')=x; 
    //$.post("{{ route('newMatch') }}", {IDSES:x});
    if(x==""){
        //$(".tournamentHideShow").hide();
        document.getElementById("tOption").innerHTML = "<div class='text-danger'>Please select a category to find tournament</div>";
    }else{
        const xhttp = new XMLHttpRequest();
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