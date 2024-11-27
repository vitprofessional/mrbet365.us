@extends('admin.include')
@section('admincontent')

                <div class="container-fluid">
                    @include('admin.pagetitle')
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12 col-lg-6 mx-auto">
                            <div class="card card-default shadow">
                                <div class="card-header">
                                    <h4 class="card-title">Server Configuration</h4>
                                    <p class="text-muted mb-0">Manger server by this configuration
                                    </p>
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <form class="form" method="Post" action="{{ route('saveConfig') }}">
                                        {{ csrf_field() }}
                                        @php
                                            if(count($sitedetails)>0):
                                                foreach($sitedetails as $sc):
                                                    $configID           = $sc->id;
                                                    $siteNotice         = $sc->siteNotice;
                                                    $depositMessage     = $sc->depositMessage;
                                                    $minBet             = $sc->minBet;
                                                    $minWithdraw        = $sc->minWithdraw;
                                                    $minClubWitdraw     = $sc->minClubWitdraw;
                                                    $maxClubWitdraw     = $sc->maxClubWitdraw;
                                                    $minDeposit         = $sc->minDeposit;
                                                    $minCoinTransfer    = $sc->minCoinTransfer;
                                                    $maxBet             = $sc->maxBet;
                                                    $maxWithdraw        = $sc->maxWithdraw;
                                                    $maxDeposit         = $sc->maxDeposit;
                                                    $maxCoinTransfer    = $sc->maxCoinTransfer;
                                                    $clubRate           = $sc->clubRate;
                                                    $sponsorRate        = $sc->sponsorRate;
                                                    $partialOne         = $sc->partialOne;
                                                    $partialTwo         = $sc->partialTwo;
                                                    $coinTransferStatus = $sc->coinTransferStatus;
                                                    $userBetStatus      = $sc->userBetStatus;
                                                    $withdrawalStatus = $sc->userWithdrawStatus;
                                                    $depositStatus = $sc->userDepositStatus;
                                                    $clubWithdrawStatus = $sc->clubWithdrawStatus;
                                                    $overBet            = $sc->overBet;
                                                    $underBet           = $sc->underBet;
                                                endforeach;
                                            else:
                                                $configID           = ""; 
                                                $siteNotice         = "";
                                                $depositMessage     = "";
                                                $minBet             = "";      
                                                $minWithdraw        = "";  
                                                $minClubWitdraw     = "";
                                                $maxClubWitdraw     = "";
                                                $minDeposit         = "";
                                                $minCoinTransfer    = "";
                                                $maxBet             = "";
                                                $maxWithdraw        = "";
                                                $maxDeposit         = "";
                                                $maxCoinTransfer    = "";
                                                $clubRate           = "";               $sponsorRate        = ""; 
                                                $partialOne         = "";   
                                                $partialTwo         = "";
                                                $coinTransferStatus = "";
                                                $userBetStatus      = "";               $withdrawalStatus   = "";               $depositStatus      = "";
                                                $clubWithdrawStatus = "";
                                                $overBet            = ""; 
                                                $underBet           = "";                 
                                            endif;
                                        @endphp
                                        @if(!empty($configID))
                                            <input type="hidden" name="configID" value="{{ $configID }}">
                                        @endif
                                        <div class="form-group pb-2">
                                            <label for="siteNotice">Server Notice</label>
                                            <textarea name="siteNotice" class="form-control border-dark" placeholder="Enter site notice" required>{{ $siteNotice }}</textarea>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="depoMessage">Deposit Message</label>
                                            <input type="text" name="depositMessage" class="form-control border-dark" placeholder="Deposit message to show in dashboard" value="{{ $depositMessage }}" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="minBet">Minimum User Bet</label>
                                            <input type="number" name="minBet" class="form-control border-dark" placeholder="Enter the minimum value of betting amount" value="{{ $minBet }}" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="maxBet">Maximum User Bet</label>
                                            <input type="number" name="maxBet" class="form-control border-dark" value="{{ $maxBet }}" placeholder="Enter the maximum value of betting amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="minDeposit">Minimum User Deposit</label>
                                            <input type="number" name="minDeposit" class="form-control border-dark" value="{{ $minDeposit }}" placeholder="Enter the minimum value of deposit amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="maxDeposit">Maximum User Deposit</label>
                                            <input type="number" name="maxDeposit" class="form-control border-dark" value="{{ $maxDeposit }}" placeholder="Enter the maximum value of deposit amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="minWithdraw">Minimum User Withdraw</label>
                                            <input type="number" name="minWithdraw" class="form-control border-dark" value="{{ $minWithdraw }}" placeholder="Enter the minimum value of withdrawal amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="maxWithdraw">Maximum User Withdraw</label>
                                            <input type="number" name="maxWithdraw" class="form-control border-dark" value="{{ $maxWithdraw }}" placeholder="Enter the maximum value of withdrawal amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="minClubWitdraw">Minimum Club Withdraw</label>
                                            <input type="number" name="minClubWitdraw" class="form-control border-dark" value="{{ $minClubWitdraw }}" placeholder="Enter the minimum value of club withdrawal amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="maxClubWitdraw">Maximum Club Withdraw</label>
                                            <input type="number" name="maxClubWitdraw" class="form-control border-dark" value="{{ $maxClubWitdraw }}" placeholder="Enter the maximum value of club withdrawal amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="clubRate">Club Bonus</label>
                                            <input type="number" step="any" name="clubRate" class="form-control border-dark" value="{{ $clubRate }}" placeholder="Enter percentage value of club member" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="sponsorRate">Sponsor Bonus</label>
                                            <input type="number" step="any" name="sponsorRate" class="form-control border-dark" value="{{ $sponsorRate }}" placeholder="Enter percentage value of sponsor" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="partialOne">Partial One</label>
                                            <input type="text" name="partialOne" class="form-control border-dark" value="{{ $partialOne }}" placeholder="Enter the value of pertial one" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="partialTwo">Partial Two</label>
                                            <input type="text" name="partialTwo" class="form-control border-dark" value="{{ $partialTwo }}" placeholder="Enter the value of pertial two" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="ctSts">Coin Transfer Status</label>
                                            <select name="coinTransferStatus" class="form-control border-dark" required>
                                                @if(!empty($coinTransferStatus))
                                                    @if($coinTransferStatus==1)
                                                        <option value="1">On</option>
                                                    @elseif($coinTransferStatus==2)
                                                        <option value="2">Off</option>
                                                    @else
                                                        <option value="">-</option>    
                                                    @endif
                                                @endif
                                                <option value="1">On</option>
                                                <option value="2">Off</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="minCoinTransfer">Minimum Coin Transfer</label>
                                            <input type="number" name="minCoinTransfer" class="form-control border-dark" value="{{ $minCoinTransfer }}" placeholder="Enter the minimum value of coin transfer" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="maxCoinTransfer">Maximum Coin Transfer</label>
                                            <input type="number" name="maxCoinTransfer" class="form-control border-dark" value="{{ $maxCoinTransfer }}" placeholder="Enter the maximum value of coin transfer" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="clubWithdrawStatus">Club Withdrawal Status</label>
                                            <select name="clubWithdrawStatus" class="form-control border-dark" required>
                                                @if(!empty($clubWithdrawStatus))
                                                    @if($clubWithdrawStatus==1)
                                                        <option value="1">On</option>
                                                    @elseif($clubWithdrawStatus==2)
                                                        <option value="2">Off</option>
                                                    @else
                                                        <option value="">-</option>    
                                                    @endif
                                                @endif
                                                <option value="1">On</option>
                                                <option value="2">Off</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="userBetStatus">User Bets Status</label>
                                            <select name="userBetStatus" class="form-control border-dark" required>
                                                @if(!empty($userBetStatus))
                                                    @if($userBetStatus==1)
                                                        <option value="1">On</option>
                                                    @elseif($userBetStatus==2)
                                                        <option value="2">Off</option>
                                                    @else
                                                        <option value="">-</option>    
                                                    @endif
                                                @endif
                                                <option value="1">On</option>
                                                <option value="2">Off</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="withdrawalStatus">Withdrawal Status</label>
                                            <select name="withdrawalStatus" class="form-control border-dark" required>
                                                @if(!empty($withdrawalStatus))
                                                    @if($withdrawalStatus==1)
                                                        <option value="1">On</option>
                                                    @elseif($withdrawalStatus==2)
                                                        <option value="2">Off</option>
                                                    @else
                                                        <option value="">-</option>    
                                                    @endif
                                                @endif
                                                <option value="1">On</option>
                                                <option value="2">Off</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="depositStatus">Deposit Status</label>
                                            <select name="depositStatus" class="form-control border-dark" required>
                                                @if(!empty($depositStatus))
                                                    @if($depositStatus==1)
                                                        <option value="1">On</option>
                                                    @elseif($depositStatus==2)
                                                        <option value="2">Off</option>
                                                    @else
                                                        <option value="">-</option>    
                                                    @endif
                                                @endif
                                                <option value="1">On</option>
                                                <option value="2">Off</option>
                                            </select>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="overBet">Over Bet</label>
                                            <input type="number" value="{{ $overBet }}" name="overBet" class="form-control border-dark" placeholder="Enter the value of over bet amount" required>
                                        </div>
                                        <div class="form-group pb-2">
                                            <label for="underBet">Under Bet</label>
                                            <input type="number" value="{{ $underBet }}" name="underBet" class="form-control border-dark" placeholder="Enter the value of under bet amount" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Save Change">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div><!-- container -->
@endsection