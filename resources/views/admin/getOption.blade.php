@if(count($option)>0)
    <div class='form-group pb-2'>
        <label for='category'>Option List</label>
        <select name='optId' id='option' class='select2 form-control border border-dark custom-select' required> 
            @foreach($option as $opt):
            <option value='{{ $opt->id }}'>{{ $opt->optionName }}</option>
            @endforeach;
        </select>
    </div>
    @if(count($team)>0)
    <div class="form-group pb-2 homeTeamHideShow">
        <label for="ateam">Home Team</label>
        <select name="ateam" class="select2 form-control border border-dark custom-select" required>
            @foreach($team as $at)
                <option value="{{ $at->id }}">{{ $at->team }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group pb-2 awayTeamHideShow">
        <label for="bteam">Away Team</label>
        <select name="bteam" class="select2 form-control border border-dark custom-select" required>
            @foreach($team as $bt)
                <option value="{{ $bt->id }}">{{ $bt->team }}</option>
            @endforeach
        </select>
    </div>
    @endif
@else
    <div class='form-group pb-2'>
        <label for='option'>Option List</label>
        <select name='option' id='option' class='select2 form-control border border-dark custom-select' required> 
            <option value=''>-</option>
        </select>
    </div>
@endif