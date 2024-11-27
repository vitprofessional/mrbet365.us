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
use App\Models\UserBet;
use DB;

class EventController extends Controller
{ 
     //Fixed question status change
    public function fqStatusChange($id,$matchId,$tournament){
        $getData    = FixedQuestion::find($id);
        $status =0;
        if($getData->status==2):
            $status =1;
            $getData->status = 1;
        else:
            $status =2;
            $getData->status = 2;
        endif;
        $getData->save();
        
        $newGetData    = FixedQuestion::find($id);
        
        $fixedQuestion = $newGetData;
        $question = BetOption::find($fixedQuestion->quesId);
        $matchList = Matche::find($matchId);
        $fixedQuestion['options'] = $question;
        $teamA = Team::find($matchList->teamA);
        $teamB = Team::find($matchList->teamB);

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
    public function cqStatusChange($id,$matchId,$tournament){
        $getData    = MatchQuestion::find($id);
        $status =0;
        if($getData->status==2):
            $status =1;
            $getData->status = 1;
        else:
            $status =2;
            $getData->status = 2;
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
            foreach($betHistory as $bh):
                //Set win answer to database
                $BetData  = UserBet::find($bh->id);
                $returnAmount   = $bh->returnAmount;
                $betAmount      = $bh->betAmount;
                //Fetch data match with winAnswer
                if($BetData->betAnswer==$team && $BetData->betReturnAmount==NULL):
                    $BetData->userProfit  = $BetData->returnAmount;
    
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
                else:
                    $BetData->siteProfit = $betAmount;
                endif;
                    $BetData->status    = 2;
                    $BetData->winAnswer = $team;
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
    } 
    
    //Fixed question revert and unpublish
    public function fqUnpublish($id,$matchId,$tournament){
        $getData = FixedQuestion::find($id);
        //$getData    = FixedQuestion::find($id);
        $status =0;
        if($getData->status==4):
            $status =1;
            $getData->status = 1;
        endif;
        
        $quesId = $getData->quesId;
        $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId,'status'=>2])->get();
        if(count($betHistory)>0):
            foreach($betHistory as $bh):
                //Set win answer to database
                $returnAmount = $bh->returnAmount;
                //Find betdata for update
                $BetData  = UserBet::find($bh->id);
                //return $bh->userProfit;
                if(!empty($bh->userProfit)):
                    $profile  = BetUser::find($bh->user);
                endif;
                    
                if(count($profile)>0):
                    $userBalance = $profile->balance;
                    $newBalance = $userBalance-$returnAmount;
                    //update user balance
                    $profile->balance = $newBalance;
                    $profile->save();
                
                    //Update User Statement
                    $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                    if(count($statement)>0):
                        $stmtBal    = $statement->currentBalance;
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
                    $statement->transType       = "Debit";
                    $statement->save();
                endif; 
                            
                //Update and revert bettting history
                $BetData->userProfit    = NULL;
                $BetData->winAnswer     = NULL;
                $BetData->siteProfit    = NULL;
                $BetData->status        = 1;
                $BetData->save();
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
            $status =1;
            $getData->status = 1;
        endif;
        $quesId = $getData->quesId;
        $betHistory = UserBet::where(['matchId'=>$matchId,'tournament'=>$tournament,'betOption'=>$quesId,'status'=>2])->get();
        if(count($betHistory)>0):
            foreach($betHistory as $bh):
                //Set win answer to database
                $returnAmount = $bh->returnAmount;
                //Find betdata for update
                $BetData  = UserBet::find($bh->id);
                if(!empty($bh->userProfit)):
                    //Fetch user table to update balance
                    $profile = BetUser::find($BetData->user);
                endif;
                if(count($profile)>0):
                    $userBalance = $profile->balance;
                    $newBalance = $userBalance-$returnAmount;
                    //update user balance
                    $profile->balance = $newBalance;
                    $profile->save();
                
                    //Update User Statement
                    $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                    if(count($statement)>0):
                        $stmtBal    = $statement->currentBalance;
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
                    $statement->transType       = "Debit";
                    $statement->save();
                endif;
                //end statement
                            
                //Update and revert bettting history
                $BetData->userProfit    = NULL;
                $BetData->winAnswer     = NULL;
                $BetData->siteProfit    = NULL;
                $BetData->status        = 1;
                $BetData->save();
            endforeach;
            //Question Status Updated
            $getData->save();
            $fixedQuestion = $getData;
            $eventData = array('status'=>$status,'type'=>'cqTurnOnOff','fqId'=>$id,'tournamentId'=>$tournament,'matchId'=>$matchId,'fq'=>$fixedQuestion);
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
                $returnAmount   = $bh->returnAmount;
                $betAmount      = $bh->betAmount;
                //Fetch data match with winAnswer
                if($BetData->betAnswer==$answer && $BetData->betReturnAmount==NULL):
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
                else:
                    $BetData->siteProfit = $betAmount;
                endif;
                    $BetData->status    = 2;
                    $BetData->winAnswer = $answer;
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
    public function fqHideShow($id,$matchId,$tournament){
        $getData    = FixedQuestion::find($id);
        $status = $getData->status;
        if($status==1 || $status==2):
            $getData->status = 3;
        elseif($status==3):
            $getData->status = 1;
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
        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->get();
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
    public function cqHideShow($id,$matchId,$tournament){
        $getData    = MatchQuestion::find($id);
        if($getData->status==1 || $getData->status==2):
            $getData->status = 3;
        else:
            $getData->status = 1;
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
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->get();
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
                for($i=0;$i<count($requ->optVal);$i++){
                    $date = date('Y-m-d H:i:s');
                    $savedb = [  
                        'quesId'        =>   $requ->qId,     
                        'answer'        =>   $requ->optVal[$i],     
                        'returnValue'   =>   $requ->returnVal[$i], 
                    ];
                    $save = DB::table('match_answers')->insert($savedb);
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
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->get();
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
        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->get();
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



    
    //Match publish unpublish
    public function matchStatus($id,$tournament){
    	$getData	= Matche::find($id);
        $status = 0;
    	if($getData->status==2 || $getData->status==3):
            $status =1;
    		$getData->status = 1;
    	else:
            $status =2;
    		$getData->status = 2;
    	endif;
    	$getData->save();
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->get();
        if(count($getFixedQuestion)>0):
            foreach($getFixedQuestion as $gfq):
                $FQ = FixedQuestion::find($gfq->id);
                if($FQ->status==3):
                    $FQ->status = 1;
                elseif($FQ->status==1):
                    $FQ->status = 3;
                endif;
                $FQ->save();
            endforeach;
        endif;
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->get();
        if(count($getCustomQuestion)>0):
            foreach($getCustomQuestion as $gcq):
                $CQ = MatchQuestion::find($gcq->id);
                if($CQ->status==3):
                    $CQ->status = 1;
                elseif($CQ->status==1):
                    $CQ->status = 3;
                endif;
                $CQ->save();
            endforeach;
        endif;
        if($status==1):
            $eventData = array('type'=>'matchPublish','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        else:
            $eventData = array('type'=>'matchUnPublish','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        endif;

        
    	return back()->with('success','Match status changed successfully');
    }
    public function matchStatusLeader($matchId,$tournamentId){
        $matchList = Matche::where(['tournament'=>$tournamentId,'id'=>$matchId])->first();
        
        $status = $matchList->status;

        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->get();
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
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        
        if($status==1):
            $eventData = array('type'=>'publishMatch','status'=>$matchList->status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        elseif($status==2):
            $eventData = array('type'=>'unPublishMatch','status'=>$status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        endif;

        return response()->json($eventData);
    }
    //All Bet Hide Show 
    public function allBetHideShow($id,$tournament,$status){
        //return $status;
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->get();
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
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->get();
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
        if($status==1):
            $eventData = array('type'=>'AllBetShow','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        else:
            $eventData = array('type'=>'AllBetHide','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        endif;

        
    	return back()->with('success','Match status changed successfully');
    }

    public function allBetHideShowStatusLeader($matchId,$tournamentId){
        $matchList = Matche::where(['tournament'=>$tournamentId,'id'=>$matchId])->first();
        
        $status = $matchList->status;

        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->get();
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
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        
        if($status==1):
            $eventData = array('type'=>'AllBetShow','status'=>$matchList->status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        elseif($status==3):
            $eventData = array('type'=>'AllBetHide','status'=>$status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        endif;

        return response()->json($eventData);
    }
    
    //All Bet On Off 
    public function allBetOnOff($id,$tournament,$status){
        //return $status;
        $getFixedQuestion     = FixedQuestion::where(['matchId'=>$id])->get();
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
        $getCustomQuestion     = MatchQuestion::where(['matchId'=>$id])->get();
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
        if($status==1):
            $eventData = array('type'=>'AllBetOn','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        else:
            $eventData = array('type'=>'AllBetOff','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        endif;

        
    	return back()->with('success','Match status changed successfully');
    }

    public function allBetOnOffStatusLeader($matchId,$tournamentId){
        $matchList = Matche::where(['tournament'=>$tournamentId,'id'=>$matchId])->first();
        
        $status = $matchList->status;

        $fixedQuestion = FixedQuestion::where(['matchId'=>$matchId])->get();
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
        $customQuestion = MatchQuestion::where(['matchId'=>$matchId])->get();
        if(count($customQuestion)>0):
            $matchList['customQuestion'] = $customQuestion;
            foreach($customQuestion as $cqKey=>$cq):
                $option = BetOption::find($cq->quesId);
                $matchList['customQuestion'][$cqKey]['options'] = $option;
                $customAnswer = MatchAnswer::where(['quesId'=>$cq->id])->get();
                $matchList['customQuestion'][$cqKey]['customAnswer'] = $customAnswer;
            endforeach;
        endif; 
        
        if($status==1):
            $eventData = array('type'=>'AllBetOn','status'=>$matchList->status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        elseif($status==2):
            $eventData = array('type'=>'AllBetOff','status'=>$status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        endif;

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
        if($status==1):
            $eventData = array('type'=>'liveBetOn','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        else:
            $eventData = array('type'=>'liveBetOff','tournamentId'=>$tournament,'matchId'=>$id);
            event(new BetUpdated($eventData));
        endif;

        
    	return back()->with('success','Match status changed successfully');
    }

    public function liveBetOnOffStatusLeader($matchId,$tournamentId){
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
        
        if($status==1):
            $eventData = array('type'=>'liveBetOn','status'=>$status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        elseif($status==2):
            $eventData = array('type'=>'liveBetOff','status'=>$status,'tournamentId'=>$tournamentId,'matchId'=>$matchId,'match'=>$matchList);
        endif;

        return response()->json($eventData);
    }
    
    
    
    
    
    //pertial result publish
    public function pertialPublish($id,$matchId,$tournament,$quesId,$betOn,$pertialAmount){
        if($betOn=='FQ'):
            $getData = FixedQuestion::find($id);
            $status =0;
            if($getData->status==1 || $getData->status==2 || $getData->status==3):
                $status =4;
                $getData->status = 4;
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
                        $statement->transAmount     = $pertialBalance;
                        $statement->note            = "PertialBetReturn";
                        $statement->transType       = "Credit";
                        $statement->save();
                        //end statement
                        
                        //update user balance
                        $profile->balance = $newBalance;
                        $profile->save();
                    endif;
                        $BetData->status    = 2;
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
                $getData->status = 4;
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
                        $statement->transAmount     = $pertialBalance;
                        $statement->note            = "PertialBetReturn";
                        $statement->transType       = "Credit";
                        $statement->save();
                        //end statement
                        
                        //update user balance
                        $profile->balance = $newBalance;
                        $profile->save();
                    endif;
                        $BetData->status    = 2;
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
}
