@if(count($team)>0)
    @php
        $ateam = \App\Models\Team::orderBy('updated_at','DESC')->get();
        if(count($team)>0):
            foreach($team as $at):
    @endphp
        <option value="{{ $at->id }}">{{ $at->team }}</option>
    @php
            endforeach;
        endif;
    @endphp
@else
    <option value=''>-</option>     
@endif