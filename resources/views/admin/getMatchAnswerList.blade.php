@if(count($answer)>0)
	<div class="field_wrapper" id="field_wrapper">
		<div class="form-group my-2"><a href="javascript:void(0);" class="add_button mb-4 text-success fw-bold" title="Add field"> Add Option</a></div>
	    @foreach($answer as $ans)
		<div id="optRemove" class="form-group my-2"><div class="row g-1"><div class="col-7"><label for="option">Bet Option</label><input type="text" class="form-control border-dark" name="optVal[]" value="{{ $ans->optVal }}" placeholder="Enter bet option" required /></div><div class="col-5"><label for="option">Return Value</label><input type="number" class="form-control border-dark" name="returnVal[]" step="any" value="{{ $ans->returnVal }}" placeholder="Enter return value" required /></div></div><a href="javascript:void(0);" class="remove_button mb-4 text-danger fw-bold" title="Remove field"> Remove</a></div>
		@endforeach
	</div>
@else
    <div class='form-group pb-2'>
		<div class="form-group my-2"><a href="javascript:void(0);" class="add_button mb-4 text-success fw-bold" title="Add field"> Add Option</a></div>
    </div>
@endif