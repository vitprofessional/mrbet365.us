<template>
    <div>
        <nav class="navtabs mt-0 tabbable">
            <div class="nav nav-tabs bet-icon" id="nav-tab" role="tablist">
                <button v-bind:class="BindBtnClass('NULL')"  id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true"><img src="\assets\images\trophy.png" alt="All Sports"><br>All Sports</button>
                <button v-for="(val,key) in catData" v-bind:class="BindBtnClass(val.id)" :id="'nav-'+val.id+'-tab'" data-bs-toggle="tab" :data-bs-target="'#nav-'+val.id" type="button" role="tab" :aria-controls="'nav-'+val.id" aria-selected="true"> <img :src="val.catLogo" :alt="val.name"><br>{{ val.name }}</button>
            </div> 
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div v-bind:class="BindClass('NULL')" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                <div v-for="(val,key) in betData">
                    <div class="col-4 col-md-2 text-center mx-auto text-uppercase category-title">{{ val.name }}</div>
                    <div v-if="val.matchList==0" class="bg-category mb-4">
                        <div class="alert">
                            No live betting available in {{ val.name }}
                        </div>
                    </div>
                    <div v-else class="bg-category mb-4">
                        <!-- Question start -->
                            <div v-for="(mlVal, mlKey) in val.matchList">
                                <section v-if="mlVal.status == 2" class="text-start">
                                    <!-- Tournament Title -->
                                    <div class="tournament-title text-white">
                                        <h3><div class="mb-2">{{mlVal.tournamentName}} | {{ mlVal.matchTime  | moment('Do MMMM,YYYY | hh:mm A')}}</div><div class="mt-1">--{{mlVal.matchName}}</div></h3>
                                    </div>
                                    <div class="h3 alert">No betting available right now</div>
                                </section>
                                <section v-else-if="mlVal.status== 1" class="pb-4 mb-4">
                                    <!-- Tournament Title -->
                                    <div class="text-white tournament-title">
                                        <div class="row align-items-center">
                                            <div class="col-10">
                                                <h3><div class="mb-2">{{mlVal.tournamentName}} | {{ mlVal.matchTime  | moment('Do MMMM,YYYY | hh:mm A')}}</div><div class="mt-1">--{{mlVal.matchName}}</div></h3>
                                            </div>
                                            <div class="col-2 text-end">
                                                <span class="text-end bg-danger text-white px-2 rounded" v-if="new Date(mlVal.matchTime) < Date.now()">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bet-question">
                                        <div v-for="(fqVal,fqKey) in mlVal.fixedQuestion">
                                            <div v-if="fqVal.status==1 || fqVal.status==2">
                                                <p class="my-0 bet-title">{{fqVal.options.optionName}}</p>
                                                <div class="border border-dark text-muted row g-0 bet-option-bg">
                                                    <div class="col-6 col-md-4" v-if="fqVal.status==1 | fqVal.status==2"  v-for="(team,tindex) in fqVal.team">
                                                        <div class="d-grid gap-2">
                                                            <button v-if="fqVal.status == 1" type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" :data-bs-target="'#fq'+fqVal.id+tindex"><div class="row"><div class="col-9 text-start">{{team.name}}</div> <div class="col-3 text-end text-rate">{{ team.value }}</div></div></button>
                                                            <button v-else disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{team.name}}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="modal fade" :id="'fq'+fqVal.id+tindex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-dark text-white fw-bold text-center">
                                                                        <h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
                                                                        <button type="button" id="fqReset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bet-data">
                                                                        <div :id="'fqSuccess'+fqVal.id+'-'+tindex"></div>
                                                                        <div v-if="val.sessionUser != null">
                                                                            <div class="row" v-if="fqVal.status == 1" :id="'fqForm'+fqVal.id+tindex">
                                                                                <form method="post" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
                                                                                    <input type="hidden" name="_token" :value="val.csrf_field" />
                                                                                    <input type="hidden" name="fieldIndex[]" :value="fqVal.id+'-'+tindex">
                                                                                    <ul>
                                                                                        <li class="fw-bold text-warning">Minimum bet amount {{ val.SD.minBet }}   & Maximum {{ val.SD.maxBet }}</li>
                                                                                        <li>Q. {{ fqVal.options.optionName }}</li>
                                                                                        <li>A. {{ team.name }}</li>
                                                                                        <li>Return Value: {{ team.value }}</li>
                                                                                        <input type="hidden" name="userId" :value="val.sessionUser">
                                                                                        <input type="hidden" name="answerId" :value="fqVal.quesId">
                                                                                        <input type="hidden" name="answer" :value="team.name">
                                                                                        <input type="hidden" name="answerRate" :value="team.value">
                                                                                        <input type="hidden" name="matchId" :value="mlVal.id">
                                                                                        <input type="hidden" name="tournament" :value="mlVal.tournament">
                                                                                        <div class="input-group mb-3 row">
                                                                                            <input required type="number" class="form-control col-4" placeholder="0" name="betAmount" v-model="betAmount" :min="val.SD.minBet" :max="val.SD.maxBet">
                                                                                            <span class="input-group-text col-8">Est. Return <b id="fqReturn"> {{(betAmount*team.value).toFixed(2)}}</b></span>
                                                                                        </div>
                                                                                    </ul>
                                                                                    <div class="p-2">
                                                                                        <div class="d-grid gap-2">
                                                                                            <button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  
                                                                                            :onclick="'fqSubmit('+fqVal.id+tindex+')'"
                                                                                            style="font-size:1.2rem">Place Bet</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div v-else>
                                                                                <ul>
                                                                                    <li class="fw-bold text-danger text-center">Sorry! No bets available</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div v-else>
                                                                            <ul>
                                                                                <li class="fw-bold text-danger text-center">Please login to continue</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- FQ Modal End -->
                                                        
                                                    </div>
                                                    <div class="col-12 col-md-4" v-else>
                                                        <div class="d-grid gap-2">
                                                            <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#tosssrilanka"><div class="row"><div class="col-12 text-start">No Bets Available</div></div></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4" v-if="fqVal.draw==null">
                                                    </div>
                                                    <div class="col-6 col-md-4" v-else>
                                                        <div class="d-grid gap-2">
                                                            <button v-if="fqVal.status == 1" type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" :data-bs-target="'#fq'+fqVal.id+3"><div class="row"><div class="col-9 text-start">Tie/Draw</div> <div class="col-3 text-end text-rate">{{ fqVal.draw }}</div></div></button>
                                                            <button v-else disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">Tie/Draw</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="modal fade" :id="'fq'+fqVal.id+3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-dark text-white fw-bold text-center">
                                                                        <h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bet-data">
                                                                        <div :id="'fqSuccess'+fqVal.id+'-'+3"></div>
                                                                        <div v-if="val.sessionUser != null">
                                                                            <div class="row" v-if="fqVal.status == 1" :id="'fqForm'+fqVal.id+3">
                                                                                <form method="post" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
                                                                                    <input type="hidden" name="_token" :value="val.csrf_field" />
                                                                                    <input type="hidden" name="fieldIndex" :value="fqVal.id+'-'+3">
                                                                                    <ul>
                                                                                        <li class="fw-bold text-warning">Minimum bet amount {{ val.SD.minBet }}   & Maximum {{ val.SD.maxBet }}</li>
                                                                                        <li>Q. {{ fqVal.options.optionName }}</li>
                                                                                        <li>A. Tie/Draw</li>
                                                                                        <li>Return Value: {{ fqVal.draw }}</li>
                                                                                        <input type="hidden" name="userId" :value="val.sessionUser">
                                                                                        <input type="hidden" name="answerId" :value="fqVal.quesId">
                                                                                        <input type="hidden" name="answer" value="draw">
                                                                                        <input type="hidden" name="answerRate" :value="fqVal.draw">
                                                                                        <input type="hidden" name="matchId" :value="mlVal.id">
                                                                                        <input type="hidden" name="tournament" :value="mlVal.tournament">
                                                                                        <div class="input-group mb-3 row">
                                                                                            <input required type="number" class="form-control col-4" placeholder="0" name="betAmount" v-model="betAmount" :min="val.SD.minBet" :max="val.SD.maxBet">
                                                                                            <span class="input-group-text col-8">Est. Return {{ (betAmount*fqVal.draw).toFixed(2)}}</span>
                                                                                        </div>
                                                                                    </ul>
                                                                                    <div class="p-2">
                                                                                        <div class="d-grid gap-2">
                                                                                            <button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold" :onclick="'fqSubmit('+fqVal.id+3+')'"  style="font-size:1.2rem">Place Bet</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div v-else>
                                                                                <ul>
                                                                                    <li class="fw-bold text-danger text-center">Sorry! No bets available</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div v-else>
                                                                            <ul>
                                                                                <li class="fw-bold text-danger text-center">Please login to continue</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- FQ Modal End -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="bet-question">
                                        <div v-for="(cqVal,cqKey) in mlVal.customQuestion">
                                            <div v-if="cqVal.status==1 || cqVal.status==2">
                                            <p class="my-0 bet-title">{{cqVal.options.optionName}}</p>
                                            <div class="border border-dark text-muted row g-0 bet-option-bg">
                                                <div class="col-6 col-md-4"  v-for="(answer,aindex) in cqVal.customAnswer">
                                                    <div class="d-grid gap-2">
                                                        <button v-if="cqVal.status == 1" type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" :data-bs-target="'#cq'+cqVal.id+aindex"><div class="row"><div class="col-9 text-start">{{answer.answer}}</div> <div class="col-3 text-end text-rate">{{ answer.returnValue }}</div></div></button>
                                                        <button v-else disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{answer.answer}}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" :id="'cq'+cqVal.id+aindex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark text-white fw-bold text-center">
                                                                <h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bet-data">
                                                                <div :id="'cqSuccess'+cqVal.id+'-'+aindex"></div>
                                                                <div v-if="val.sessionUser != null">
                                                                    <div class="row" v-if="cqVal.status == 1" :id="'cqForm'+cqVal.id+aindex">
                                                                            <form method="post" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
                                                                                <input type="hidden" name="_token" :value="val.csrf_field" />
                                                                                <input type="hidden" name="fieldIndex" :value="cqVal.id+'-'+aindex">
                                                                            <ul>
                                                                                <li class="fw-bold text-warning">Minimum bet amount {{ val.SD.minBet }}   & Maximum {{ val.SD.maxBet }}</li>
                                                                                <li>Q. {{ cqVal.options.optionName }}</li>
                                                                                <li>A. {{ answer.answer }}</li>
                                                                                <li>Return Value: {{ answer.returnValue }}</li>
                                                                                    <input type="hidden" name="userId" :value="val.sessionUser">
                                                                                    <input type="hidden" name="answerId" :value="cqVal.quesId">
                                                                                    <input type="hidden" name="answer" :value="answer.answer">
                                                                                    <input type="hidden" name="answerRate" :value="answer.returnValue">
                                                                                    <input type="hidden" name="matchId" :value="mlVal.id">
                                                                                    <input type="hidden" name="tournament" :value="mlVal.tournament">
                                                                                <div class="input-group mb-3 row">
                                                                                    <input required type="number" id="betAmount" class="form-control col-4" placeholder="0" name="betAmount" v-model="betAmount" :min="val.SD.minBet" :max="val.SD.maxBet">
                                                                                    <span class="input-group-text col-8">Est. Return {{ (betAmount*answer.returnValue).toFixed(2)}}</span>
                                                                                </div>
                                                                            </ul>
                                                                            <div class="p-2">
                                                                                <div class="d-grid gap-2">
                                                                                    <button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold" :onclick="'cqSubmit('+cqVal.id+aindex+')'"  style="font-size:1.2rem">Place Bet</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div v-else>
                                                                        <ul>
                                                                            <li class="fw-bold text-danger text-center">Sorry! No bets available</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <ul>
                                                                        <li class="fw-bold text-danger text-center">Please login to continue</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- FQ Modal End -->
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    </section>
                                <section v-else class="text-center">
                                </section>
                            </div>
                        <!-- Fixed Question End -->                    
                        <!-- Match Option End -->
                    </div>
                </div>
            </div>
                <div v-for="(val,key) in betData" v-bind:class="BindClass(val.id)" :id="'nav-'+val.id" role="tabpanel" :aria-labelledby="'nav-'+val.id+'-tab'">
                    
                    <div class="col-4 col-md-2 text-center mx-auto text-uppercase category-title">{{ val.name }}</div>
                    <div v-if="val.matchList==0" class="bg-category">
                        <div class="alert">
                            No live betting available in {{ val.name }}
                        </div>
                    </div>
                    <div v-else class="bg-category">
                        <!-- Question start -->
                            <div v-for="(mlVal, mlKey) in val.matchList">
                                <section v-if="mlVal.status == 2" class="text-start">
                                    <!-- Tournament Title -->
                                    <div class="tournament-title text-white">
                                        <h3><div class="mb-2">{{mlVal.tournamentName}} | {{ mlVal.matchTime  | moment('Do MMMM,YYYY | hh:mm A')}}</div><div class="mt-1">--{{mlVal.matchName}}</div></h3>
                                    </div>
                                    <div class="h3 alert">No betting available right now</div>
                                </section>
                                <section v-else-if="mlVal.status== 1" class="pb-4 mb-4">
                                    <!-- Tournament Title -->
                                    <div class="text-white tournament-title">
                                        <div class="row align-items-center">
                                            <div class="col-10">
                                                <h3><div class="mb-2">{{mlVal.tournamentName}} | {{ mlVal.matchTime  | moment('Do MMMM,YYYY | hh:mm A')}}</div><div class="mt-1">--{{mlVal.matchName}}</div></h3>
                                            </div>
                                            <div class="col-2 text-end">
                                                <span class="text-end bg-danger text-white px-2 rounded" v-if="new Date(mlVal.matchTime) < Date.now()">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bet-question">
                                        <div v-for="(fqVal,fqKey) in mlVal.fixedQuestion">
                                            <div v-if="fqVal.status==1 || fqVal.status==2">
                                                <p class="my-0 bet-title">{{fqVal.options.optionName}}</p>
                                                <div class="border border-dark text-muted row g-0 bet-option-bg">
                                                    <div class="col-6 col-md-4" v-if="fqVal.status==1 | fqVal.status==2"  v-for="(team,tindex) in fqVal.team">
                                                        <div class="d-grid gap-2">
                                                            <button v-if="fqVal.status == 1" type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" :data-bs-target="'#sfq'+fqVal.id+tindex"><div class="row"><div class="col-9 text-start">{{team.name}}</div> <div class="col-3 text-end text-rate">{{ team.value }}</div></div></button>
                                                            <button v-else disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{team.name}}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="modal fade" :id="'sfq'+fqVal.id+tindex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-dark text-white fw-bold text-center">
                                                                        <h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
                                                                        <button type="button" id="fqReset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bet-data">
                                                                        <div :id="'sfqSuccess'+fqVal.id+'-'+tindex"></div>
                                                                        <div v-if="val.sessionUser != null">
                                                                            <div class="row" v-if="fqVal.status == 1" :id="'sfqForm'+fqVal.id+tindex">
                                                                                <form method="post" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
                                                                                    <input type="hidden" name="_token" :value="val.csrf_field" />
                                                                                    <input type="hidden" name="fieldIndex" :value="fqVal.id+'-'+tindex">
                                                                                    <ul>
                                                                                        <li class="fw-bold text-warning">Minimum bet amount {{ val.SD.minBet }}   & Maximum {{ val.SD.maxBet }}</li>
                                                                                        <li>Q. {{ fqVal.options.optionName }}</li>
                                                                                        <li>A. {{ team.name }}</li>
                                                                                        <li>Return Value: {{ team.value }}</li>
                                                                                        <input type="hidden" name="userId" :value="val.sessionUser">
                                                                                        <input type="hidden" name="answerId" :value="fqVal.quesId">
                                                                                        <input type="hidden" name="answer" :value="team.name">
                                                                                        <input type="hidden" name="answerRate" :value="team.value">
                                                                                        <input type="hidden" name="matchId" :value="mlVal.id">
                                                                                        <input type="hidden" name="tournament" :value="mlVal.tournament">
                                                                                        <div class="input-group mb-3 row">
                                                                                            <input required type="number" class="form-control col-4" placeholder="0" name="betAmount" v-model="betAmount" :min="val.SD.minBet" :max="val.SD.maxBet">
                                                                                            <span class="input-group-text col-8">Est. Return <b id="fqReturn">{{ (betAmount*team.value).toFixed(2)}}</b></span>
                                                                                        </div>
                                                                                    </ul>
                                                                                    <div class="p-2">
                                                                                        <div class="d-grid gap-2">
                                                                                            <button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold"  :onclick="'sfqSubmit('+fqVal.id+tindex+')'" style="font-size:1.2rem">Place Bet</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div v-else>
                                                                                <ul>
                                                                                    <li class="fw-bold text-danger text-center">Sorry! No bets available</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div v-else>
                                                                            <ul>
                                                                                <li class="fw-bold text-danger text-center">Please login to continue</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- FQ Modal End -->
                                                        
                                                    </div>
                                                    <div class="col-12 col-md-4" v-else>
                                                        <div class="d-grid gap-2">
                                                            <button disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" data-bs-target="#tosssrilanka"><div class="row"><div class="col-12 text-start">No Bets Available</div></div></button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-4" v-if="fqVal.draw==null">
                                                    </div>
                                                    <div class="col-6 col-md-4" v-else>
                                                        <div class="d-grid gap-2">
                                                            <button v-if="fqVal.status == 1" type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" :data-bs-target="'#sfq'+fqVal.id+3"><div class="row"><div class="col-9 text-start">Tie/Draw</div> <div class="col-3 text-end text-rate">{{ fqVal.draw }}</div></div></button>
                                                            <button v-else disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">Tie/Draw</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                        </div>
                                                        <!-- Modal -->
                                                        <div class="modal fade" :id="'sfq'+fqVal.id+3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-dark text-white fw-bold text-center">
                                                                        <h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body bet-data">
                                                                        <div :id="'sfqSuccess'+fqVal.id+'-'+3"></div>
                                                                        <div v-if="val.sessionUser != null">
                                                                            <div class="row" v-if="fqVal.status == 1" :id="'sfqForm'+fqVal.id+3">
                                                                                <form method="post" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
                                                                                    <input type="hidden" name="_token" :value="val.csrf_field" />
                                                                                    <input type="hidden" name="fieldIndex" :value="fqVal.id+'-'+3">
                                                                                    <ul>
                                                                                        <li class="fw-bold text-warning">Minimum bet amount {{ val.SD.minBet }}   & Maximum {{ val.SD.maxBet }}</li>
                                                                                        <li>Q. {{ fqVal.options.optionName }}</li>
                                                                                        <li>A. Tie/Draw</li>
                                                                                        <li>Return Value: {{ fqVal.draw }}</li>
                                                                                        <input type="hidden" name="userId" :value="val.sessionUser">
                                                                                        <input type="hidden" name="answerId" :value="fqVal.quesId">
                                                                                        <input type="hidden" name="answer" value="draw">
                                                                                        <input type="hidden" name="answerRate" :value="fqVal.draw">
                                                                                        <input type="hidden" name="matchId" :value="mlVal.id">
                                                                                        <input type="hidden" name="tournament" :value="mlVal.tournament">
                                                                                        <div class="input-group mb-3 row">
                                                                                            <input required type="number" class="form-control col-4" placeholder="0" name="betAmount" v-model="betAmount" :min="val.SD.minBet" :max="val.SD.maxBet">
                                                                                            <span class="input-group-text col-8">Est. Return {{ (betAmount*fqVal.draw).toFixed(2)}}</span>
                                                                                        </div>
                                                                                    </ul>
                                                                                    <div class="p-2">
                                                                                        <div class="d-grid gap-2">
                                                                                            <button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold" :onclick="'sfqSubmit('+fqVal.id+3+')'"  style="font-size:1.2rem">Place Bet</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div v-else>
                                                                                <ul>
                                                                                    <li class="fw-bold text-danger text-center">Sorry! No bets available</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div v-else>
                                                                            <ul>
                                                                                <li class="fw-bold text-danger text-center">Please login to continue</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- FQ Modal End -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="bet-question">
                                        <div v-for="(cqVal,cqKey) in mlVal.customQuestion">
                                            <div v-if="cqVal.status==1 || cqVal.status==2">
                                            <p class="my-0 bet-title">{{cqVal.options.optionName}}</p>
                                            <div class="border border-dark text-muted row g-0 bet-option-bg">
                                                <div class="col-6 col-md-4"  v-for="(answer,aindex) in cqVal.customAnswer">
                                                    <div class="d-grid gap-2">
                                                        <button v-if="cqVal.status == 1" type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid" data-bs-toggle="modal" :data-bs-target="'#scq'+cqVal.id+aindex"><div class="row"><div class="col-9 text-start">{{answer.answer}}</div> <div class="col-3 text-end text-rate">{{ answer.returnValue }}</div></div></button>
                                                        <button v-else disabled type="button" class="btn btn-outline-secondary bet-option btn-sm rounded-0 btn-fluid"><div class="row"><div class="col-9 text-start">{{answer.answer}}</div> <div class="col-3 text-end text-rate">-</div></div></button>
                                                    </div>
                                                    <!-- Modal -->
                                                    <div class="modal fade" :id="'scq'+cqVal.id+aindex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark text-white fw-bold text-center">
                                                                <h2 class="modal-title" style="font-size:1.5rem" id="exampleModalLabel">Place your bet with </h2>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bet-data">
                                                                <div :id="'scqSuccess'+cqVal.id+'-'+aindex"></div>
                                                                <div v-if="val.sessionUser != null">
                                                                    <div class="row" v-if="cqVal.status == 1" :id="'scqForm'+cqVal.id+aindex">
                                                                            <form method="post" action="javascript:void(0)" class="form col-12 col-md-10 mx-auto">
                                                                                <input type="hidden" name="_token" :value="val.csrf_field" />
                                                                                <input type="hidden" name="fieldIndex" :value="cqVal.id+'-'+aindex">
                                                                            <ul>
                                                                                <li class="fw-bold text-warning">Minimum bet amount {{ val.SD.minBet }}   & Maximum {{ val.SD.maxBet }}</li>
                                                                                <li>Q. {{ cqVal.options.optionName }}</li>
                                                                                <li>A. {{ answer.answer }}</li>
                                                                                <li>Return Value: {{ answer.returnValue }}</li>
                                                                                    <input type="hidden" name="userId" :value="val.sessionUser">
                                                                                    <input type="hidden" name="answerId" :value="cqVal.quesId">
                                                                                    <input type="hidden" name="answer" :value="answer.answer">
                                                                                    <input type="hidden" name="answerRate" :value="answer.returnValue">
                                                                                    <input type="hidden" name="matchId" :value="mlVal.id">
                                                                                    <input type="hidden" name="tournament" :value="mlVal.tournament">
                                                                                <div class="input-group mb-3 row">
                                                                                    <input required type="number" id="betAmount" class="form-control col-4" placeholder="0" name="betAmount" v-model="betAmount" :min="val.SD.minBet" :max="val.SD.maxBet">
                                                                                    <span class="input-group-text col-8">Est. Return {{ (betAmount*answer.returnValue).toFixed(2)}}</span>
                                                                                </div>
                                                                            </ul>
                                                                            <div class="p-2">
                                                                                <div class="d-grid gap-2">
                                                                                    <button type="submit" class="btn btn-dark btn-sm btn-fluid fw-bold" :onclick="'scqSubmit('+cqVal.id+aindex+')'" style="font-size:1.2rem">Place Bet</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div v-else>
                                                                        <ul>
                                                                            <li class="fw-bold text-danger text-center">Sorry! No bets available</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <ul>
                                                                        <li class="fw-bold text-danger text-center">Please login to continue</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- FQ Modal End -->
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    </section>
                                <section v-else class="text-center">
                                </section>
                            </div>
                        <!-- Fixed Question End -->                    
                        <!-- Match Option End -->
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                betData: [],
                catData: [],
                unPublish:false,
                betAmount:"",
                counter: 0,
                broadcastId:'all',
            }
        },
        mounted() {
            this.fetchLeaderboard();
            this.listenForChanges();
        },
        methods: {
            BindClass: function (id){
                if(id == 'NULL')
                {
                    return "tab-pane fade show active mb-4";
                }else{
                    return "tab-pane fade mb-4";
                }
            },
            BindBtnClass: function (id){
                if(id == 'NULL')
                {
                    return "nav-link active";
                }else{
                    return "nav-link";
                }
            },
            fetchLeaderboard() 
            {
                if(this.broadcastId=='all'){
                    axios.get(`/broadcast/${this.broadcastId}`).then((response) => {
                        this.catData = response.data;
                        this.betData = response.data;
                    })
                }
            },
           listenForChanges() {
                window.Echo.channel('bettingboard').listen(".BetUpdated", response => {
                   if(response.type == 'matchFinish'){
                       this.betData.forEach((val) => {
                            val.matchList.forEach((mlVal, mlKey) => {
                                if (mlVal.id == response.matchID) {
                                    val.matchList.splice(mlKey, 1);
                                }
                            });
                        });
                   }else if(response.type == 'matchPublish'){
                        axios.get(`matchStatusLeader/${response.matchId}/${response.tournamentId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                if(val.id==response.data.category) {
                                    this.publishMatch(response.data);
                                    val.matchList.forEach((mlVal, mlKey) => {
                                        if (mlVal.id == parseInt(response.data.matchId)) {
                                            this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                            this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                        }
                                    });
                                }
                            });
                        })
                    }else if(response.type == 'matchUnPublish'){
                        axios.get(`matchStatusLeader/${response.matchId}/${response.tournamentId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                if(val.id==response.data.category) {
                                    val.matchList.forEach((mlVal, mlKey) => {
                                        if (mlVal.id == response.data.matchId) {
                                            val.matchList.splice(mlKey, 1);
                                        }
                                    });
                                }
                            });  
                        })
                    }else if(response.type == 'AllBetHideShow'){
                        axios.get(`allBetHideShowStatusLeader/${response.matchId}/${response.tournamentId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                        this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                    }
                                });
                            });
                        })
                    }else if(response.type == 'AllBetOnOff'){
                        axios.get(`allBetOnOffStatusLeader/${response.matchId}/${response.tournamentId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                        this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                    }
                                });
                            });
                        })
                    }else if(response.type == 'liveBetOnOff'){
                        axios.get(`liveBetOnOffStatusLeader/${response.matchId}/${response.tournamentId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                        this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                    }
                                });
                            });
                        });
                    }else if(response.type == 'matchPublishUnpublish'){
                        axios.get(`matchStatusLeader/${response.matchId}/${response.tournamentId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                        this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                    }else{
                                        val.matchList.splice(mlKey, 1);
                                    }
                                });
                            });
                        })
                    }else if(response.type == 'fqTurnOnOff'){
                        this.betData.forEach((val, index) => {
                            val.matchList.forEach((mlVal, mlKey) => {
                                if (mlVal.id == parseInt(response.matchId)) {
                                    mlVal.fixedQuestion.forEach((fqVal, fqKey) => {
                                        if (fqVal.id == response.fqId) {
                                            this.betData[index].matchList[mlKey].fixedQuestion[fqKey].status = response.status;
                                        }
                                    });
                                }
                            });
                        });
                    }else if(response.type == 'fqHideShow'){
                        axios.get(`fqHideShowLeader/${response.tournamentId}/${response.matchId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                    }
                                });
                            });
                        });
                    }else if(response.type == 'cqTurnOnOff'){
                        this.betData.forEach((val, index) => {
                            val.matchList.forEach((mlVal, mlKey) => {
                                if (mlVal.id == parseInt(response.matchId)) {
                                    mlVal.customQuestion.forEach((cqVal, cqKey) => {
                                        if (cqVal.id == response.cqId) {
                                            this.betData[index].matchList[mlKey].customQuestion[cqKey].status = response.status;
                                        }
                                    });
                                }
                            });
                        });
                    }else if(response.type == 'cqHideShow'){
                        axios.get(`cqHideShowLeader/${response.tournamentId}/${response.matchId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                    }
                                });
                            });
                        });
                    }else if(response.type == 'cqUpdate'){
                        axios.get(`cqUpdateLeader/${response.cqId}/${response.tournamentId}/${response.matchId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].customQuestion = response.data.cq;
                                    }
                                });
                            });
                        });
                    }else if(response.type == 'fqUpdate'){
                        axios.get(`fqUpdateLeader/${response.fqId}/${response.tournamentId}/${response.matchId}`).then((response) => {
                            this.betData.forEach((val, index) => {
                                val.matchList.forEach((mlVal, mlKey) => {
                                    if (mlVal.id == parseInt(response.data.matchId)) {
                                        this.betData[index].matchList[mlKey].fixedQuestion = response.data.fq;
                                    }
                                });
                            });
                        });
                    }
                        
                });
            },
            publishMatch(matchPublishData){
                this.betData.forEach((val) => {
                    if (val.id == matchPublishData.category) {
                        var hasinArray = this.findObjectByKey(val.matchList,'id',parseInt(matchPublishData.matchId));
                        if(hasinArray){
                            this.unPublishMatch(matchPublishData);
                        }else{
                            val.matchList.push(matchPublishData.match)
                        }
                    }
                });
            },
            findObjectByKey(array, key, value) {
                //console.log(array.length)
                for (var i = 0; i < array.length; i++) {
                    if (array[i][key] === value) {
                        return true;
                    }
                }
            },
			
            unPublishMatch(matchUnPublishData){
                this.betData.forEach((val) => {
                    val.matchList.forEach((mlVal, mlKey) => {
                        if (mlVal.id == matchUnPublishData.matchId) {
                            val.matchList.splice(mlKey, 1);
                            val.matchList.push(matchUnPublishData.match)
                        }
                    });
                });
                this.singleData.forEach((val) => {
                    val.matchList.forEach((mlVal, mlKey) => {
                        if (mlVal.id == matchUnPublishData.matchId) {
                            val.matchList.splice(mlKey, 1);
                            val.matchList.push(matchUnPublishData.match)
                        }
                    });
                });
            }            
        },
        computed: {
                        
        }
    }
</script>