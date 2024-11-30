@if(count($option)>0)
    @if($qId>2)
        <option value=''>Select Question</option>
        @foreach($option as $opt):
        <option value='{{ $opt->id }}'>{{ $opt->optionName }}</option>
        @endforeach;
    @else
        <option value=''>Select Question</option>
        @foreach($option as $opt):
        <option value='{{ $opt->id }}'>{{ $opt->optionName }}</option>
        @endforeach;
    @endif
@else
    <option value=''>-</option>
@endif