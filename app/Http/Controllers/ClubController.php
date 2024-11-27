<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BettingClub;
use App\Models\BetUser;
use App\Models\SiteConfig;
use App\Models\ClubStatement;
use App\Models\ClubWithdraw;
use Session;
use Hash;

class ClubController extends Controller
{
    public function __construct(){
        $this->middleware('BettingClub');
    }
    
    public function home(){
        $clubDetails = BettingClub::find(Session::get('BettingClub'));
        return view('club.home',['clubDetails'=>$clubDetails]);
    }
    
    public function clubSettings(){
        $clubDetails = BettingClub::find(Session::get('BettingClub'));
        return view('club.profile',['clubDetails'=>$clubDetails]);
    }
    
    public function makeClubWithdraw(){
        $clubDetails = BettingClub::find(Session::get('BettingClub'));
        return view('club.makeWithdraw',['clubDetails'=>$clubDetails]);
    }
    
    //Withdrawal request controller
    public function submitClubWithdraw(Request $requ){
        $profile    = BettingClub::find(Session::get('BettingClub'));
        if(count($profile)>0):
            $hashpass   = $profile->hashpassword;
        	$authclub = Hash::check($requ->password,$hashpass);
            if(count($authclub)>0):
                $siteConfig = SiteConfig::orderBy('id', 'desc')->first();
                if($profile->balance<$requ->amount):
                    return back()->with('error','Sorry! You do not have enough balance to withdraw');
                else:
                    if($requ->amount>$siteConfig->maxWithdraw || $requ->amount<$siteConfig->minWithdraw):
                        return back()->with('error','Sorry! Can not possible to withdraw less then '. $siteConfig->minWithdraw.' & more then '. $siteConfig->maxWithdraw);
                    else:
                        $withdraw    = new ClubWithdraw();
                            
                        //update Main Balance
                        $newmainbalance = $profile->balance - $requ->amount;
                        $profile->balance = $newmainbalance;
                        
                        //Update user statement
                        $statement   = ClubStatement::where(['club'=>$profile->id])->get()->last();
                        
                        if(count($statement)>0):
                            $stmtBal    = $statement->currentBalance;
                        else:
                            $stmtBal    = $profile->balance;
                        endif;
                        //Create statement
                        $statement= new ClubStatement();
                        $statement->club  = $profile->id;
                        //$statement = BetUserStatement::find($statement->id);
                        $statement->prevBalance  = $stmtBal;
                        $statement->currentBalance  = $newmainbalance;
                        $statement->transAmount  = $requ->amount;
                        $statement->note   = "Withdraw";
                        $statement->transType   = "Debit";
                        $statement->save();
                        //Statement table end
        
        
                        $withdraw->club          = $profile->id;
                        $withdraw->amount        = $requ->amount;
                        $withdraw->status        = "Pending";
                        if($profile->save()):
                            $withdraw->save();
                            return back()->with('success','Withdrawal request sent successful');
                        else:
                            return back()->with('error','Withdrawal request failed to sent');
                        endif;
                    endif;
                endif;
            else:
                return back()->with('error','Sorry! Wrong password provide');
            endif;
        endif;
    }
    
    public function clubWithdrawHistory($id){
        $stDetails = ClubWithdraw::where(['club'=>$id])->orderBy('updated_at','DESC')->get();
        //dd($stDetails);
        return view('club.withdrawHistory',['stDetails'=>$stDetails]);
    }
    
    public function clubStatement($id){
        $stDetails = ClubStatement::where(['club'=>$id])->orderBy('updated_at','DESC')->get();
        //dd($stDetails);
        return view('club.statement',['stDetails'=>$stDetails]);
    }
    
    public function clubFollower($clubid){
        $clDetails = BetUser::where(['club'=>$clubid])->orderBy('updated_at','DESC')->get();
        return view('club.followerList',['clDetails'=>$clDetails]);
    }
    
    public function clubDetailsUpdate(Request $requ){
        $chkMail    = BettingClub::where(['email'=>$requ->email])->get();
        if(count($chkMail)>0):
            return back()->with('error','Sorry! Email already exist with other club');
        else:
            $details    = BettingClub::find($requ->clubid);
            if(count($details)>0):
                if(!empty($requ->email)):
                    $details->email = $requ->email;
                endif;
                $details->phone = $requ->phoneNumber;
                if(!empty($requ->password)):
                    $hashpass   = Hash::make($requ->password);
                    $details->plainpassword     = $requ->password;
                    $details->hashpassword      = $hashpass;
                endif;
                $details->save();
                return back()->with('success','Details successfully update');
            else:
                return back()->with('error','Details failed to update');
            endif;
        endif;
    }
}
