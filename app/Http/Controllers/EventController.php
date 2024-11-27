<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matche;
use App\Models\FixedQuestion;
use App\Models\MatchQuestion;
use App\Models\MatchAnswer;
use App\Models\Team;
use App\Models\BetOption;
use App\Events\BetUpdated;
use App\Models\BetUser;
use App\Models\BetUserStatement;
use App\Models\Tournament;
use App\Models\UserBet;
use DB;

class EventController extends Controller
{ 
     //Fixed question status change
    public function fqStatusChange($id,$matchId,$tournament,$status){
        $getData    = FixedQuestion::find($id);
        if($getData->status==2):
            if($status ==1):
                $getData->status = 1;
            endif;
        else:
            if($status ==2):
                $getData->status = 2;
            endif;
        endif;
        $getData->save();
        
        $newGetData    = FixedQuestion::find($id);
        
        $fixedQuestion = $newGetData;
        $question = BetOption::find($fixedQuestion->quesId);
        $matchList = Matche::find($matchId);
        $fixedQuestion['options'] = $question;
        $teamA = Team::find($matchList->teamA);
        $teamB = Team::find($matchList->teamB);
        $getTournament = Tournament::where(['id'=>$tournament])->get();
        $fixedQuestion['tournament'] = $getTournament;

        $fixedQuestion['team'] = [array('name'=>$teamA->team,'value'=>$fixedQuestion->teamA),array('name'=>$teamB->team,'value'=>$fixedQuestion->teamB)];
        $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
        event(new BetUpdated($eventData));
        
        //dd($getData);
        return back()->with('success','Question status changed successfully');
    }

    //Fixed question sent to live
    public function fqsendLiveRoom($id,$matchId,$tournament){
        $getData    = FixedQuestion::find($id);
        $status = $getData->status;
        if($getData->status==3):
            return $status;
            $getData->status = 1;
        endif;
        $getData->save();


        // if($status==1):
            $fixedQuestion = $getData;
            $question = BetOption::find($fixedQuestion->quesId);
            $matchList = Matche::find($matchId);
            $fixedQuestion['options'] = $question;
            $teamA = Team::find($matchList->teamA);
            $teamB = Team::find($matchList->teamB);

            $fixedQuestion['team'] = [array('name'=>$teamA->team,'value'=>$fixedQuestion->teamA),array('name'=>$teamB->team,'value'=>$fixedQuestion->teamB)];
            $eventData = array('status'=>$status,'type'=>'fqHideShow','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
        //dd($getData);
        return back()->with('success','Question status changed successfully');
    }
    //Custom question status change
    public function cqStatusChange($id,$matchId,$tournament,$status){
        $getData    = MatchQuestion::find($id);
        if($getData->status==2):
            if($status ==1):
                $getData->status = 1;
            endif;
        else:
            if($status ==2):
                $getData->status = 2;
            endif;
        endif;
        $getData->save();

            //if($status==1):
            $customQuestion = $getData;
            $question = BetOption::find($customQuestion->quesId);
            $matchList = Matche::find($matchId);
            $customQuestion['options'] = $question;
            $customAnswer   = MatchAnswer::where(['quesId'=>$customQuestion->id])->get();

            
            $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$customQuestion,'CA'=>$customAnswer);
            event(new BetUpdated($eventData));
        
            //dd($getData);
        return back()->with('success','Question status changed successfully');
    }
    public function  cqsendLiveRoom($id,$matchId,$tournament){
        $getData    = MatchQuestion::find($id);
        if($getData->status==2 || $getData->status==3):
            $getData->status = 1;
        endif;
        $getData->save();

        $newGetData = MatchQuestion::find($id);
        $status = $newGetData->status;

            //if($status==1):
            $customQuestion = $newGetData;
            $question = BetOption::find($customQuestion->quesId);
            $matchList = Matche::find($matchId);
            $customQuestion['options'] = $question;
            $customAnswer   = MatchAnswer::where(['quesId'=>$customQuestion->id])->get();

            
            $eventData = array('status'=>$status,'type'=>'cqHideShow','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$customQuestion,'CA'=>$customAnswer);
            event(new BetUpdated($eventData));
        
            //dd($getData);
        return back()->with('success','Question status changed successfully');
    }
    

    //update single question
    public function publishSingleResult($team,$id,$matchId,$tournament){
        $getData = FixedQuestion::find($id);
        //$getData    = FixedQuestion::find($id);
        $status =0;
        if($getData->status==1 || $getData->status==2 || $getData->status==3):
            $status =4;
            $getData->status = 4;
        endif;
        //return $status;
        //$gqStatus->status = 4;
        $quesId = $getData->quesId;
        $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId,'status'=>1])->get();
        if(count($betHistory)>0):
            //return "First Loop";
            foreach($betHistory as $bh):
                //Set win answer to database
                $BetData  = UserBet::find($bh->id);
                //Fetch data match with winAnswer
                $betAmount = $bh->betAmount;
                $rate      = $bh->betRate;
                if($BetData->betAnswer==$team && $BetData->betReturnAmount==NULL):
                    $returnAmount   = $betAmount*$rate;
                    //$BetData->userProfit  = $BetData->returnAmount;
    
                    //Fetch user table to update balance
                    $profile = BetUser::find($BetData->user);
                    $profileBalance = $profile->balance;
                    $newBalance = $profileBalance+$returnAmount;
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
                    $statement->prevBalance     = $stmtBal;
                    $statement->currentBalance  = $newBalance;
                    $statement->transAmount     = $returnAmount;
                    $statement->note            = "BetWin";
                    $statement->transType       = "Credit";
                    $statement->save();
                    //end statement
                    
                    //update user balance
                    $profile->balance = $newBalance;
                    $profile->save();
                    $BetData->userProfit = $returnAmount;
                    $BetData->status    = 2;
                    $BetData->winAnswer = $team;
                    $BetData->save();
                else:
                    $BetData->siteProfit = $betAmount;
                    $BetData->status    = 2;
                    $BetData->winAnswer = $team;
                    $BetData->save();
                endif;
            endforeach;
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer publish successfully');
        else:
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer publish successfully');
        endif;
    } 
    
    //Fixed question revert and unpublish
    public function fqUnpublish($id,$matchId,$tournament){
        $getData = FixedQuestion::find($id);
        //$getData    = FixedQuestion::find($id);
        $status =0;
        if($getData->status==4):
            $status =3;
            $getData->status = 3;
        endif;
        
        $quesId = $getData->quesId;
        $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId])->where(function($query) {
            $query->where(['status'=>2])
            ->orWhere(['status'=>'Pertial']);
        })->get();
        if(count($betHistory)>0):
            foreach($betHistory as $bh):
                //New return code
                $profile  = BetUser::find($bh->user);
                if(!empty($profile)):
                    if($bh->partialAmount>0):
                        // update user balance
                        $returnAmount   = $bh->partialAmount;
                        $currentBalance = $profile->balance;
                        $newBalance     = $currentBalance-$returnAmount;
                        $profile->balance = $newBalance;
                        $profile->save();
                        
                        // user statement update
                        $stmt   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                        if(count($stmt)>0):
                            $stmtBal    = $stmt->currentBalance;
                        else:
                            $stmtBal    = $profile->balance;
                        endif;
                        //Create statement
                        $statement= new BetUserStatement();
                        $statement->user            = $profile->id;
                        $statement->prevBalance     = $stmtBal;
                        $statement->currentBalance  = $newBalance;
                        $statement->transAmount     = $returnAmount;
                        $statement->note            = "PertialBetUnpublish";
                        $statement->transType       = "Credit";
                        $statement->save();
                    else:
                        if($bh->userProfit>0):
                            $returnAmount = $bh->userProfit;
                            // update user balance
                            $currentBalance = $profile->balance;
                            $newBalance     = $currentBalance-$returnAmount;
                            $profile->balance = $newBalance;
                            
                            // user statement update
                            $stmt   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                            if(count($stmt)>0):
                                $stmtBal    = $stmt->currentBalance;
                            else:
                                $stmtBal    = $profile->balance;
                            endif;
                            //Create statement
                            $statement= new BetUserStatement();
                            $statement->user            = $profile->id;
                            $statement->prevBalance     = $stmtBal;
                            $statement->currentBalance  = $newBalance;
                            $statement->transAmount     = $returnAmount;
                            $statement->note            = "BetUnpublish";
                            $statement->transType       = "Credit";
                            $statement->save();
                            $profile->save();
                        endif;
                    endif;
                endif;
                            
                //Update and revert bettting history
                $bh->userProfit    = NULL;
                $bh->winAnswer     = NULL;
                $bh->siteProfit    = NULL;
                $bh->status        = 1;
                $bh->save();
            endforeach;
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer Unpublish successfully');
        else:
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer Unpublish successfully');
        endif;
    } 
    
    //Custom question revert and unpublish
    public function cqUnpublish($id,$matchId,$tournament){
        $getData = MatchQuestion::find($id);
        
        $status =0;
        if($getData->status==4):
            $status =3;
            $getData->status = 3;
        endif;
        $quesId = $getData->quesId;
        $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId])->where(function($query) {
            $query->where(['status'=>2])
            ->orWhere(['status'=>'Pertial']);
        })->get();
        if(count($betHistory)>0):
            foreach($betHistory as $bh):
                //New return code
                $profile  = BetUser::find($bh->user);
                if(!empty($profile)):
                    if($bh->partialAmount>0):
                        // update user balance
                        $returnAmount = $bh->partialAmount;
                        $currentBalance = $profile->balance;
                        $newBalance     = $currentBalance-$returnAmount;
                        $profile->balance = $newBalance;
                        $profile->save();
                        
                        // user statement update
                        $stmt   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                        if(count($stmt)>0):
                            $stmtBal    = $stmt->currentBalance;
                        else:
                            $stmtBal    = $profile->balance;
                        endif;
                        //Create statement
                        $statement= new BetUserStatement();
                        $statement->user            = $profile->id;
                        $statement->prevBalance     = $stmtBal;
                        $statement->currentBalance  = $newBalance;
                        $statement->transAmount     = $returnAmount;
                        $statement->note            = "PertialBetUnpublish";
                        $statement->transType       = "Credit";
                        $statement->save();
                        
                    else:
                        if($bh->userProfit>0):
                            $returnAmount = $bh->userProfit;
                            // update user balance
                            $currentBalance = $profile->balance;
                            $newBalance     = $currentBalance-$returnAmount;
                            $profile->balance = $newBalance;
                            
                            // user statement update
                            $stmt   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                            if(count($stmt)>0):
                                $stmtBal    = $stmt->currentBalance;
                            else:
                                $stmtBal    = $profile->balance;
                            endif;
                            //Create statement
                            $statement= new BetUserStatement();
                            $statement->user            = $profile->id;
                            $statement->prevBalance     = $stmtBal;
                            $statement->currentBalance  = $newBalance;
                            $statement->transAmount     = $returnAmount;
                            $statement->note            = "BetUnpublish";
                            $statement->transType       = "Credit";
                            $statement->save();
                            $profile->save();
                        endif;
                    endif;
                endif;
                            
                //Update and revert bettting history
                $bh->userProfit    = NULL;
                $bh->winAnswer     = NULL;
                $bh->siteProfit    = NULL;
                $bh->status        = 1;
                $bh->save();
            endforeach;
            //Question Status Updated
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer Unpublish successfully');
        else:
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$fixedQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer Unpublish successfully');
        endif;
    } 
    
    //publish custom question result
    public function publishCQResult ($answer,$id,$matchId,$tournament){
       $getData = MatchQuestion::find($id);
        //$getData    = FixedQuestion::find($id);
        $status =0;
        if($getData->status==1 || $getData->status==2 || $getData->status==3):
            $status =4;
            $getData->status = 4;
        endif;
        //return $status;
        //$gqStatus->status = 4;
        $quesId = $getData->quesId;
        $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId,'status'=>1])->get();
        if(count($betHistory)>0):
            foreach($betHistory as $bh):
                //Set win answer to database
                $BetData  = UserBet::find($bh->id);
                //Fetch data match with winAnswer
                $betAmount      = $bh->betAmount;
                if($BetData->betAnswer==$answer && $BetData->betReturnAmount==NULL && $BetData->returnAmount>0):
                    $returnAmount   = $bh->returnAmount;
                    $BetData->userProfit  = $BetData->returnAmount;

                    //Fetch user table to update balance
                    $profile = BetUser::find($BetData->user);
                    $userBalance = $profile->balance;
                    $newBalance = $userBalance+$returnAmount;
                    $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                    if(count($statement)>0):
                        $stmtBal    = $statement->currentBalance;
                    else:
                        $stmtBal    = $profile->balance;
                    endif;
                    //Create statement
                    $statement= new BetUserStatement();
                    $statement->user  = $profile->id;
                    $statement->prevBalance     = $stmtBal;
                    $statement->currentBalance  = $newBalance;
                    $statement->transAmount     = $returnAmount;
                    $statement->note            = "BetWin";
                    $statement->transType       = "Credit";
                    $statement->save();
                    //end statement
                    
                    //update user balance
                    $profile->balance = $newBalance;
                    $profile->save();
                    $BetData->userProfit = $returnAmount;
                    $BetData->status    = 2;
                    $BetData->winAnswer = $answer;
                    $BetData->save();
                else:
                    $BetData->siteProfit = $betAmount;
                    $BetData->status    = 2;
                    $BetData->winAnswer = $answer;
                    $BetData->save();
                endif;
            endforeach;
            $getData->save();
            $customQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$customQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer publish successfully');
        else:
            $getData->save();
            $customQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$customQuestion);
            event(new BetUpdated($eventData));
        
            //dd($getData);
            return back()->with('success','Answer publish successfully');
        endif;
    }
    
    

    public function matchFinish($tournament,$id){
    	$getData	= Matche::find($id);
        if($getData):
            $getData->status = 5;
            $getData->save();
    
            $eventData = array('type'=>'matchFinish','tournamentId'=>$tournament,'matchID'=>$id);
            event(new BetUpdated($eventData));
            return back()->with('success','Success! Match finish successfully');
        else:
            return back()->with('error','Sorry! Match already finish');
        endif;
    }

    public function deleteMatch($id){
    	$getData	= Matche::find($id);
        if($getData):
            $getData->delete();
            return back()->with('success','Success! Match delete successfully');
        else:
            return back()->with('error','Sorry! Match already delete');
        endif;
    }

    public function hideUserPage($tournament,$id){
    	$getData	= Matche::find($id);
        if($getData):
            $getData->status = 3;
            $getData->save();
    
            $eventData = array('type'=>'matchFinish','tournamentId'=>$tournament,'matchID'=>$id);
            event(new BetUpdated($eventData));
            return back()->with('success','Success! Match finish successfully');
        else:
            return back()->with('error','Sorry! Match already finish');
        endif;
    }


//Live API Leader board here
    //Fixed question hide from live room
    public function fqHideShow($id,$matchId,$tournament,$status){
        $getData    = FixedQuestion::find($id);
        if($getData->status==1 || $getData->status==2):
            if($status==2):
                $getData->status = 3;
            endif;
        else:
            if($status==1):
                $getData->status = 1;
            endif;
        endif;
        $getData->save();
        $getData    = FixedQuestion::find($id);
        $status = $getData->status;

        $eventData = array('status'=>$status,'type'=>'fqHideShow','tournamentId'=>$tournament,'matchId'=>$matchId);
        event(new BetUpdated($eventData));
        
        //dd($getData);
        return back()->with('success','Question status changed successfully');
    }
    public function fqHideShowLeader($tournamentId,$matchId){
        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->where(function($query){
            $query->where(['status'=>1])->orWhere(['status'=>2])->orWhere(['status'=>3]);
        })->get();
        //dd($customQuestion);
        if(count($fixedQuestion)>0):
            foreach($fixedQuestion as $fqKey=>$fq):
                $option = BetOption::find($fq->quesId);
                $fixedQuestion[$fqKey]['options'] = $option; 
                $matchList = Matche::find($fq->matchId);
                $fixedQuestion[$fqKey]['draw'] = $fq->draw;
                $teamA = Team::find($matchList->teamA);
                $teamB = Team::find($matchList->teamB);
                $fixedQuestion[$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
            endforeach;
        endif;

        $eventData = array('tournamentId'=>$tournamentId,'matchId'=>$matchId,'fq'=>$fixedQuestion);
        
        return response()->json($eventData);
    }
    //Custom Question Hide Show
    public function cqHideShow($id,$matchId,$tournament,$status){
        $getData    = MatchQuestion::find($id);
        if($getData->status==1 || $getData->status==2):
            if($status==2):
                $getData->status = 3;
            endif;
        else:
            if($status==1):
                $getData->status = 1;
            endif;
        endif;
        $getData->save();
        $getData    = FixedQuestion::find($id);
        $status = $getData->status;
        $eventData = array('status'=>$status,'type'=>'cqHideShow','tournamentId'=>$tournament,'matchId'=>$matchId);
        event(new BetUpdated($eventData));
        
            //dd($getData);
        return back()->with('success','Question status changed successfully');
    }
    public function cqHideShowLeader($tournamentId,$matchId){
        //Custom question query
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->where(function($query){
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();
        //dd($customQuestion);
        if(count($customQuestion)>0):
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $customQuestion[$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $customQuestion[$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif;
        
        $eventData = array('tournamentId'=>$tournamentId,'matchId'=>$matchId,'cq'=>$customQuestion);
        return response()->json($eventData);
    }
    
    //Custom question update
    public function cQupdate(Request $requ){
            $canswer    = MatchAnswer::where(['quesId'=>$requ->qId])->get();
            if(count($canswer)>0):
                foreach($canswer as $ca):
                    $delCAns = MatchAnswer::find($ca->id);
                    $delCAns->delete();
                endforeach;
            endif;
            if(!empty($requ->optVal)):
                $i=0;
                while($i<=count($requ->optVal))
                {
                    if(!empty($requ->returnVal[$i])):
                        $date = date('Y-m-d H:i:s');
                        $savedb = [
                            'quesId'        =>   $requ->qId,     
                            'answer'        =>   $requ->optVal[$i],     
                            'returnValue'   =>   $requ->returnVal[$i],   
                            
                            'created_at'    =>   $date,
                            'updated_at'    =>   $date,
                        ];
                        $save = DB::table('match_answers')->insert($savedb);
                    endif;
                    $i++;
                }
            endif;
            if($save):
                $eventData = array('type'=>'cqUpdate','cqId'=>$requ->qId,'tournamentId'=>$requ->tournament,'matchId'=>$requ->mId);
                event(new BetUpdated($eventData));
            
                //dd($getData);
                return back()->with('success','Success! Answer updated successfully');
            else:
                return back()->with('error','Sorry! Answer failed to updated');
            endif;
    }
    public function cqUpdateLeader($cqId,$tournamentId,$matchId){
        //Custom question query
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->where(function($query) {
    	$query->where(['status'=>1])
    	->orWhere(['status'=>2]);
    })->get();
        //dd($customQuestion);
        if(count($customQuestion)>0):
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $customQuestion[$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $customQuestion[$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif;
        
        $eventData = array('fqId'=>$cqId,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'cq'=>$customQuestion);
        return response()->json($eventData);
    }
    //update single question
    public function fQupdate(Request $requ){
        $fixed_answer    = FixedQuestion::find($requ->qId);
        if(count($fixed_answer)>0):
            $fixed_answer->teamA        = $requ->teamA;
            $fixed_answer->teamB        = $requ->teamB;
            if(!empty($requ->tie)):
                $fixed_answer->draw      = $requ->tie;
            endif;
            if($fixed_answer->save()):
                $newFixedanswer    = FixedQuestion::find($requ->qId);
                $fixedQuestion = $newFixedanswer;
                $eventData = array('type'=>'fqUpdate','fqId'=>$requ->qId,'tournamentId'=>$fixedQuestion->tournament,'matchId'=>$fixedQuestion->matchId);
                event(new BetUpdated($eventData));
            
                //dd($getData);
                return back()->with('success','Success! Answer updated successfully');
            else:
                return back()->with('error','Sorry! Answer failed to updated');
            endif;
        else:
            return back()->with('error','Sorry! No data found to update');
        endif;
    }

    
    public function fqUpdateLeader($fqId,$tournamentId,$matchId){
        //single question query
        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->where(function($query) {
    	$query->where(['status'=>1])
    	->orWhere(['status'=>2]);
    })->get();
        //dd($customQuestion);
        if(count($fixedQuestion)>0):
            foreach($fixedQuestion as $fqKey=>$fq):
                $option = BetOption::find($fq->quesId);
                $fixedQuestion[$fqKey]['options'] = $option; 
                $matchList = Matche::find($fq->matchId);
                $fixedQuestion[$fqKey]['draw'] = $fq->draw;
                $teamA = Team::find($matchList->teamA);
                $teamB = Team::find($matchList->teamB);
                $fixedQuestion[$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
            endforeach;
        endif;

        $eventData = array('fqId'=>$fqId,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'fq'=>$fixedQuestion);
        
        return response()->json($eventData);
    }


    //pertial result publish
    public function pertialPublish($id,$matchId,$tournament,$quesId,$betOn,$pertialAmount){
        if($betOn=='FQ'):
            $getData = FixedQuestion::find($id);
            $status =0;
            if($getData->status==1 || $getData->status==2 || $getData->status==3):
                $status =4;
                $getData->status = "Pertial";
            endif;
            //return $status;
            // //$gqStatus->status = 4;
            // $quesId = $getData->quesId;
            $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId,'status'=>1])->get();
            if(count($betHistory)>0):
                foreach($betHistory as $bh):
                    //Set win answer to database
                    $BetData  = UserBet::find($bh->id);
                    $betAmount      = $bh->betAmount;
                    $pertialBalance  = ($pertialAmount/100)*$betAmount;
                    $userPertialBalance = $betAmount-$pertialBalance;
                    //Fetch data match with winAnswer
                    if($BetData->partialAmount==NULL):
                        $BetData->partialAmount  = $pertialBalance;
        
                        //Fetch user table to update balance
                        $profile = BetUser::find($BetData->user);
                        $profileBalance = $profile->balance;
                        $newBalance = $profileBalance+$userPertialBalance;
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
                        $statement->prevBalance     = $stmtBal;
                        $statement->currentBalance  = $newBalance;
                        $statement->transAmount     = $userPertialBalance;
                        $statement->note            = "PertialBetReturn";
                        $statement->transType       = "Credit";
                        $statement->save();
                        //end statement
                        
                        //update user balance
                        $profile->balance = $newBalance;
                        $profile->save();
                        $BetData->status    = "Pertial";
                    endif;
                        $BetData->winAnswer = "PertialBetReturn";
                        $BetData->save();
                endforeach;
                $getData->save();
                $fixedQuestion = $getData;
                $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
                event(new BetUpdated($eventData));
            
                //dd($getData);
                return back()->with('success','Answer publish successfully');
            else:
                $getData->save();
                $fixedQuestion = $getData;
                $eventData = array('status'=>$status,'type'=>'fqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
                event(new BetUpdated($eventData));
            
                //dd($getData);
                return back()->with('success','Answer publish successfully');
            endif;
        elseif($betOn=="CQ"):
           $getData = MatchQuestion::find($id);
            //$getData    = FixedQuestion::find($id);
            $status =0;
            if($getData->status==1 || $getData->status==2 || $getData->status==3):
                $status =4;
                $getData->status = "Pertial";
            endif;
            //return $status;
            // //$gqStatus->status = 4;
            // $quesId = $getData->quesId;
            $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId,'status'=>1])->get();
            if(count($betHistory)>0):
                foreach($betHistory as $bh):
                    //Set win answer to database
                    $BetData  = UserBet::find($bh->id);
                    $betAmount      = $bh->betAmount;
                    $pertialBalance  = ($pertialAmount/100)*$betAmount;
                    $userPertialBalance = $betAmount-$pertialBalance;
                    //Fetch data match with winAnswer
                    if($BetData->partialAmount==NULL):
                        $BetData->partialAmount  = $pertialBalance;
    
                        //Fetch user table to update balance
                        $profile = BetUser::find($BetData->user);
                        $userBalance = $profile->balance;
                        $newBalance = $userBalance+$userPertialBalance;
                        $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                        if(count($statement)>0):
                            $stmtBal    = $statement->currentBalance;
                        else:
                            $stmtBal    = $profile->balance;
                        endif;
                        //Create statement
                        $statement= new BetUserStatement();
                        $statement->user  = $profile->id;
                        $statement->prevBalance     = $stmtBal;
                        $statement->currentBalance  = $newBalance;
                        $statement->transAmount     = $userPertialBalance;
                        $statement->note            = "PertialBetReturn";
                        $statement->transType       = "Credit";
                        $statement->save();
                        //end statement
                        
                        //update user balance
                        $profile->balance = $newBalance;
                        $profile->save();
                        $BetData->status    = "Pertial";
                    endif;
                        $BetData->winAnswer = "PertialBetReturn";
                        $BetData->save();
                endforeach;
                $getData->save();
                $customQuestion = $getData;
                $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$customQuestion);
                event(new BetUpdated($eventData));
            
                //dd($getData);
                return back()->with('success','Answer publish successfully');
            else:
                $getData->save();
                $customQuestion = $getData;
                $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','cqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'cq'=>$customQuestion);
                event(new BetUpdated($eventData));
            
                //dd($getData);
                return back()->with('success','Answer publish successfully');
            endif;
        endif;
    } 

    
    //Match publish unpublish
    public function matchStatus($id,$tournament,$status){
    	$getData	= Matche::find($id);
    	if($status==1):
    	    if($getData->status==2 || $getData->status==3 || $getData->status==5):
    		    $getData->status = 1;
    		endif;
    	elseif($status==2):
    	    //return $status;
    		$getData->status = 3;
    	endif;
    	$getData->save();
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->get();
        if(count($getFixedQuestion)>0):
            foreach($getFixedQuestion as $gfq):
                $FQ = FixedQuestion::find($gfq->id);
                if($FQ->status==1 || $FQ->status==2):
                    if($status==2):
                        $FQ->status = 3;
                    endif;
                elseif($FQ->status==3):
                    if($status==1):
                        $FQ->status = 1;
                    endif;
                endif;
                $FQ->save();
            endforeach;
        endif;
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->get();
        if(count($getCustomQuestion)>0):
            foreach($getCustomQuestion as $gcq):
                $CQ = MatchQuestion::find($gcq->id);
                if($CQ->status==1 || $CQ->status==2):
                    if($status==2):
                        $CQ->status = 3;
                    endif;
                elseif($CQ->status==3):
                    if($status==1):
                        $CQ->status = 1;
                    endif;
                endif;
                $CQ->save();
            endforeach;
        endif;
        $newData    =  Matche::find($id);
        $status = $newData->status;
        if($status==1):
            //return $status;
            $eventData = array('type'=>'matchPublish','tournamentId'=>$tournament,'matchId'=>$id,'category'=>$newData->category);
        else:
            //return $status;
            $eventData = array('type'=>'matchUnPublish','tournamentId'=>$tournament,'matchId'=>$id,'category'=>$newData->category);
        endif;
        event(new BetUpdated($eventData));

    	return back()->with('success','Match status changed successfully');
    }
    public function matchStatusLeader($matchId,$tournamentId){
        $matchList = Matche::where(['id'=>$matchId])->orderBy('matchTime','DESC')->first();
        
        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($fixedQuestion)>0):
            $matchList['fixedQuestion'] = $fixedQuestion;
            foreach($fixedQuestion as $fqKey=>$fq):
                $question = BetOption::find($fq->quesId);
                $matchList['fixedQuestion'][$fqKey]['options'] = $question;
                $teamA = Team::find($matchList->teamA);
                $teamB = Team::find($matchList->teamB);
                $matchList['fixedQuestion'][$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
                // $data[$trmntKey]['matchList'][$mlKey]['fixedQuestion'][$fqKey]['teamB'] = $teamB;
            endforeach;
        endif;

        //Custom question query
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        $category = $matchList->category;
        $tournament = Tournament::find($tournamentId);
        $matchList['tournamentName'] = $tournament->cupName;
        $eventData = array('status'=>$matchList->status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList,'tournament'=>$tournament,'fq'=>$fixedQuestion,'cq'=>$customQuestion,'category'=>$category);

        return response()->json($eventData);
    }
    //All Bet Hide Show 
    public function allBetHideShow($id,$tournament,$status){
        //return $status;
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();
        if(count($getFixedQuestion)>0):
            foreach($getFixedQuestion as $gfq):
                $FQ = FixedQuestion::find($gfq->id);
                if($status==1):
                    $FQ->status = 3;
                elseif($status==2 || $status==3):
                    $FQ->status = 1;
                endif;
                $FQ->save();
            endforeach;
        endif;
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();;
        if(count($getCustomQuestion)>0):
            foreach($getCustomQuestion as $gcq):
                $CQ = MatchQuestion::find($gcq->id);
                if($status==1):
                    $CQ->status = 3;
                elseif($status==2 || $status==3):
                    $CQ->status = 1;
                endif;
                $CQ->save();
            endforeach;
        endif;
        $eventData = array('type'=>'AllBetHideShow','tournamentId'=>$tournament,'matchId'=>$id);
        event(new BetUpdated($eventData));

        
    	return back()->with('success','Match status changed successfully');
    }

    public function allBetHideShowStatusLeader($matchId,$tournamentId){
        $matchList = Matche::where(['tournament'=>$tournamentId,'id'=>$matchId])->first();
        
        $status = $matchList->status;

        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();
        if(count($fixedQuestion)>0):
            $matchList['fixedQuestion'] = $fixedQuestion;
            foreach($fixedQuestion as $fqKey=>$fq):
                $question = BetOption::find($fq->quesId);
                $matchList['fixedQuestion'][$fqKey]['options'] = $question;
                $teamA = Team::find($matchList->teamA);
                $teamB = Team::find($matchList->teamB);
                $matchList['fixedQuestion'][$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
            endforeach;
        endif;

        //Custom question query
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        $eventData = array('type'=>'AllBetHideShow','status'=>$matchList->status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList,'fq'=>$fixedQuestion,'cq'=>$customQuestion);

        return response()->json($eventData);
    }
    
    //All Bet On Off 
    public function allBetOnOff($id,$tournament,$status){
        //return $status;
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();
        if(count($getFixedQuestion)>0):
            foreach($getFixedQuestion as $gfq):
                $FQ = FixedQuestion::find($gfq->id);
                if($status==1):
                    $FQ->status = 2;
                elseif($status==2 || $status==3):
                    $FQ->status = 1;
                endif;
                $FQ->save();
            endforeach;
        endif;
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2])
            ->orWhere(['status'=>3]);
        })->get();
        if(count($getCustomQuestion)>0):
            foreach($getCustomQuestion as $gcq):
                $CQ = MatchQuestion::find($gcq->id);
                if($status==1):
                    $CQ->status = 2;
                elseif($status==2 || $status==3):
                    $CQ->status = 1;
                endif;
                $CQ->save();
            endforeach;
        endif;
        $eventData = array('type'=>'AllBetOnOff','tournamentId'=>$tournament,'matchId'=>$id);
        event(new BetUpdated($eventData));

        
    	return back()->with('success','Match status changed successfully');
    }

    public function allBetOnOffStatusLeader($matchId,$tournamentId){
        $matchList = Matche::where(['tournament'=>$tournamentId,'id'=>$matchId])->first();
        
        $status = $matchList->status;

        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($fixedQuestion)>0):
            $matchList['fixedQuestion'] = $fixedQuestion;
            foreach($fixedQuestion as $fqKey=>$fq):
                $question = BetOption::find($fq->quesId);
                $matchList['fixedQuestion'][$fqKey]['options'] = $question;
                $teamA = Team::find($matchList->teamA);
                $teamB = Team::find($matchList->teamB);
                $matchList['fixedQuestion'][$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
            endforeach;
        endif;

        //Custom question query
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        $eventData = array('type'=>'AllBetOnOff','status'=>$matchList->status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList,'fq'=>$fixedQuestion,'cq'=>$customQuestion);

        return response()->json($eventData);
    }

    //All Bet On Off 
    public function liveBetOnOff($id,$tournament,$status){
        //return $status;
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($getFixedQuestion)>0):
            foreach($getFixedQuestion as $gfq):
                $FQ = FixedQuestion::find($gfq->id);
                if($status==1):
                    $FQ->status = 2;
                elseif($status==2):
                    $FQ->status = 1;
                endif;
                $FQ->save();
            endforeach;
        endif;
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($getCustomQuestion)>0):
            foreach($getCustomQuestion as $gcq):
                $CQ = MatchQuestion::find($gcq->id);
                if($status==1):
                    $CQ->status = 2;
                elseif($status==2):
                    $CQ->status = 1;
                endif;
                $CQ->save();
            endforeach;
        endif;
        $eventData = array('type'=>'liveBetOnOff','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));

        
    	return back()->with('success','Match status changed successfully');
    }

    public function liveBetOnOffStatusLeader($matchId,$tournamentId){
        $matchList = Matche::find($matchId);
        
        $status = $matchList->status;

        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($fixedQuestion)>0):
            $matchList['fixedQuestion'] = $fixedQuestion;
            foreach($fixedQuestion as $fqKey=>$fq):
                $question = BetOption::find($fq->quesId);
                $matchList['fixedQuestion'][$fqKey]['options'] = $question;
                $teamA = Team::find($matchList->teamA);
                $teamB = Team::find($matchList->teamB);
                $matchList['fixedQuestion'][$fqKey]['team'] = [array('name'=>$teamA->team,'value'=>$fq->teamA),array('name'=>$teamB->team,'value'=>$fq->teamB)];
            endforeach;
        endif;

        //Custom question query
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->where(function($query) {
            $query->where(['status'=>1])
            ->orWhere(['status'=>2]);
        })->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        $eventData = array('type'=>'liveBetOnOff','status'=>$status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList,'fq'=>$fixedQuestion,'cq'=>$customQuestion);

        return response()->json($eventData);
    }
}
