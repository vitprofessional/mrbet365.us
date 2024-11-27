@php
	$customQuestion = \App\Models\MatchQuestion::where(['matchId'=>$ml->id])->where(['catId'=>$ml->category])->where(['tournament'=>$ml->tournament])->get();
@endphp
@if(count($customQuestion)>0)
	@foreach($customQuestion as $cq)
	@php
		$options = \App\Models\BetOption::find($cq->quesId);
		$answers = \App\Models\MatchAnswer::where(['quesId'=>$cq->id])->get();
	@endphp
		@if($cq->status==1 || $cq->status==2)
		<p class="my-0 bet-title">{{ $options->optionName }}</p>
		<div class="border border-dark text-muted row g-0 bet-option-bg">
			@if(count($answers)>0)
				@foreach($answers as $ans)
					<div class="col-6 col-md-4">
						<div class="d-grid gap-2">
							@if($cq->status==1)
							<button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#cq{{ $cq->id }}{{ $ans->id }}">
								<div class="row">
									<div class="col-9 text-start">{{ $ans->answer}}</div> 
									<div class="col-3 text-end text-rate">{{ $ans->returnValue }}</div>
								</div>
							</button>
							@else
							<button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid">
								<div class="row">
									<div class="col-9 text-start">{{ $ans->answer }}</div> 
									<div class="col-3 text-end text-rate">-</div>
								</div>
							</button>
							@endif
						</div>
					</div>
					<!-- Modal -->
					<div class="modal fade" id="cq{{ $cq->id }}{{ $ans->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header bg-dark text-white fw-bold text-center">
									<h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
									<button type="button" class="btn-close" data-bs-dismiss="modal" onclick="cqFormReset({{ $cq->id }}{{ $ans->id }})" aria-label="Close"></button>
								</div>
								<div class="modal-body bet-data">
									<div id="cqSuccess{{ $cq->id }}-{{ $ans->id }}"></div>
									@if(Session::get('betuser'))
										@if($cq->status==1)
											<div class="row">
												<form method="post" action="javascript:void(0)" id="cqForm{{ $cq->id }}{{ $ans->id }}" class="form col-12 col-md-10 mx-auto">
													@csrf       
													<input type="hidden" name="fieldIndex" value="{{ $cq->id }}-{{ $ans->id }}">
													<ul>
														<li class="fw-bold text-warning">Minimum bet amount 20   & Maximum 6000</li>
														<li>Q. {{ $options->optionName }}</li>
														<li>A. {{ $ans->answer }}</li>
														<li>Return Value: {{ $ans->returnValue }}</li>
														<input type="hidden" name="userId" value="{{ Session::get('betuser') }}">
														<input type="hidden" name="answerId" value="{{ $cq->quesId }}">
														<input type="hidden" name="answer" value="{{ $ans->answer }}">
														<input type="hidden" name="answerRate" id="cqansRate{{ $cq->id }}{{ $ans->id }}" value="{{ $ans->returnValue }}">
														<input type="hidden" name="matchId" value="{{ $ml->id }}">
														<input type="hidden" name="tournament" value="{{ $ml->tournament }}">
														<div class="input-group mb-3 row">
															<input required type="number" class="form-control col-4" placeholder="0" name="betAmount" id="cqBetAmount{{ $cq->id }}{{ $ans->id }}" min="20" oninput="cqestReturn({{ $cq->id }}{{ $ans->id }})" max="6000">
															<span class="input-group-text col-8">Est. Return &nbsp; <b id="cqReturn{{ $cq->id }}{{ $ans->id }}">0.00</b></span>
														</div>
													</ul>
													<div class="p-2">
														<div class="d-grid gap-2">
															<button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
															onclick="cqSubmit({{ $cq->id }}{{ $ans->id }})"
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