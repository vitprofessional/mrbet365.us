
                                        <!-- Single Question -->
                                        @php
                                            $singlefixedQuestion = \App\Models\FixedQuestion::where(['matchId'=>$ml->id])->where(['catId'=>$ml->category])->where(['tournament'=>$ml->tournament])->get();
                                        @endphp
                                        @foreach($singlefixedQuestion as $sfq)
                                            @if($sfq->status==1 || $sfq->status==2)
                                            @php
                                                $soptions = \App\Models\BetOption::find($sfq->quesId);
                                                $steamA = \App\Models\Team::find($ml->teamA);
                                                $steamB = \App\Models\Team::find($ml->teamB);
                                            @endphp
                                                <p class="my-0 bet-title">{{ $soptions->optionName }}</p>
                                                    @if($sfq->status==1)
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#sfq{{ $sfq->id }}{{ $ml->teamA }}"><div class="row"><div class="col-9 text-start">{{ $steamA->team}}</div> <div class="col-3 text-end text-rate">{{ $sfq->teamA }}</div></div></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#sfq{{ $sfq->id }}{{ $ml->teamB }}"><div class="row"><div class="col-9 text-start">{{ $steamB->team}}</div> <div class="col-3 text-end text-rate">{{ $sfq->teamB }}</div></div></button>
                                                        </div>
                                                    </div>
@include('front-ui.sfqModel')
                                                        @if($sfq->draw>0)
                                                        <div class="col-6 col-md-4">
                                                            <div class="d-grid gap-2">
                                                                <button type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#sfq{{ $sfq->id }}3"><div class="row"><div class="col-9 text-start">Draw/Tie</div> <div class="col-3 text-end text-rate">{{ $sfq->draw }}</div></div></button>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @else
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{ $steamA->name }}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4">
                                                        <div class="d-grid gap-2">
                                                            <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{ $steamB->name }}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                    </div>
                                                        @if($sfq->draw>0)
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