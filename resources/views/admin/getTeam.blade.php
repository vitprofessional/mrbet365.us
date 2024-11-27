@if(count($team)>0)
    <div class="form-group pb-2">
        <label for="ateam">Home Team</label>
        <select name="ateam" class="form-control border border-dark" required>
            <option value="">-</option>
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
        </select>
    </div>
    <div class="form-group pb-2">
        <label for="bteam">Away Team</label>
        <select name="bteam" class="form-control border border-dark" required>
            <option value="">-</option>
            @php
                $bteam = \App\Models\Team::orderBy('updated_at','DESC')->get();
                if(count($team)>0):
                    foreach($team as $bt):
            @endphp
                <option value="{{ $bt->id }}">{{ $bt->team }}</option>
            @php
                    endforeach;
                endif;
            @endphp
        </select>
    </div>
@else
    <div class='form-group pb-2'>
        <label for='team'>Team</label>
        <select name='team' id='team' class='form-control border border-dark' required> 
            <option value=''>-</option>
        </select>
    </div>
@endif