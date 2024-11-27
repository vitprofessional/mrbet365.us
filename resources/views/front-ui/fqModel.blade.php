<!-- Modal TeamA -->
<div class="modal fade" id="fq{{ $fq->id }}{{ $ml->teamA }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white fw-bold text-center">
				<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
				<button type="button" onclick="fqFormReset({{ $fq->id }}{{ $ml->teamA }})" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bet-data">
				<div id="fqSuccess{{ $fq->id }}-{{ $ml->teamA }}"></div>
				@if(Session::get('betuser'))
					@if($fq->status==1)
					<div class="row">
						<form method="post" id="fqForm{{ $fq->id }}{{ $ml->teamA }}" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
							@csrf      
							<input type="hidden" name="fieldIndex" value="{{ $fq->id }}-{{ $ml->teamA }}">
							<ul>
								<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
								<li>Q. {{ $options->optionName }}</li>
								<li>A. {{ $teamA->team }}</li>
								<li>Return Value: {{ $fq->teamA }}</li>
								<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
								<input type="hidden" name="answerId" value="{{ $fq->quesId }}">
								<input type="hidden" name="answer" value="{{ $teamA->team }}">
								<input type="hidden" id="fqansRate{{ $fq->id }}{{ $teamA->id }}"  name="answerRate" value="{{ $fq->teamA }}">
								<input type="hidden" name="matchId" value="{{ $ml->id }}">
								<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
								<div class="input-group mb-3 row">
									<input required type="number" class="form-control col-4" id="fqBetAmount{{ $fq->id }}{{ $teamA->id }}" oninput="fqestReturn({{ $fq->id }}{{ $teamA->id }})" placeholder="0" value="" name="betAmount" min="20" max="6000">
									<span class="input-group-text col-8">Est. Return &nbsp; <b id="fqReturn{{ $fq->id }}{{ $teamA->id }}">0.00</b></span>
								</div>
							</ul>
							<div class="p-2">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
									onclick="fqSubmit({{ $fq->id }}{{ $ml->teamA }})"
									style="font-size:1.2rem">Place Bet</button>
								</div>
							</div>
						</form>
					</div>
					@else
					<div>
						<ul>
							<li class="fw-bold text-danger text-center">Sorry! No bets available</li>
						</ul>
					</div>
					@endif
				@else
					<ul>
						<li class="fw-bold text-danger text-center">Please login to continue</li>
					</ul>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- FQ Modal teamA End -->
<!-- Modal teamB -->
<div class="modal fade" id="fq{{ $fq->id }}{{ $ml->teamB }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white fw-bold text-center">
				<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
				<button type="button" onclick="fqFormReset({{ $fq->id }}{{ $ml->teamB }})" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bet-data">
				<div id="fqSuccess{{ $fq->id }}-{{ $ml->teamB }}"></div>
				@if(Session::get('betuser'))
					@if($fq->status==1)
					<div class="row">
						<form method="post" id="fqForm{{ $fq->id }}{{ $ml->teamB }}" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
							@csrf
							<input type="hidden" name="fieldIndex" value="{{ $fq->id }}-{{ $ml->teamB }}">
							<ul>
								<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
								<li>Q. {{ $options->optionName }}</li>
								<li>A. {{ $teamB->team }}</li>
								<li>Return Value: {{ $fq->teamB }}</li>
								<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
								<input type="hidden" name="answerId" value="{{ $fq->quesId }}">
								<input type="hidden" name="answer" value="{{ $teamB->team }}">
								<input type="hidden" id="fqansRate{{ $fq->id }}{{ $teamB->id }}"  name="answerRate" value="{{ $fq->teamB }}">
								<input type="hidden" name="matchId" value="{{ $ml->id }}">
								<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
								<div class="input-group mb-3 row">
									<input required type="number" class="form-control col-4" id="fqBetAmount{{ $fq->id }}{{ $teamB->id }}" oninput="fqestReturn({{ $fq->id }}{{ $teamB->id }})" placeholder="0" name="betAmount" v-model="betAmount" min="20" max="6000">
									<span class="input-group-text col-8">Est. Return &nbsp; <b id="fqReturn{{ $fq->id }}{{ $teamB->id }}">0.00</b></span>
								</div>
							</ul>
							<div class="p-2">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
									onclick="fqSubmit({{ $fq->id }}{{ $ml->teamB }})'"
									style="font-size:1.2rem">Place Bet</button>
								</div>
							</div>
						</form>
					</div>
					@else
					<div>
						<ul>
							<li class="fw-bold text-danger text-center">Sorry! No bets available</li>
						</ul>
					</div>
					@endif
				@else
					<ul>
						<li class="fw-bold text-danger text-center">Please login to continue</li>
					</ul>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- FQ Modal TeamB End -->
<!-- Modal draw -->
<div class="modal fade" id="fq{{ $fq->id }}3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white fw-bold text-center">
				<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
				<button type="button" onclick="fqFormReset({{ $fq->id }}3)" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bet-data">
				<div id="fqSuccess{{ $fq->id }}-3"></div>
				@if(Session::get('betuser'))
					@if($fq->status==1)
					<div class="row">
						<form method="post" id="fqForm{{ $fq->id }}3" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
							@csrf
							<input type="hidden" name="fieldIndex" value="{{ $fq->id }}-3">
							<ul>
								<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
								<li>Q. {{ $options->optionName }}</li>
								<li>A. {{ $teamB->team }}</li>
								<li>Return Value: {{ $fq->teamB }}</li>
								<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
								<input type="hidden" name="answerId" value="{{ $fq->quesId }}">
								<input type="hidden" name="answer" value="Draw">
								<input type="hidden" id="fqansRate{{ $fq->id }}3" name="answerRate" value="{{ $fq->draw }}">
								<input type="hidden" name="matchId" value="{{ $ml->id }}">
								<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
								<div class="input-group mb-3 row">
									<input required type="number" class="form-control col-4" id="fqBetAmount{{ $fq->id }}3" oninput="fqestReturn({{ $fq->id }}3)" placeholder="0" name="betAmount" v-model="betAmount" min="20" max="6000">
									<span class="input-group-text col-8">Est. Return &nbsp; <b id="fqReturn{{ $fq->id }}3">0.00</b></span>
								</div>
							</ul>
							<div class="p-2">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
									onclick="fqSubmit({{ $fq->id }}3)'"
									style="font-size:1.2rem">Place Bet</button>
								</div>
							</div>
						</form>
					</div>
					@else
					<div>
						<ul>
							<li class="fw-bold text-danger text-center">Sorry! No bets available</li>
						</ul>
					</div>
					@endif
				@else
					<ul>
						<li class="fw-bold text-danger text-center">Please login to continue</li>
					</ul>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- FQ Modal Draw End -->