<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\BetUser;
use Carbon\Carbon;
use App\Models\UserBet;
use App\Models\BetUserStatement;
use App\Models\BankChanel;
use App\Models\BetOption;
use App\Models\BetAnswer;
use App\Models\Category;
use App\Models\AdminUser;
use App\Models\Team;
use App\Models\Slider;
use App\Models\Tournament;
use App\Models\MatchQuestion;
use App\Models\MatchAnswer;
use App\Models\SiteConfig;
use App\Models\FixedQuestion;
use App\Models\BettingClub;
use App\Models\ClubStatement;
use App\Models\ClubWithdraw;
use App\Models\Matche;
use App\Models\WithdrawalRequest;
use App\Models\Deposit;

class AdminViewController extends Controller
{
    public function __construct(){
        //$this->middleware('SuperAdmin');
        $this->middleware('BetAdmin');
    }
    
    public function customerReport(){
        return view('admin.customerReport');
    }
    
    public function finalCustomerReport(Request $requ){
        $type       = $requ->type;
        $admin      = $requ->adminId;
        $formDate   = $requ->dateTimeForm;
        $toDate     = $requ->dateTimeTo;
        
        $form_date = Carbon::parse($formDate)->format('Y-m-d');
        $to_date = Carbon::parse($toDate)->format('Y-m-d');
        if($admin=="All"):
            if($type=="All"):
                $DepositReport = Deposit::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Accept')->get();
                $WithdrawReport = WithdrawalRequest::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Paid')->get();
            elseif($type=="Deposit"):
                $DepositReport = Deposit::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Accept')->get();
                $WithdrawReport    = "";
            elseif($type=="Withdrawal"):
                $WithdrawReport = WithdrawalRequest::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Paid')->get();
                $DepositReport    = "";
            else:
                $WithdrawReport = "";
                $DepositReport    = "";
            endif;
        else:
            if($type=="All"):
                $DepositReport = Deposit::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Accept')->where('acceptBy',$admin)->get();
                $WithdrawReport = WithdrawalRequest::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Paid')->where('acceptBy',$admin)->get();
            elseif($type=="Deposit"):
                $DepositReport = Deposit::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Accept')->where('acceptBy',$admin)->get();
                $WithdrawReport    = "";
            elseif($type=="Withdrawal"):
                $WithdrawReport = WithdrawalRequest::whereDate('updated_at', '>=', $form_date)->whereDate('updated_at', '<=', $to_date)->where('status','Paid')->where('acceptBy',$admin)->get();
                $DepositReport    = "";
            else:
                $WithdrawReport = "";
                $DepositReport    = "";
            endif;
        endif;
        return view('admin.finalCustomerReport',['DepositReport'=>$DepositReport,'WithdrawReport'=>$WithdrawReport,'formDate'=>$form_date,'toDate'=>$to_date]);
    }
    
    public function AdminHome(){
        $admindetails   = AdminUser::find(Session::get('SuperAdmin'));
        return view('admin.home',['details'=>$admindetails]);
    }
    
    public function adminProfile(){
        $admindetails   = AdminUser::find(Session::get('BetAdmin'));
        return view('admin.adminProfile',['admin'=>$admindetails]);
    }
    
    //User controller
    public function activeUser(){
        $customer   = BetUser::where(['status'=>5])->orderBy('updated_at','DESC')->get();
        return view('admin.activeUser',['customer'=>$customer]);
    }
    
    public function searchUser(){
        // $customer   = BetUser::where(['status'=>5])->orderBy('updated_at','DESC')->get();
        return view('admin.searchUser');
    }
    
    public function singleUser(Request $requ){
        $customer   = BetUser::where('userid',$requ->userid)->orWhere('email',$requ->userid)->first();
        return view('admin.singleUser',['customer'=>$customer]);
    }
    
    public function bannedUser(){
        $customer   = BetUser::where(['status'=>4])->orderBy('updated_at','DESC')->get();
        return view('admin.bannedUser',['customer'=>$customer]);
    }
    
    public function editUser($id){
        $customer   = BetUser::find($id);
        return view('admin.editUser',['customer'=>$customer]);
    }
    
    public function changePassword($id){
        $customer   = BetUser::find($id);
        return view('admin.changePassword',['customer'=>$customer]);
    }
    
    public function bannedStatus($id){
        $customer   = BetUser::find($id);
        if(count($customer)>0):
            $customer->status = 4;
            $customer->save();
            return redirect(route('bannedUser'))->with('success','Status update successful');
        else:
            return redirect(route('activeUser'))->with('error','Status update failed');
        endif;
    }
    
    public function activeStatus($id){
        $customer   = BetUser::find($id);
        if(count($customer)>0):
            $customer->status = 5;
            $customer->save();
            return redirect(route('activeUser'))->with('success','Status update successful');
        else:
            return redirect(route('bannedUser'))->with('error','Status update failed');
        endif;
    }
    
    public function delUser($id){
        $customer   = BetUser::find($id);
        if(count($customer)>0):
            $customer->delete();
            return back()->with('success','User profile delete successful');
        else:
            return back()->with('error','User profile deletion failed');
        endif;
    }
    
    public function a2cTransfer($id){
        $customer   = BetUser::find($id);
        return view('admin.a2cTransfer',['customer'=>$customer]);
    }
    
    public function a2aTransfer($id){
        $customer   = BetUser::find($id);
        return view('admin.a2aTransfer',['customer'=>$customer]);
    }
    
    
    //deposit list
    public function pendingDeposit(){
        $deposit   = Deposit::where(['status'=>'Pending'])->orderBy('updated_at','DESC')->get();
        return view('admin.pendingDeposit',['deposit'=>$deposit]);
    }
    public function paidDeposit(){
        $deposit   = Deposit::where(['status'=>'Accept'])->orderBy('updated_at','DESC')->get();
        return view('admin.paidDeposit',['deposit'=>$deposit]);
    }
    public function unpaidDeposit(){
        $deposit   = Deposit::where(['status'=>'Unpaid'])->orderBy('updated_at','DESC')->get();
        return view('admin.unpaidDeposit',['deposit'=>$deposit]);
    }
    
    //Withdrawal list
    public function checkUserStmt($id){
        $details = BetUser::find($id);
        $statement   = BetUserStatement::where(['user'=>$id])->orderBy('updated_at','DESC')->get();
        return view('admin.userStatement',['statement'=>$statement,'details'=>$details]);
    }
    
    //Withdrawal controller
    public function acceptWithdrawal($id){
        //where(function ($query) {$query->where('a', '=', 1)->orWhere('b', '=', 1);})->where(function ($query) {$query->where('c', '=', 1)->orWhere('d', '=', 1);});
        $chk    = WithdrawalRequest::where(['id'=>$id])->where(function($query) {
            $query->where(['status'=>"Pending"])->orWhere(['status'=>"Processing"]);
        })->get();
        
        if(count($chk)>0):
            foreach($chk as $ck):
                $getData = WithdrawalRequest::find($ck->id);
            endforeach;
        else:
            $getData = 0;
        endif;
        return view('admin.acceptWithdrawal',['getData'=>$getData]);
    }
    
    public function pendingWithdrawal(){
        $withdraw   = WithdrawalRequest::where(['status'=>'Pending'])->orderBy('updated_at','DESC')->get();
        return view('admin.withdrawalRequest',['withdraw'=>$withdraw]);
    }
    
    public function paidWithdrawal(){
        $withdraw   = WithdrawalRequest::where(['status'=>'Paid'])->orderBy('updated_at','DESC')->get();
        return view('admin.paidWithdrawal',['withdraw'=>$withdraw]);
    }
    
    public function unpaidWithdrawal(){
        $withdraw   = WithdrawalRequest::where(['status'=>'Unpaid'])->orderBy('updated_at','DESC')->get();
        return view('admin.unpaidWithdrawal',['withdraw'=>$withdraw]);
    }
    
    public function processWithdrawRequest(){
        $withdraw   = WithdrawalRequest::where(['status'=>'Processing'])->orderBy('updated_at','DESC')->get();
        return view('admin.processWithdrawRequest',['withdraw'=>$withdraw]);
    }
    
    public function rejToPenWithdraw($id){
        $withdraw   = WithdrawalRequest::find($id);
        if(!empty($withdraw)):
            $withdraw->status = 'Pending';
            $withdraw->save();
            return redirect(route('pendingWithdrawal'))->with('error','Withdrawal request return to pending list successfully');
        else:
            return back()->with('error','Operation failed to generate');
        endif;
    }
    
    //Club Withdrawal list
    public function checkClubStmt($id){
        $statement   = ClubStatement::where(['club'=>$id])->orderBy('updated_at','DESC')->get();
        return view('admin.clubStatement',['statement'=>$statement]);
    }
    
    //Club Withdrawal controller
    public function clubAcceptWithdraw($id){
        $chk    = ClubWithdraw::where(['id'=>$id])->where(function($query) {
            $query->where(['status'=>"Pending"])->orWhere(['status'=>"Processing"]);
        })->get();
        
        if(count($chk)>0):
            foreach($chk as $ck):
                $getData = ClubWithdraw::find($ck->id);
            endforeach;
        else:
            $getData = 0;
        endif;
        return view('admin.clubAcceptWithdraw',['getData'=>$getData]);
    }
    
    public function clubPendingWithdraw(){
        $withdraw   = ClubWithdraw::where(['status'=>'Pending'])->orderBy('updated_at','DESC')->get();
        return view('admin.clubPendingWithdraw',['withdraw'=>$withdraw]);
    }
    
    public function clubPaidWithdraw(){
        $withdraw   = ClubWithdraw::where(['status'=>'Paid'])->orderBy('updated_at','DESC')->get();
        return view('admin.clubPaidWithdraw',['withdraw'=>$withdraw]);
    }
    
    public function clubUnpaidWithdraw(){
        $withdraw   = ClubWithdraw::where(['status'=>'Unpaid'])->orderBy('updated_at','DESC')->get();
        return view('admin.clubUnpaidWithdraw',['withdraw'=>$withdraw]);
    }
    
    public function clubProcessWithdrawList(){
        $withdraw   = ClubWithdraw::where(['status'=>'Processing'])->orderBy('updated_at','DESC')->get();
        return view('admin.clubProcessWithdrawList',['withdraw'=>$withdraw]);
    }
    
    //Slider controller
    public function newSlider(){
        return view('admin.newSlider');
    }
    
    public function sliderList(){
        $slider   = Slider::all();
        return view('admin.sliderList',['slider'=>$slider]);
    }
    
    public function editSlider($id){
        $slider   = Slider::find($id);
        return view('admin.editSlider',['slider'=>$slider]);
    }
    
    public function deleteSlider($id){
        $slider   = Slider::find($id);
        if(count($slider)>0):
            $slider->delete();
            return back()->with('success','Success! Slider deleted successfully');
        else:
            return back()->with('error','Sorry! No slider found to delete');
        endif;
    }
    
    //Category controller
    public function newCategory(){
        return view('admin.newCategory');
    }
    
    public function categoryList(){
        $category   = Category::all();
        return view('admin.categoryList',['category'=>$category]);
    }
    
    public function editCategory($id){
        $category   = Category::find($id);
        return view('admin.editCategory',['category'=>$category]);
    }
    
    public function deleteCategory($id){
        $category   = Category::find($id);
        if(count($category)>0):
            $category->delete();
            return back()->with('success','Success! Category deleted successfully');
        else:
            return back()->with('error','Sorry! No category found to delete');
        endif;
    }
    
    //Team controller
    public function newTeam(){
        return view('admin.newTeam');
    }
    
    public function teamList(){
        $team   = Team::all();
        return view('admin.teamList',['team'=>$team]);
    }
    
    public function editTeam($id){
        $team   = Team::find($id);
        return view('admin.editTeam',['team'=>$team]);
    }
    
    public function deleteTeam($id){
        $team   = Team::find($id);
        if(count($team)>0):
            $team->delete();
            return back()->with('success','Success! Team deleted successfully');
        else:
            return back()->with('error','Sorry! No team found to delete');
        endif;
    }
    
    //Tournament controller
    public function newTournament(){
        return view('admin.newTournament');
    }
    
    public function tournamentList(){
        $tournament   = Tournament::all();
        return view('admin.tournamentList',['tournament'=>$tournament]);
    }
    
    public function editTournament($id){
        $tournament   = Tournament::find($id);
        return view('admin.editTournament',['tournament'=>$tournament]);
    }
    
    public function deleteTournament($id){
        $tournament   = Tournament::find($id);
        if(count($tournament)>0):
            $tournament->delete();
            return back()->with('success','Success! Tournament deleted successfully');
        else:
            return back()->with('error','Sorry! No tournament found to delete');
        endif;
    }
    
    //Club controller
    public function newClub(){
        return view('admin.newClub');
    }
    
    public function clubList(){
        $club   = BettingClub::all();
        return view('admin.clubList',['club'=>$club]);
    }
    
    public function editClub($id){
        $club   = BettingClub::find($id);
        return view('admin.editClub',['club'=>$club]);
    }
    
    public function deleteClub($id){
        $club   = BettingClub::find($id);
        if(count($club)>0):
            $club->delete();
            return back()->with('success','Success! Club deleted successfully');
        else:
            return back()->with('error','Sorry! No club found to delete');
        endif;
    }
    
    public function bannedClub($id){
        $club   = BettingClub::find($id);
        if(count($club)>0):
            $club->status   = 4;
            $club->save();
            return back()->with('success','Success! Club banned successfully');
        else:
            return back()->with('error','Sorry! No club found to banned');
        endif;
    }
    
    public function activeClub($id){
        $club   = BettingClub::find($id);
        if(count($club)>0):
            $club->status   = 5;
            $club->save();
            return back()->with('success','Success! Club active successfully');
        else:
            return back()->with('error','Sorry! No club found to active');
        endif;
    }
    
    //Match controller
    public function newMatch(){
        return view('admin.newMatch');
    }
    
    public function matchList($catId){
        $match   = Matche::where(['category'=>$catId])->where(function($query){
            $query->where(['status'=>1]);
            $query->orWhere(['status'=>2]);
            $query->orWhere(['status'=>3]);
        })->get();
        $admindetails   = AdminUser::find(Session::get('BetAdmin'));
        return view('admin.matchList',['match'=>$match,'catId'=>$catId,'adminDetails'=>$admindetails]);
    }
    
    public function finishMatchList($catId){
        $match   = Matche::where(['category'=>$catId,'status'=>5])->get();
        $admindetails   = AdminUser::find(Session::get('BetAdmin'));
        return view('admin.finishMatchList',['match'=>$match,'catId'=>$catId,'adminDetails'=>$admindetails]);
    }
    
    public function matchBetHistory($id){
        $match  = Matche::find($id);
        $catId  = $match->category;
        
    /** $bets   = UserBet::where(['matchid'=>$id])->where(function($query) {
     		$query->where(['status'=>1])
     		->orWhere(['status'=>2]);
     	})->get();**/
    
        $bets   = UserBet::where(['matchId'=>$id])->get();
        return view('admin.matchBetHistory',['bets'=>$bets,'catId'=>$catId,'match'=>$match]);
    }
    
    public function profitLoss($id){
        $match  = Matche::find($id);
        $catId  = $match->category;
        //Bet User details
        $schistory      = UserBet::where(['matchId'=>$match->id])->where(function($query){
            $query->where(['status'=>1]);
            $query->orWhere(['status'=>2]);
        })->get();
        $betUser        = UserBet::where(['matchId'=>$id])->get();
        $betAmount      = $betUser->sum('betAmount');
        //Bet Return details
        $betReturn        = UserBet::where(['matchId'=>$id,'status'=>3])->whereNotNull('betReturnAmount')->get();
        $betReturnAmount      = $betReturn->sum('betReturnAmount');
        //Unpublish Details
        $unpublishItem  = UserBet::where(['matchId'=>$id,'status'=>1])->get();
        $unpublishAmount= $unpublishItem->sum('betAmount');
        //user/site profit details
        $betProfitAmount     = UserBet::where('matchId',$id)->whereNotNull('userProfit')->whereNotNull('winAnswer')->sum('betAmount');
        $userGet     = UserBet::where(['matchId'=>$id])->whereNotNull('userProfit')->whereNotNull('winAnswer')->sum('userProfit');
        
        
        $userProfit  = $userGet-$betProfitAmount;
        // $userProfit  = $userGet;
        
        
        $siteProfit     = UserBet::where(['matchId'=>$id])->whereNotNull('siteProfit')->whereNotNull('winAnswer')->sum('siteProfit');
        //sponsor and club details
        $clubGetPaid    = $schistory->sum('club');
        $sponsorBonus   = $schistory->sum('sponsor');
        //Pertial Amount
        $pertialAmount  = UserBet::where(['matchId'=>$id])->whereNotNull('partialAmount')->sum('partialAmount');
        
        
        return view('admin.profitLoss',['betUser'=>$betUser,'catId'=>$catId,'match'=>$match,'userProfit'=>$userProfit,'siteProfit'=>$siteProfit,'unpublishItem'=>$unpublishItem,'unpublishAmount'=>$unpublishAmount,'betAmount'=>$betAmount,'clubGetPaid'=>$clubGetPaid,'sponsorBonus'=>$sponsorBonus,'betReturn'=>$betReturn,'betReturnAmount'=>$betReturnAmount,'pertialAmount'=>$pertialAmount]);
    }
    
    public function questionBetHistory($matchid,$quesId,$betOn){
        $match  = Matche::find($matchid);
        $catId  = $match->category;
        return view('admin.questionBetHistory',['catId'=>$catId,'match'=>$match,'optionId'=>$quesId]);
    }
    
    public function editMatch($id){
        $match   = Matche::find($id);
        return view('admin.editMatch',['match'=>$match]);
    }
    
    //Bet Option controller
    public function newBetOption(){
        return view('admin.newBetOption');
    }
    
    public function betOptions(){
        $option   = BetOption::all();
        return view('admin.optionList',['option'=>$option]);
    }
    
    public function editBetOption($id){
        $option   = BetOption::find($id);
        return view('admin.editBetOption',['option'=>$option]);
    }
    
    public function deleteBetOption($id){
        $option   = BetOption::find($id);
        if(count($option)>0):
            $option->delete();
            return back()->with('success','Success! Option deleted successfully');
        else:
            return back()->with('error','Sorry! No option found to delete');
        endif;
    }
    
    //Bet Answer controller
    public function newBetAnswer(){
        return view('admin.newBetAnswer');
    }
    
    public function betAnswer(){
        $answer   = BetAnswer::orderBy('updated_at','DESC')->get();
        return view('admin.answerList',['answer'=>$answer]);
    }
    
    public function editBetAnswer($id){
        $answer   = BetAnswer::find($id);
        return view('admin.editBetAnswer',['answer'=>$answer]);
    }
    
    public function deleteBetAnswer($id){
        $answer   = BetAnswer::find($id);
        if(count($answer)>0):
            $answer->delete();
            return back()->with('success','Success! Anser deleted successfully');
        else:
            return back()->with('error','Sorry! No answer found to delete');
        endif;
    }
    
    //Match bet option manager controller
    public function newMatchQuestion(){
        return view('admin.newMatchQuestion');
    }
    
    
    public function liveRoom($id){
        $MatchQuestion   = MatchQuestion::orderBy('updated_at','DESC')->get();
        $match  = Matche::find($id);
        $teamA = Team::find($match->teamA);
        $teamB = Team::find($match->teamB);
        $category   = Category::find($match->category);
        return view('admin.liveRoom',['MatchQuestion'=>$MatchQuestion,'match'=>$match,'cat'=>$category,'teamA'=>$teamA,'teamB'=>$teamB]);
    }
    
    public function matchManage($id){
        $MatchQuestion   = MatchQuestion::orderBy('updated_at','DESC')->get();
        $match  = Matche::find($id);
        $teamA = Team::find($match->teamA);
        $teamB = Team::find($match->teamB);
        $category   = Category::find($match->category);
        return view('admin.matchManage',['MatchQuestion'=>$MatchQuestion,'match'=>$match,'cat'=>$category,'teamA'=>$teamA,'teamB'=>$teamB]);
    }
    
    public function unpublishQuestion($id){
        $MatchQuestion   = MatchQuestion::orderBy('updated_at','DESC')->get();
        $match  = Matche::find($id);
        $teamA = Team::find($match->teamA);
        $teamB = Team::find($match->teamB);
        $category   = Category::find($match->category);
        return view('admin.unpublishQuestion',['MatchQuestion'=>$MatchQuestion,'match'=>$match,'cat'=>$category,'teamA'=>$teamA,'teamB'=>$teamB]);
    }
    
    public function editMatchQuestion($id){
        $MatchQuestion   = MatchQuestion::find($id);
        return view('admin.editMatchQuestion',['MatchQuestion'=>$MatchQuestion]);
    }
    
    public function deleteSingleQuestion($id){
        $singleDelete   = FixedQuestion::find($id);
        if(count($singleDelete)>0):
            $singleDelete->delete();
            return back()->with('success','Success! Question deleted successfully');
        else:
            return back()->with('error','Sorry! No question found to delete');
        endif;
    }
    
    public function deleteCustomQuestion($id){
        $MatchQuestion   = MatchQuestion::find($id);
        if(count($MatchQuestion)>0):
            $MatchQuestion->delete();
            return back()->with('success','Success! Question deleted successfully');
        else:
            return back()->with('error','Sorry! No question found to delete');
        endif;
    }
    
    
    //Get Data Controller
    public function getTournament($id){
        $tournament = Tournament::where(['catId'=>$id])->orderBy('created_at','DESC')->get();
        return view('admin.getTrounament',['tournament'=>$tournament]);
    }
    public function getTeam($id){
        $team = Team::where(['catId'=>$id])->orderBy('created_at','ASC')->get();
        return view('admin.getTeam',['team'=>$team]);
    }
    public function getEditTeam($id,$teamA,$teamB){
        $team = Team::where(['catId'=>$id])->orderBy('created_at','ASC')->get();
        return view('admin.getEditTeam',['team'=>$team,'teamB'=>$teamB,'teamA'=>$teamA]);
    }
    
    public function getOption($id){
        $option = BetOption::where(['catId'=>$id,'optType'=>3])->orderBy('created_at','ASC')->get();
        return view('admin.getOption',['option'=>$option]);
    }
    
    public function getOptionAnswer($id,$qId){
        $option = BetOption::where(['catId'=>$id,'optType'=>$qId])->orderBy('created_at','ASC')->get();
        return view('admin.getOptionAnswer',['option'=>$option]);
    }
    
    public function getFixedOption($id,$qId){
        $option = BetOption::where(['catId'=>$id,'optType'=>$qId])->orderBy('created_at','ASC')->get();
        return view('admin.getOptionAnswer',['option'=>$option,'qId'=>$qId]);
    }
    
    public function getAnswerList($id){
        $answer = BetAnswer::where(['optId'=>$id])->orderBy('created_at','ASC')->get();
        return view('admin.getAnswerList',['answer'=>$answer]);
    }
    
    
}
