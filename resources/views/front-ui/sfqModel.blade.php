<!-- Modal TeamA -->
<div class="modal fade" id="sfq{{ $sfq->id }}{{ $ml->teamA }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white fw-bold text-center">
				<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
				<button type="button" onclick="sfqFormReset({{ $sfq->id }}{{ $ml->teamA }})" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bet-data">
				<div id="sfqSuccess{{ $sfq->id }}-{{ $ml->teamA }}"></div>
				@if(Session::get('betuser'))
					@if($sfq->status==1)
					<div class="row">
						<form method="post" id="sfqForm{{ $sfq->id }}{{ $ml->teamA }}" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
							@csrf      
							<input type="hidden" name="fieldIndex" value="{{ $sfq->id }}-{{ $ml->teamA }}">
							<ul>
								<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
								<li>Q. {{ $soptions->optionName }}</li>
								<li>A. {{ $steamA->team }}</li>
								<li>Return Value: {{ $sfq->teamA }}</li>
								<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
								<input type="hidden" name="answerId" value="{{ $sfq->quesId }}">
								<input type="hidden" name="answer" value="{{ $steamA->team }}">
								<input type="hidden" id="sfqansRate{{ $sfq->id }}{{ $ml->teamA }}"  name="answerRate" value="{{ $sfq->teamA }}">
								<input type="hidden" name="matchId" value="{{ $ml->id }}">
								<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
								<div class="input-group mb-3 row">
									<input required type="number" class="form-control col-4" id="sfqBetAmount{{ $sfq->id }}{{ $ml->teamA }}" oninput="sfqestReturn({{ $sfq->id }}{{ $ml->teamA }})" placeholder="0" name="betAmount" min="20" max="6000">
									<span class="input-group-text col-8">Est. Return &nbsp; <b id="sfqReturn{{ $sfq->id }}{{ $ml->teamA }}">0.00</b></span>
								</div>
							</ul>
							<div class="p-2">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
									onclick="sfqSubmit({{ $sfq->id }}{{ $ml->teamA }})"
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
<div class="modal fade" id="sfq{{ $sfq->id }}{{ $ml->teamB }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white fw-bold text-center">
				<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
				<button type="button" onclick="sfqFormReset({{ $sfq->id }}{{ $ml->teamB }})" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bet-data">
				<div id="sfqSuccess{{ $sfq->id }}-{{ $ml->teamB }}"></div>
				@if(Session::get('betuser'))
					@if($sfq->status==1)
					<div class="row">
						<form method="post" id="sfqForm{{ $sfq->id }}{{ $ml->teamB }}" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
							@csrf
							<input type="hidden" name="fieldIndex" value="{{ $sfq->id }}-{{ $ml->teamB }}">
							<ul>
								<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
								<li>Q. {{ $soptions->optionName }}</li>
								<li>A. {{ $steamB->team }}</li>
								<li>Return Value: {{ $sfq->teamB }}</li>
								<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
								<input type="hidden" name="answerId" value="{{ $sfq->quesId }}">
								<input type="hidden" name="answer" value="{{ $steamB->team }}">
								<input type="hidden" id="sfqansRate{{ $sfq->id }}{{ $ml->teamB }}"  name="answerRate" value="{{ $sfq->teamB }}">
								<input type="hidden" name="matchId" value="{{ $ml->id }}">
								<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
								<div class="input-group mb-3 row">
									<input required type="number" class="form-control col-4" id="sfqBetAmount{{ $sfq->id }}{{ $ml->teamB }}" oninput="sfqestReturn({{ $sfq->id }}{{ $ml->teamB }})" placeholder="0" name="betAmount" min="20" max="6000">
									<span class="input-group-text col-8">Est. Return &nbsp; <b id="sfqReturn{{ $sfq->id }}{{ $ml->teamB }}">0.00</b></span>
								</div>
							</ul>
							<div class="p-2">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
									onclick="sfqSubmit({{ $sfq->id }}{{ $ml->teamB }})'"
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
<div class="modal fade" id="sfq{{ $sfq->id }}3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark text-white fw-bold text-center">
				<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
				<button type="button" onclick="sfqFormReset({{ $sfq->id }}3)" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bet-data">
				<div id="sfqSuccess{{ $sfq->id }}-3"></div>
				@if(Session::get('betuser'))
					@if($sfq->status==1)
					<div class="row">
						<form method="post" id="sfqForm{{ $sfq->id }}3" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
							@csrf
							<input type="hidden" name="fieldIndex" value="{{ $sfq->id }}-3">
							<ul>
								<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
								<li>Q. {{ $soptions->optionName }}</li>
								<li>A. {{ $steamB->team }}</li>
								<li>Return Value: {{ $sfq->teamB }}</li>
								<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
								<input type="hidden" name="answerId" value="{{ $sfq->quesId }}">
								<input type="hidden" name="answer" value="Draw">
								<input type="hidden" id="sfqansRate{{ $sfq->id }}3" name="answerRate" value="{{ $sfq->draw }}">
								<input type="hidden" name="matchId" value="{{ $ml->id }}">
								<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
								<div class="input-group mb-3 row">
									<input required type="number" class="form-control col-4" id="sfqBetAmount{{ $sfq->id }}3" oninput="sfqestReturn({{ $sfq->id }}3)" placeholder="0" name="betAmount" min="20" max="6000">
									<span class="input-group-text col-8">Est. Return &nbsp; <b id="sfqReturn{{ $sfq->id }}3">0.00</b></span>
								</div>
							</ul>
							<div class="p-2">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
									onclick="sfqSubmit({{ $sfq->id }}3)'"
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