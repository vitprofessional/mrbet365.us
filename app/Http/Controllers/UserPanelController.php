<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BetUser;
use App\Models\BettingClub;
use App\Models\BetUserStatement;
use App\Models\ClubStatement;
use App\Models\Deposit;
use App\Models\WithdrawalRequest;
use App\Models\FixedQuestion;
use App\Models\MatchQuestion;
use App\Models\MatchAnswer;
use App\Models\CoinTransfer;
use App\Models\SiteConfig;
use App\Models\UserBet;
use App\Models\Matche;
use App\Models\Team;
use Session;
use Hash;
use Carbon\Carbon;

class UserPanelController extends Controller
{
    public function __construct(){
        $this->middleware('betuser');
    }
    
    public function countRequest(Request $requ){
        
    }
    
    public function fqBetPlace(Request $requ){
        $config = SiteConfig::first();
		
		$minMaxError = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		Can not possible to place bet less '.$config->minBet.' & max '.$config->maxBet.'</div>';
		$balanceError = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		You have insufficient balance to place bet. Please recharge your account to continue
		</div>';
		$errorBetTime = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		You need at least 7 seconds between to place 2nd bet
		</div>';
		$successMessage = '<div class="alert alert-success" id="message-alert">
		<button type="button" class="btn btn-success btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Success!</strong>
		Your bet successfully placed!
		</div>';
		$errorMessage = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		Failed to placed your bet. Please try later
		</div>';
		$statusError = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		No bet available right now.
		</div>';
		$matchError = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		Bet is not available to this match.
		</div>';
		$profileStatus = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		You are not allowed to place any bet, please contact support.
		</div>';
		$loginError = '<div class="alert alert-warning" id="message-alert">
		<button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
		<strong>Sorry!</strong>
		Please login first.
		</div>';
        #User login check
        $user = BetUser::find(Session::get('betuser'));

        #Only web user can bet
        if(empty($user)) {
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $loginError), 200);
        }

        #Check when this user last bet.
        $betPlace = UserBet::where([
            "user" => $user->id,
            "matchId" => trim(strip_tags($requ->matchId)),
            "tournament" => trim(strip_tags($requ->tournament)),
        ])->orderBy('created_at', 'desc')->first();

        if(!empty($betPlace)){
            $now = Carbon::now();
            $diff_in_second = $now->diffInSeconds($betPlace->created_at);
            if($diff_in_second < 10){
				return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorBetTime), 200);
            }
        }

        #User Balance Check
        $userTotalBalance = $user->balance;
        $betAmount        = trim(strip_tags($requ->betAmount));

        if($userTotalBalance < $betAmount){
			return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $balanceError), 200);
        }

        // if($userTotalBalance < 0 || $user->totalRegularDepositAmount < 0 || $user->totalSpecialDepositAmount < 0 || $user->totalCoinReceiveAmount < 0 || $user->totalSponsorAmount < 0 || $user->totalProfitAmount < 0 || $user->totalCoinTransferAmount < 0  || $user->totalLossAmount < 0   || $user->totalWithdrawAmount < 0 ){
        //     return response()->json(['errorMsg'=>'["error : Account problem contact admin."]']);
        // }

        #Check : Is User given betAmount is same as config table minimum bet and maximum bet.
        if(($betAmount < $config->minBet) || ($betAmount > $config->maxBet) ){
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $minMaxError), 200);
        }

        if($config->userBetStatus == 0){
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $statusError), 200);
        }

        #Check This Match Is On Live Or Upcoming .
        #Draft = 0;
        #Onbet/upcoming = 1;
        #Live = 2;
        #Done = 3;

        $match = Matche::where("id",trim(strip_tags($requ->matchId)))->whereIn("status",[1,2,3])->first();
        if(empty($match)){
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $matchError), 200);
        }

        #Check : Is User bet action right bet option which is for live or upcoming match bet option.
		
        $betDetail = FixedQuestion::where([
            "quesId" => $requ->answerId,
            "matchId" => $requ->matchId,
            "tournament" => $requ->tournament,
            "status" => 1,
        ])->first();

        if(empty($betDetail)){
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $statusError), 200);
        }

        try {
            $matchData  = Matche::find($requ->matchId);
            $tournament = $matchData->tournament;
			$teamName   = Team::where(['catId'=>$betDetail->catId,'team'=>$requ->answer])->first();
			$teamAvalue = Matche::where(['id'=>$matchData->id,'teamA'=>$teamName->id,'status'=>1])->first();
			$teamBvalue = Matche::where(['id'=>$matchData->id,'teamB'=>$teamName->id,'status'=>1])->first();
			if(count($teamAvalue)>0):
				$returnValue = $betDetail->teamA;
			elseif(count($teamBvalue)>0):
				$returnValue = $betDetail->teamB;
			elseif($requ->answer=='draw'):
				$returnValue = $betDetail->draw;
			else:
				return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $statusError), 200);
			endif;
			if($requ->answerRate != $returnValue):
				$betChangeAlert = "<div class='alert alert-warning' id='message-alert'>
				<button type='button' class='btn btn-warning btn-sm fw-bold close' data-dismiss='alert'>x</button>
					<strong>Sorry!</strong> 
					Answer rate change to ".$returnValue." and you will get return ".$requ->betAmount*$returnValue." Place your bet again if you are agree</div>";
				return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $betChangeAlert), 200);
			endif;
				
			
			
			$userNewBalance         = $user->balance;
			$userUpdateBalance      = $userNewBalance-$requ->betAmount;
			$user->balance       	= $userUpdateBalance;
			$user->update();
            
			$betData    = new UserBet();	
			$returnAmount           = $requ->betAmount*$returnValue;
			$betData->user          = $user->id;
			$betData->betOn         = "FQ";
			$betData->betOption     = $requ->answerId;
			$betData->betAnswer     = $requ->answer;
			$betData->matchId       = $requ->matchId;
			$betData->tournament    = $tournament;
			$betData->betAmount     = $requ->betAmount;
			$betData->sponsor       = $sponsorAmount;
			$betData->club          = $clubAmount;
			$betData->returnAmount  = $returnAmount;
			$betData->betRate       = $returnValue;
			$betData->status        = 1;
			$betData->save();
			$currentBalance = $userNewBalance;
			//Bet user profile update
			//Update user statement
			$statement   = BetUserStatement::where(['user'=>$user->id])->first();
			if(!empty($statement)):
				$stmtBal    = $statement->currentBalance;
			else:
				$stmtBal    = $user->balance;
			endif;
			//Create statement
			$statement= new BetUserStatement();
			$statement->user  = $user->id;
			//$statement = BetUserStatement::find($statement->id);
			$statement->prevBalance  = $stmtBal;
			$statement->currentBalance  = $userUpdateBalance;
			$statement->transAmount  = $requ->betAmount;
			$statement->note   = "PlaceBet";
			$statement->transType   = "Debit";
			$statement->save();
			//end statement
			
			//Sponsor data
			$sponsor = $user->sponsor;
			$sponsorBonus   = $config->sponsorRate;
			$sponsorAmount  = ($sponsorBonus/100)*$requ->betAmount;
			//Sponsor balance update
			if(!empty($sponsor)):
				$sponsorProfile = BetUser::where(['userid'=>$sponsor])->first();
				
				//Sponsor balance update
				if(!empty($sponsorProfile)):
					$spBal  = $sponsorProfile->balance;
					$spNewBal   = $spBal+$sponsorAmount;
					$sponsorProfile->balance = $spNewBal;
					//sponsor statement update 
					$spStatement    = BetUserStatement::where(['user'=>$sponsorProfile->id])->first();
					if(!empty($spStatement)):
						$spStmtBal    = $spStatement->currentBalance;
					else:
						$spStmtBal    = $spBal;
					endif;
					//Create statement
					$spStatement= new BetUserStatement();
					$spStatement->user  = $sponsorProfile->id;
					//$statement = BetUserStatement::find($statement->id);
					$spStatement->prevBalance  = $spStmtBal;
					$spStatement->currentBalance  = $spNewBal;
					$spStatement->transAmount  = $sponsorAmount;
					$spStatement->note   = "SponsorBonus";
					$spStatement->transType   = "Credit";
					//Sponsor statement and profile update
					$spStatement->save();
					$sponsorProfile->update();
				endif;
			endif;
			
			
			//Club data
			$club = $user->club;
			$clubBonus   = $config->clubRate;
			$clubAmount  = ($clubBonus/100)*$requ->betAmount;
			//Club balance update
			$clubProfile = BettingClub::where(['clubid'=>$club])->first();
			if(!empty($clubProfile)):
				$clubBal  = $clubProfile->balance;
				$clubNewBal   = $clubBal+$clubAmount;
				$clubProfile->balance = $clubNewBal;
				//sponsor statement update 
				$clubStatement    = ClubStatement::where(['club'=>$clubProfile->id])->first();
				if(!empty($clubStatement)):
					$clbBal    = $clubStatement->currentBalance;
				else:
					$clbBal    = $clubBal;
				endif;
				//Create statement
				$clubStatement= new ClubStatement();
				$clubStatement->club  = $clubProfile->id;
				//$statement = BetUserStatement::find($statement->id);
				$clubStatement->prevBalance  = $clbBal;
				$clubStatement->currentBalance  = $clubNewBal;
				$clubStatement->transAmount  = $clubAmount;
				$clubStatement->note   = "ClubBonus";
				$clubStatement->generateBy   = $user->userid;
				$clubStatement->transType   = "Credit";
				//Club statement and profile update
				$clubStatement->save();
				$clubProfile->save();
			endif;
			return response()->json(array('currBalance'=> $userUpdateBalance,'fieldIndex'=>$requ->fieldIndex,'message'=>$successMessage), 200);

        }catch (Exception $e){
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorMessage), 200);
        }
    }
    
    //Place fixed queston bet
    public function oldfqBetPlace(Request $requ){
        
        // return count($requ->matchId);
        
        $sd    = SiteConfig::first();
        $minMaxError = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        Can not possible to place bet less '.$sd->minBet.' & max '.$sd->maxBet.'</div>';
        $balanceError = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        You have insufficient balance to place bet. Please recharge your account to continue
     </div>';
        $errorBetTime = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        You need at least 7 seconds between to place 2nd bet
     </div>';
        $successMessage = '<div class="alert alert-success" id="message-alert">
        <button type="button" class="btn btn-success btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Success!</strong>
        Your bet successfully placed!
     </div>';
        $errorMessage = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        Failed to placed your bet. Please try later
     </div>';
        $statusError = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        Bet is not available now.
    </div>';
        $profileStatus = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        You are not allowed to place any bet when your profile has been banned.
    </div>';
        //return diffForHumans();
        $statusChk = FixedQuestion::where(['quesId'=>$requ->answerId,'matchId'=>$requ->matchId,'tournament'=>$requ->tournament])->latest()->first();
            $chkTime = UserBet::where(['user'=>$requ->userId])->latest()->first();
            $time1 = strtotime($chkTime->created_at)+7;
            $time2 = time();
        if($time2<=$time1):
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorBetTime), 200);
        elseif($statusChk->status == 1):
            $profile    = BetUser::find(Session::get('betuser'));
            $userBalance = $profile->balance;
            
            
            $matchData  = Matche::find($requ->matchId);
            $tournament = $matchData->tournament;
            //Sponsor data
            $sponsor = $profile->sponsor;
            $sponsorBonus   = $sd->sponsorRate;
            $sponsorAmount  = ($sponsorBonus/100)*$requ->betAmount;
            
            //Club data
            $club = $profile->club;
            $clubBonus   = $sd->clubRate;
            $clubAmount  = ($clubBonus/100)*$requ->betAmount;
            
            if($requ->betAmount>$sd->maxBet || $requ->betAmount<$sd->minBet):
                return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $minMaxError), 200);
            elseif($requ->betAmount>$userBalance):
                return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $balanceError), 200);
            elseif($profile->status==4):
                return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $profileStatus), 200);
            else:
                $betData    = new UserBet();
                $teamName   = Team::where(['catId'=>$statusChk->catId,'team'=>$requ->answer])->first();
                $teamAvalue = Matche::where(['id'=>$matchData->id,'teamA'=>$teamName->id,'status'=>1])->first();
                $teamBvalue = Matche::where(['id'=>$matchData->id,'teamB'=>$teamName->id,'status'=>1])->first();
                if(count($teamAvalue)>0):
                    $returnValue = $statusChk->teamA;
                elseif(count($teamBvalue)>0):
                    $returnValue = $statusChk->teamB;
                elseif($requ->answer=='draw'):
                    $returnValue = $statusChk->draw;
                else:
                    return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $statusError), 200);
                endif;
                if($requ->answerRate != $returnValue):
                    $betChangeAlert = "<div class='alert alert-warning' id='message-alert'>
                    <button type='button' class='btn btn-warning btn-sm fw-bold close' data-dismiss='alert'>x</button>
                        <strong>Sorry!</strong> 
                        Answer rate change to ".$returnValue." and you will get return ".$requ->betAmount*$returnValue." Place your bet again if you are agree</div>";
                    return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $betChangeAlert), 200);
                endif;
                    
                    
                $returnAmount           = $requ->betAmount*$returnValue;
                $betData->user          = $profile->id;
                $betData->betOn         = "FQ";
                $betData->betOption     = $requ->answerId;
                $betData->betAnswer     = $requ->answer;
                $betData->matchId       = $requ->matchId;
                $betData->tournament    = $tournament;
                $betData->betAmount     = $requ->betAmount;
                $betData->sponsor       = $sponsorAmount;
                $betData->club          = $clubAmount;
                $betData->returnAmount  = $returnAmount;
                $betData->betRate       = $returnValue;
                $betData->status        = 1;
                
                $userNewBalance         = $profile->balance;
                $userUpdateBalance      = $userNewBalance-$requ->betAmount;
                $profile->balance       = $userUpdateBalance;
                $profile->save();
                
                $profile    = BetUser::find(Session::get('betuser'));
                $currentBalance = $profile->balance;
                    
                $dateNow = date('Y-m-d H:i:s');
                $existBet = UserBet::where(['user'=>$requ->userId,'created_at'=>$dateNow])->get();
                if(count($existBet)>0):
                    return response()->json(array('currBalance'=> $currentBalance,'fieldIndex'=>$requ->fieldIndex,'message'=>$errorBetTime), 200);
                endif;
                //Bet user profile update
                if($betData->save()):
                    //Update user statement
                    $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                    if(count($statement)>0):
                        $stmtBal    = $statement->currentBalance;
                    else:
                        $stmtBal    = $profile->balance;
                    endif;
                    //Create statement
                    $statement= new BetUserStatement();
                    $statement->user  = $profile->id;
                    //$statement = BetUserStatement::find($statement->id);
                    $statement->prevBalance  = $stmtBal;
                    $statement->currentBalance  = $userUpdateBalance;
                    $statement->transAmount  = $requ->betAmount;
                    $statement->note   = "PlaceBet";
                    $statement->transType   = "Debit";
                    $statement->save();
                    //end statement
                    
                    //Sponsor data
                    $sponsor = $profile->sponsor;
                    $sponsorBonus   = $sd->sponsorRate;
                    $sponsorAmount  = ($sponsorBonus/100)*$requ->betAmount;
                    //Sponsor balance update
                    if(!empty($sponsor)):
                        $sponsorProfile = BetUser::where(['userid'=>$sponsor])->get()->last();
                        
                        //Sponsor balance update
                        if(count($sponsorProfile)>0):
                            $spBal  = $sponsorProfile->balance;
                            $spNewBal   = $spBal+$sponsorAmount;
                            $sponsorProfile->balance = $spNewBal;
                            //sponsor statement update 
                            $spStatement    = BetUserStatement::where(['user'=>$sponsorProfile->id])->get()->last();
                            if(count($spStatement)>0):
                                $spStmtBal    = $spStatement->currentBalance;
                            else:
                                $spStmtBal    = $spBal;
                            endif;
                            //Create statement
                            $spStatement= new BetUserStatement();
                            $spStatement->user  = $sponsorProfile->id;
                            //$statement = BetUserStatement::find($statement->id);
                            $spStatement->prevBalance  = $spStmtBal;
                            $spStatement->currentBalance  = $spNewBal;
                            $spStatement->transAmount  = $sponsorAmount;
                            $spStatement->note   = "SponsorBonus";
                            $spStatement->transType   = "Credit";
                            //Sponsor statement and profile update
                            $spStatement->save();
                            $sponsorProfile->save();
                        endif;
                    endif;
                    
                    
                    //Club data
                    $club = $profile->club;
                    $clubBonus   = $sd->clubRate;
                    $clubAmount  = ($clubBonus/100)*$requ->betAmount;
                    //Club balance update
                    $clubProfile = BettingClub::where(['clubid'=>$club])->get()->last();
                    if(count($clubProfile)>0):
                        $clubBal  = $clubProfile->balance;
                        $clubNewBal   = $clubBal+$clubAmount;
                        $clubProfile->balance = $clubNewBal;
                        //sponsor statement update 
                        $clubStatement    = ClubStatement::where(['club'=>$clubProfile->id])->get()->last();
                        if(count($clubStatement)>0):
                            $clbBal    = $clubStatement->currentBalance;
                        else:
                            $clbBal    = $clubBal;
                        endif;
                        //Create statement
                        $clubStatement= new ClubStatement();
                        $clubStatement->club  = $clubProfile->id;
                        //$statement = BetUserStatement::find($statement->id);
                        $clubStatement->prevBalance  = $clbBal;
                        $clubStatement->currentBalance  = $clubNewBal;
                        $clubStatement->transAmount  = $clubAmount;
                        $clubStatement->note   = "ClubBonus";
                        $clubStatement->generateBy   = $profile->userid;
                        $clubStatement->transType   = "Credit";
                        //Club statement and profile update
                        $clubStatement->save();
                        $clubProfile->save();
                    endif;
                    return response()->json(array('currBalance'=> $currentBalance,'fieldIndex'=>$requ->fieldIndex,'message'=>$successMessage), 200);
                else:
                    return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorMessage), 200);
                endif;
            endif;
        else:
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $profileStatus), 200);
        endif;
    }

    
    //Place custom queston bet
    public function cqBetPlace(Request $requ){
        $sd    = SiteConfig::first();
        $minMaxError = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        Can not possible to place bet less '.$sd->minBet.' & max '.$sd->maxBet.'</div>';
        $balanceError = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        You have insufficient balance to place bet. Please recharge your account to continue
     </div>';
        $successMessage = '<div class="alert alert-success" id="message-alert">
        <button type="button" class="btn btn-success btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Success!</strong>
        Your bet successfully placed!
     </div>';
        $errorMessage = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        Failed to placed your bet. Please try later
     </div>';
        $errorBetTime = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        You need at least 7 seconds between to place 2nd bet
     </div>';
     $statusError = '<div class="alert alert-warning" id="message-alert">
     <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
     <strong>Sorry!</strong>
     Already stop for bet. Please try later
 </div>';
        $profileStatus = '<div class="alert alert-warning" id="message-alert">
        <button type="button" class="btn btn-warning btn-sm fw-bold close" data-dismiss="alert">x</button>
        <strong>Sorry!</strong>
        You are not allowed to place any bet when your profile has been banned.
    </div>';
    
        $statusChk = MatchQuestion::find($requ->quesId);
        if($statusChk->status == 1):
            $profile    = BetUser::find(Session::get('betuser'));
            $userBalance = $profile->balance;
            
            $matchData  = Matche::find($requ->matchId);
            $tournament = $matchData->tournament;
            //Sponsor data
            $sponsor = $profile->sponsor;
            $sponsorBonus   = $sd->sponsorRate;
            $sponsorAmount  = ($sponsorBonus/100)*$requ->betAmount;
            
            //Club data
            $club = $profile->club;
            $clubBonus   = $sd->clubRate;
            $clubAmount  = ($clubBonus/100)*$requ->betAmount;
            
            if($requ->betAmount>$sd->maxBet || $requ->betAmount<$sd->minBet):
                return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $minMaxError), 200);
            elseif($requ->betAmount>$userBalance):
                return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $balanceError), 200);
            elseif($profile->status==4):
                return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $profileStatus), 200);
            else:
                
                $betData    = new UserBet();
                
                $rateTable = MatchAnswer::where(['quesId'=>$requ->quesId,'answer'=>$requ->answer])->first();
                if(count($rateTable)>0):
                    $answerRate = $rateTable->returnValue;
                else:
                    return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $statusError), 200);
                endif;
                
                $returnAmount           = $requ->betAmount*$answerRate;
                if($requ->answerRate != $answerRate):
                    $betChangeAlert = "<div class='alert alert-warning' id='message-alert'>
                    <button type='button' class='btn btn-warning btn-sm fw-bold close' data-dismiss='alert'>x</button>
                        <strong>Sorry!</strong> 
                        Answer rate change to ".$answerRate." and you will get return ".$returnAmount." Place your bet again if you are agree</div>";
                    return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $betChangeAlert), 200);
                endif;
                
                $betData->user          = $profile->id;
                $betData->betOn         = "CQ";
                $betData->betOption     = $requ->answerId;
                $betData->betAnswer     = $requ->answer;
                $betData->betAmount     = $requ->betAmount;
                $betData->returnAmount  = $returnAmount;
                $betData->matchId       = $requ->matchId;
                $betData->tournament    = $tournament;
                $betData->betRate       = $answerRate;
                $betData->sponsor       = $sponsorAmount;
                $betData->club          = $clubAmount;
                $betData->status        = 1;
                $chkTime = UserBet::where(['user'=>$requ->userId])->latest()->first();
                $time1 = strtotime($chkTime->created_at)+7;
                $time2 = time();
                //return diffForHumans();
                // return $requ->answerId;
                if($time2<=$time1):
                    return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorBetTime), 200);
                else:
                    $userUpdateBalance  = $userBalance-$requ->betAmount;
                    $profile->balance   = $userUpdateBalance;
                    $profile->save();
                    
                    if($betData->save()):
                        if($time2<=$time1):
                            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorBetTime), 200);
                        endif;
                        $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                        if(count($statement)>0):
                            $stmtBal    = $statement->currentBalance;
                        else:
                            $stmtBal    = $userBalance;
                        endif;
                        //Create statement
                        $statement= new BetUserStatement();
                        $statement->user  = $profile->id;
                        //$statement = BetUserStatement::find($statement->id);
                        $statement->prevBalance  = $stmtBal;
                        $statement->currentBalance  = $userUpdateBalance;
                        $statement->transAmount  = $requ->betAmount;
                        $statement->note   = "PlaceBet";
                        $statement->transType   = "Debit";
                        $statement->save();
                        //Statement table end
                        
                        //Sponsor balance update
                        $sponsorProfile = BetUser::where(['userid'=>$sponsor])->get()->last();
                        if(count($sponsorProfile)>0):
                            $spBal  = $sponsorProfile->balance;
                            $spNewBal   = $spBal+$sponsorAmount;
                            $sponsorProfile->balance = $spNewBal;
                            //sponsor statement update 
                            $spStatement    = BetUserStatement::where(['user'=>$sponsorProfile->id])->get()->last();
                            if(count($spStatement)>0):
                                $spStmtBal    = $spStatement->currentBalance;
                            else:
                                $spStmtBal    = $spBal;
                            endif;
                            //Create statement
                            $spStatement= new BetUserStatement();
                            $spStatement->user  = $sponsorProfile->id;
                            //$statement = BetUserStatement::find($statement->id);
                            $spStatement->prevBalance  = $spStmtBal;
                            $spStatement->currentBalance  = $spNewBal;
                            $spStatement->transAmount  = $sponsorAmount;
                            $spStatement->note   = "SponsorBonus";
                            $spStatement->transType   = "Credit";
                            //Sponsor statement and profile update
                            $spStatement->save();
                            $sponsorProfile->save();
                        endif;
                        
                        //Club balance update
                        $clubProfile = BettingClub::where(['clubid'=>$club])->get()->last();
                        if(count($clubProfile)>0):
                            $clubBal  = $clubProfile->balance;
                            $clubNewBal   = $clubBal+$clubAmount;
                            $clubProfile->balance = $clubNewBal;
                            //sponsor statement update 
                            $clubStatement    = ClubStatement::where(['club'=>$clubProfile->id])->get()->last();
                            if(count($clubStatement)>0):
                                $clbBal    = $clubStatement->currentBalance;
                            else:
                                $clbBal    = $clubBal;
                            endif;
                            //Create statement
                            $clubStatement= new ClubStatement();
                            $clubStatement->club  = $clubProfile->id;
                            //$statement = BetUserStatement::find($statement->id);
                            $clubStatement->prevBalance  = $clbBal;
                            $clubStatement->currentBalance  = $clubNewBal;
                            $clubStatement->transAmount  = $clubAmount;
                            $clubStatement->note   = "ClubBonus";
                            $clubStatement->generateBy   = $profile->userid;
                            $clubStatement->transType   = "Credit";
                            //Club statement and profile update
                            $clubStatement->save();
                            $clubProfile->save();
                        endif;
                        $profile    = BetUser::find(Session::get('betuser'));
                        $currentBalance = $profile->balance;
                        return response()->json(array('currBalance'=> $currentBalance,'fieldIndex'=>$requ->fieldIndex,'message'=>$successMessage), 200);
                    else:
                        return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $errorMessage), 200);
                    endif;
                endif;
            endif;
        else:
            return response()->json(array('fieldIndex'=>$requ->fieldIndex,'message'=> $statusError), 200);
        endif;
    }

    //profile update controller
    public function updateMyPass(Request $requ){
        if(empty($requ->oldPassword)):
            return back()->with('error','Please enter your old password');
        else:
            $profile    = BetUser::find(Session::get('betuser'));
            $oldHashpass   = $profile->hashpassword;
            $authuser   = Hash::check($requ->oldPassword,$oldHashpass);
            if($authuser):
                if($requ->newPassword == $requ->confirmPassword):
                    $hashpass   = Hash::make($requ->newPassword);
                    $profile->plainpassword     = $requ->newPassword;
                    $profile->hashpassword      = $hashpass;
                    if($profile->save()):
                        return back()->with('success','Profile updated successful');
                    else:
                        return back()->with('error','Profile updated failed');
                    endif;
                else:
                    return back()->with('error','New password not mach with confirm password');
                endif;
            else:
                return back()->with('error','Old password does not mach');
            endif;
        endif;
    }
    
    public function updateMyClub(Request $requ){
        if(empty($requ->club)):
            return back()->with('error','Please select a club to update');
        else:
            $profile    = BetUser::find(Session::get('betuser'));
            $profile->club      = $requ->club;
            if($profile->save()):
                return back()->with('success','Profile updated successful');
            else:
                return back()->with('error','Profile updated failed');
            endif;
        endif;
    }

    //Deposit request controller
    public function depositRequest(Request $requ){
        $sd    = SiteConfig::first();
        if($requ->amount>$sd->maxDeposit || $requ->amount<$sd->minDeposit):
            return back()->with('error','Sorry! Minimum deposit amount '.$sd->minDeposit.' & maximum deposit amount '.$sd->maxDeposit);
        else:
            $profile    = BetUser::find(Session::get('betuser'));
            $existingRequest = Deposit::where(['user'=>$profile->id])->where(function($q) {
                      $q->where(['status'=>'Pending'])->orWhere(['status'=>'Processing']);
                  })->get();
            $hashpass   = $profile->hashpassword;
            $authuser = Hash::check($requ->password,$hashpass);
            //return count($);
            if($profile->status==4):
                return back()->with('error','You are not allowed to deposit or withdraw when your profile has been banned');
            elseif(count($existingRequest)>=2):
                return back()->with('error','You already exist max deposit request. Please wait and try again later.');
            elseif($authuser):
                $deposit    = new Deposit();
                $deposit->user          = $profile->id;
                $deposit->method        = $requ->method;
                $deposit->amount        = $requ->amount;
                $deposit->fromNumber    = $requ->fromNumber;
                $deposit->toNumber      = $requ->toNumber;
                $deposit->status        = "Pending";
                if($deposit->save()):
                    return back()->with('success','Request sent successfully');
                else:
                    return back()->with('error','Request failed to sent');
                endif;
            else:
                return back()->with('error','Wrong password provide');
            endif;
        endif;
    }
    //Withdrawal request controller
    public function withdrawRequest(Request $requ){
        $profile    = BetUser::find(Session::get('betuser'));
        if(count($profile)>0):
            $hashpass   = $profile->hashpassword;
        	$authUser = Hash::check($requ->password,$hashpass);
            if($authUser):
                if($profile->balance<$requ->amount):
                    return back()->with('error','Sorry! You do not have enough balance to withdraw');
                else:
                    $sd    = SiteConfig::first();
                    if($requ->amount>$sd->maxWithdraw || $requ->amount<$sd->minWithdraw):
                        return back()->with('error','Sorry! Minimum withdraw amount '.$sd->minWithdraw.' & maximum withdraw amount '.$sd->maxWithdraw);
                    else:
                        $withdraw    = new WithdrawalRequest();
                            
                        //update Main Balance
                        $newmainbalance = $profile->balance - $requ->amount;
                        $profile->balance = $newmainbalance;
                        
                        if($profile->status==4):
                            return back()->with('error','You are not allowed to deposit or withdraw when your profile has been banned');
                        else:
                            //Update user statement
                            $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                            
                            if(count($statement)>0):
                                $stmtBal    = $statement->currentBalance;
                            else:
                                $stmtBal    = $profile->balance;
                            endif;
                            //Create statement
                            $statement= new BetUserStatement();
                            $statement->user  = $profile->id;
                            //$statement = BetUserStatement::find($statement->id);
                            $statement->prevBalance  = $stmtBal;
                            $statement->currentBalance  = $newmainbalance;
                            $statement->transAmount  = $requ->amount;
                            $statement->note   = "Withdraw";
                            $statement->transType   = "Debit";
                            $statement->save();
                            //Statement table end
            
            
                            $withdraw->user          = $profile->id;
                            $withdraw->paymentType   = $requ->paymentType;
                            $withdraw->amount        = $requ->amount;
                            $withdraw->toNumber      = $requ->toNumber;
                            $withdraw->status        = "Pending";
                            if($profile->save()):
                                $withdraw->save();
                                return back()->with('success','Coin withdrawal request sent successful');
                            else:
                                return back()->with('error','Coin withdrawal request failed to sent');
                            endif;
                        endif;
                    endif;
                endif;
            else:
                return back()->with('error','Sorry! Wrong password provide');
            endif;
        endif;
    }
    //Withdrawal refund controller
    public function refundWithdraw($id){
        $profile    = BetUser::find(Session::get('betuser'));
        if(count($profile)>0):
            $withdraw    = WithdrawalRequest::find($id);
            if($withdraw->status=='Pending'):
                
                //update Main Balance
                $newmainbalance = $profile->balance + $withdraw->amount;
                $profile->balance = $newmainbalance;
                
                //Update user statement
                $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                
                if(count($statement)>0):
                    $stmtBal    = $statement->currentBalance;
                else:
                    $stmtBal    = $profile->balance;
                endif;
                //Create statement
                $statement= new BetUserStatement();
                $statement->user  = $profile->id;
                //$statement = BetUserStatement::find($statement->id);
                $statement->prevBalance  = $stmtBal;
                $statement->currentBalance  = $newmainbalance;
                $statement->transAmount  = $withdraw->amount;
                $statement->note   = "WithdrawRefund";
                $statement->transType   = "Credit";
                $statement->save();
                //Statement table end
                $withdraw->status        = "Refund";
                if($profile->save()):
                    $withdraw->save();
                    return back()->with('success','Refund successfully complete');
                else:
                    return back()->with('error','Refund failed to complete');
                endif;
            else:
                return back()->with('error','Sorry! Withdrawal already in process');
            endif;
        else:
            return back()->with('error','Sorry! No user found');
        endif;
    }
    //C2C Transfer request controller
    public function C2CTransferRequest(Request $requ){
        $profile    = BetUser::find(Session::get('betuser'));
        $amount = str_replace("-","",$requ->amount);
        $minMaxChk = SiteConfig::orderBy('id','DESC')->first();
        if($profile->balance<$amount):
            return back()->with('error','Sorry! You do not have enough balance to transfer');
        elseif($profile->status==4):
            return back()->with('error','You are not allowed to transfer your coin when your profile has been banned');
        else:
            if($requ->amount>$minMaxChk->maxCoinTransfer || $requ->amount<$minMaxChk->minCoinTransfer):
                return back()->with('error','Sorry! Minimum coin transfer amount '.$minMaxChk->minCoinTransfer.' & maximum coin transfer amount '.$minMaxChk->maxCoinTransfer);
            else:
                $hashpass   = $profile->hashpassword;
            	$authUser = Hash::check($requ->password,$hashpass);
                if($authUser):
                    $c2cuser    = BetUser::where(['userid'=>$requ->userid])->first();
                    if($c2cuser->userid==$profile->userid):
                        return back()->with('error','Can not possible to transfer own account');
                    else:
                        if(count($c2cuser)>0):
                            $cuserid = $c2cuser->id;
                            $prebalance = $c2cuser->balance;
                            $newbalance = $prebalance+$amount;
                            
                            //update coin user balance
                            $cuser  = BetUser::find($cuserid);
                            $cuser->balance = $newbalance;
                            
                            //update Main Balance
                            $newmainbalance = $profile->balance - $amount;
                            $profile->balance = $newmainbalance;
                            
                            //Update user statement
                            $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                            
                            if(count($statement)>0):
                                $stmtBal    = $statement->currentBalance;
                            else:
                                $stmtBal    = $profile->balance;
                            endif;
                            //Create statement
                            $statement= new BetUserStatement();
                            $statement->user  = $profile->id;
                            //$statement = BetUserStatement::find($statement->id);
                            $statement->prevBalance  = $stmtBal;
                            $statement->currentBalance  = $newmainbalance;
                            $statement->transAmount  = $amount;
                            $statement->note   = "C2C";
                            $statement->transType   = "Debit";
                            //Statement table end
                            
                            //Update coin receiver statement
                            $statement1   = BetUserStatement::where(['user'=>$cuser->id])->get()->last();
                            
                            if(count($statement)>0):
                                $stmtBal1    = $statement1->currentBalance;
                            else:
                                $stmtBal1    = $cuser->balance;
                            endif;
                            //Create statement
                            $statement1= new BetUserStatement();
                            $statement1->user  = $cuser->id;
                            //$statement = BetUserStatement::find($statement->id);
                            $statement1->prevBalance  = $stmtBal;
                            $statement1->currentBalance  = $newbalance;
                            $statement1->transAmount  = $amount;
                            $statement1->note   = "C2C";
                            $statement1->transType   = "Credit";
                            //Statement table end
            
                            
                            //save coin transfer history
                            $coin    = new CoinTransfer();
                            $coin->user          = $profile->id;
                            $coin->c2cUser       = $requ->userid;
                            $coin->amount        = $amount;
                            $coin->status        = "Complete";
                            if($profile->save()):
                                $cuser->save();
                                $coin->save();
                                $statement->save();
                                $statement1->save();
                                return back()->with('success','Coin transfer successful');
                            else:
                                return back()->with('error','Coin transfer failed to complete');
                            endif;
                        else:
                            return back()->with('error','No user found with this id');
                        endif;
                    endif;
                else:
                    return back()->with('error','Wrong password provide');
                endif;
            endif;
        endif;
    }
}
