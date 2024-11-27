@php
	$singleQuestion = \App\Models\MatchQuestion::where(['matchId'=>$ml->id])->where(['catId'=>$ml->category])->where(['tournament'=>$ml->tournament])->orderBy('id','DESC')->get();
@endphp
@if(count($singleQuestion)>0)
	@foreach($singleQuestion as $scq)
	@php
		$soptions = \App\Models\BetOption::find($scq->quesId);
		$sanswers = \App\Models\MatchAnswer::where(['quesId'=>$scq->id])->get();
	@endphp
		@if($scq->status==1 || $scq->status==2)
		<p class="my-0 bet-title">{{ $soptions->optionName }}</p>
		<div class="border border-dark text-muted row g-0 bet-option-bg">
			@if(count($sanswers)>0)
				@foreach($sanswers as $sans)
					<div class="col-6 col-md-4">
						<div class="d-grid gap-2">
							@if($scq->status==1)
							<button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#scq{{ $scq->id }}{{ $sans->id }}">
								<div class="row">
									<div class="col-9 text-start">{{ $sans->answer}}</div> 
									<div class="col-3 text-end text-rate">{{ $sans->returnValue }}</div>
								</div>
							</button>
							@else
							<button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid">
								<div class="row">
									<div class="col-9 text-start">{{ $sans->answer }}</div> 
									<div class="col-3 text-end text-rate">-</div>
								</div>
							</button>
							@endif
						</div>
					</div>
					<!-- Modal -->
					<div class="modal fade" id="scq{{ $scq->id }}{{ $sans->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header bg-dark text-white fw-bold text-center">
									<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
									<button type="button" class="btn-close" data-bs-dismiss="modal" onclick="scqFormReset({{ $scq->id }}{{ $sans->id }})" aria-label="Close"></button>
								</div>
								<div class="modal-body bet-data">
									<div id="scqSuccess{{ $scq->id }}-{{ $sans->id }}"></div>
									@if(Session::get('betuser'))
										@if($scq->status==1)
											<div class="row">
												<form method="post" action="javascript:void(0)" id="scqForm{{ $scq->id }}{{ $sans->id }}" class="form col-12 col-md-10 mx-auto">
													@csrf          
													<input type="hidden" name="fieldIndex" value="{{ $scq->id }}-{{ $sans->id }}">
													<ul>
														<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
														<li>Q. {{ $soptions->optionName }}</li>
														<li>A. {{ $sans->answer }}</li>
														<li>Return Value: {{ $sans->returnValue }}</li>
														<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
														<input type="hidden" name="answerId" value="{{ $scq->quesId }}">
														<input type="hidden" name="answer" value="{{ $sans->answer }}">
														<input type="hidden" name="answerRate" id="scqansRate{{ $scq->id }}{{ $sans->id }}" value="{{ $sans->returnValue }}">
														<input type="hidden" name="matchId" value="{{ $ml->id }}">
														<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
														<div class="input-group mb-3 row">
															<input required type="number" class="form-control col-4" placeholder="0" name="betAmount" id="scqBetAmount{{ $scq->id }}{{ $sans->id }}" min="20" oninput="scqestReturn({{ $scq->id }}{{ $sans->id }})" max="6000">
															<span class="input-group-text col-8">Est. Return &nbsp; <b id="scqReturn{{ $scq->id }}{{ $sans->id }}">0.00</b></span>
														</div>
													</ul>
													<div class="p-2">
														<div class="d-grid gap-2">
															<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
															onclick="cqSubmit({{ $scq->id }}{{ $sans->id }})"
															style="font-size:1.2rem">Place Bet</button>
														</div>
													</div>
												</form>
											</div>
										@else
											<ul>
												<li class="fw-bold text-danger text-center">Sorry! No bets available</li>
											</ul>
										@endif
									@else
										<ul>
											<li class="fw-bold text-danger text-center">Please login to continue</li>
										</ul>
									@endif
								</div>
							</div>
						</div>
						<!-- CQ Modal End -->
					</div>
				@endforeach
			@endif
		</div>
		@endif
	@endforeach
@endif