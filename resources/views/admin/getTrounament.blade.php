@if(count($tournament)>0)
    <div class="form-group pb-2">
        <label for="tournament">Tournament</label>
        <select name="tournament" onchange="changeTournament()" id="tournament" class="form-control border border-dark" required>
            <option value=''>-</option>
            @php
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
@else
    <div class='form-group pb-2'>
        <label for='category'>Tournament</label>
        <select name='tournament' id='tournament' class='form-control border border-dark' required> 
            <option value=''>-</option>
        </select>
    </div>
@endif