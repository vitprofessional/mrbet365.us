
                                        <!-- Single Question -->
                                        @php
                                            $fixedQuestion = \App\Models\FixedQuestion::where(['matchId'=>$ml->id])->where(['catId'=>$ml->category])->where(['tournament'=>$ml->tournament])->get();
                                        @endphp
                                        @foreach($fixedQuestion as $fq)
                                            @if($fq->status==1 || $fq->status==2)
                                            @php
                                                $options = \App\Models\BetOption::find($fq->quesId);
                                                $teamA = \App\Models\Team::find($ml->teamA);
                                                $teamB = \App\Models\Team::find($ml->teamB);
                                            @endphp
                                                <p class="my-0 bet-title">{{ $options->optionName }}</p>
                                                    @if($fq->status==1)
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#fq{{ $fq->id }}{{ $ml->teamA }}"><div class="row"><div class="col-9 text-start">{{ $teamA->team}}</div> <div class="col-3 text-end text-rate">{{ $fq->teamA }}</div></div></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#fq{{ $fq->id }}{{ $ml->teamB }}"><div class="row"><div class="col-9 text-start">{{ $teamB->team}}</div> <div class="col-3 text-end text-rate">{{ $fq->teamB }}</div></div></button>
                                                        </div>
                                                    </div>
@include('front-ui.fqModel')
                                                        @if($fq->draw>0)
                                                        <div class="col-6 col-md-4">
                                                            <div class="d-grid gap-2">
                                                                <button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#fq{{ $fq->id }}3"><div class="row"><div class="col-9 text-start">Draw/Tie</div> <div class="col-3 text-end text-rate">{{ $fq->draw }}</div></div></button>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @else
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{ $teamA->name }}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{ $teamB->name }}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                    </div>
                                                        @if($fq->draw>0)
                                                        <div class="col-6 col-md-4">
                                                            <div class="d-grid gap-2">
                                                                <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">Tie/Draw</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endif
                                                @else
                                                @endif
                                            @endforeach
                                        <!-- End Single Question -->