@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Bet Answer</h4>
                                    <p class="text-muted mb-0">Create a new bet answer for set bet option
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveBetAnswer') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="catId">Category</label>
                                            <select name="catId" id="catValue" onchange="categoryChange()" class="form-control border-dark" required>
                                                <option value="">-</option>
                                                @php
                                                    $category = \App\Models\Category::all();
                                                @endphp
                                                @if(count($category)>0)
                                                    @foreach($category as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach   
                                                @endif
                                            </select>
                                        </div>
                                        
                                        <div id="bOption"></div>
                                        
                                    	<div class="field_wrapper">
                                    		<div class="form-group my-2"><div class="row g-1"><div class="col-7"><label for="option">Bet Option</label><input type="text" class="form-control border-dark" name="optVal[]" placeholder="Enter bet option" required /></div><div class="col-5"><label for="option">Return Value</label><input type="number" class="form-control border-dark" name="returnVal[]" step="any" placeholder="Enter return value" required /></div></div><a href="javascript:void(0);" class="add_button mb-4" title="Add field"> Add Option</a></div>
                                    	</div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                            <a href="{{ route('betAnswer') }}" class="btn btn-dark">Answer List</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">


$(window).on('load', function() {
    var x = $("#optVal").val();
    if(x == 1 || x==2){
        $(".field_wrapper").hide();
        //$(".depositNumberShowMsg").show();
    }
});


function categoryChange() {
  var x = document.getElementById('catValue').value;
    if(x==""){
        //$(".tournamentHideShow").hide();
        document.getElementById("bOption").innerHTML = "<div class='text-danger'>Please select a category to find option list</div>";
    }else{
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById("bOption").innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getOption/"+document.getElementById('catValue').value);
          xhttp.send();
    }
    
    
}

$(document).ready(function(){
    var maxField = 15; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div id="optRemove" class="form-group my-2"><div class="row g-1"><div class="col-7"><label for="option">Bet Option</label><input type="text" class="form-control border-dark" name="optVal[]" placeholder="Enter bet option" required /></div><div class="col-5"><label for="option">Return Value</label><input type="number" class="form-control border-dark" name="returnVal[]" step="any" placeholder="Enter return value" required /></div></div><a href="javascript:void(0);" class="remove_button mb-4" title="Remove field"> Remove</a></div>'; //New input field html 
    var y = 0; //Initial field counter is 1
    $(addButton).click(function(){ 
        if(y < maxField){ //Check maximum number of input fields
            y++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
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