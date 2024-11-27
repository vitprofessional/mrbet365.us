@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-md-10 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Answer List</h4>
                                                </div><!--end card-header-->
                                                <div class="card-body">
                                        <form class="form" method="Post" action="{{ route('updateBetAnswer') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group pb-2">
                                            <label for="catId">Category</label>
                                            <select name="catId" id="catValue" class="form-control border-dark" required>
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
                                        <div id="optionType" class="optionType">
                                            <div class='form-group pb-2'>
                                                <label for='optType'>Option Type</label>
                                                <select name="optType" class="form-control border-dark" id="optVal" required>
                                                    <option value="">-</option>
                                                    <option value="3">Custom Answer</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div id="bOption"></div>
                                        <div id="oAnswer"></div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                        </div>
                                    </form>
                                        <a href="{{ route('newBetAnswer') }}" class="btn btn-dark">Add New</a>
                                        <a href="{{ route('betOptions') }}" class="btn btn-primary">Option List</a>
                                                </div>
                                            </div>
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
// function optChng() {
//   var x = document.getElementById('optVal').value;
//     if(x==1 || x==2){
//         $(".field_wrapper").hide();
//         //document.getElementById("field_wrapper").innerHTML = "";
//     }else{
//         $(".field_wrapper").show();
//     }
    
    
// }
$('#optVal').on('change', function (e) {
  var y = $('#catValue').val();
  var z = this.value;
    if(z==""){
        $("#oAnswer").html("");
        $("#bOption").html("<div class='text-danger'>Please select question type to get data</div>");
    }else{
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById('bOption').innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getFixedOption/"+document.getElementById('catValue').value+"/"+document.getElementById('optVal').value);
          xhttp.send();
    }
});

// function categoryChange() {
//   var x = document.getElementById('catValue').value;
//     if(x==""){
//         $("#oAnswer").hide();
//         document.getElementById("bOption").innerHTML = "<div class='text-danger'>Please select a category to find option list</div>";
//     }else{
//         const xhttp = new XMLHttpRequest();
//             $("#oAnswer").show();
//           xhttp.onload = function() {
//             document.getElementById("bOption").innerHTML = this.responseText;
//           }
//           xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getOptionAnswer/"+document.getElementById('catValue').value);
//           xhttp.send();
//     }
    
    
// }

function answerChange() {
  var x = document.getElementById('optId').value;
    if(x==""){
        //$(".tournamentHideShow").hide();
        document.getElementById("oAnswer").innerHTML = "<div class='text-danger'>Please select an option to find answer list</div>";w
    }else{
        const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.getElementById("oAnswer").innerHTML = this.responseText;
          }
          xhttp.open("GET", "{{ url('/') }}/control-panel/admin/getAnswerData/"+document.getElementById('optId').value);
          xhttp.send();
    }
    
    
}

$(document).ready(function(){

    var maxField = 15; //Input fields increment limitation
   // var addButton = $('.add_button'); //Add button selector
    var wrapper = $('#oAnswer'); //Input field wrapper
    var wrapper2 = $('#field_wrapper'); //Input field wrapper
    var fieldHTML = '<div id="optRemove" class="form-group my-2"><div class="row g-1"><div class="col-7"><label for="option">Bet Option</label><input type="text" class="form-control border-dark" name="optVal[]" value="" placeholder="Enter bet option" required /></div><div class="col-5"><label for="option">Return Value</label><input type="number" class="form-control border-dark" name="returnVal[]" step="any" value="" placeholder="Enter return value" required /></div></div><a href="javascript:void(0);" class="remove_button mb-4" title="Remove field"> Remove</a></div>'; //New input field html 
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