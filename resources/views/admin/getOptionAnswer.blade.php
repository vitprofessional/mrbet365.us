
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}otikaAdmin/assets/bundles/jquery-selectric/selectric.css">
@if(count($option)>0)
    @if($qId>2)
    <div class='form-group pb-2'>
        <label for='optId'>Option List</label>
        <select name='optId' id='optId' onchange="answerChange()" class='form-control border border-dark select2' required> 
            <option value="">-</option>
            @foreach($option as $opt):
            <option value='{{ $opt->id }}'>{{ $opt->optionName }}</option>
            @endforeach;
        </select>
    </div>
    @else
    <div class='form-group pb-2'>
        <label for='optId'>Option List</label>
        <select name='optId' id='optId' class='form-control border border-dark custom-select select2' required> 
            <option value="">-</option>
            @foreach($option as $opt):
            <option value='{{ $opt->id }}'>{{ $opt->optionName }}</option>
            @endforeach;
        </select>
    </div>
    @endif
@else
    <div class='form-group pb-2'>
        <label for='optId'>Option List</label>
        <select name='optId' id='optId' class='select2 form-control border border-dark custom-select' required> 
            <option value=''>-</option>
        </select>
    </div>
@endif
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/select2/dist/js/select2.full.min.js"></script>
  <script src="{{ asset('/') }}otikaAdmin/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>