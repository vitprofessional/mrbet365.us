<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\BetUser;
use App\Models\BetUserStatement;
use App\Models\Deposit;
use App\Models\WithdrawalRequest;
use App\Models\CoinTransfer;
use App\Models\UserBet;

class UserViewController extends Controller
{
    public function __construct(){
        $this->middleware('betuser');
    }
    
    public function userdash(){
        $details = BetUser::find(Session::get('betuser'));
        return view('userpanel.home',['details'=>$details]);
    }
    
    public function userprofile(){
        $details = BetUser::find(Session::get('betuser'));
        return view('userpanel.profile',['details'=>$details]);
    }
    
    public function changeMyPass(){
        $details = BetUser::find(Session::get('betuser'));
        return view('userpanel.changeUserPass',['details'=>$details]);
    }
    
    public function changeMyClub(){
        $details = BetUser::find(Session::get('betuser'));
        return view('userpanel.changeUserClub',['details'=>$details]);
    }
    
    //Deposit controller
    public function makeDeposit(){
        return view('userpanel.makeDeposit');
    }
    
    public function depositHistory(){
        $details = BetUser::find(Session::get('betuser'));
        $history = Deposit::where(['user'=>$details->id])->orderBy('updated_at', 'desc')->get();
        return view('userpanel.depositHistory',['details'=>$details,'history'=>$history]);
    }
    
    public function myFollowerList(){
        $profile = BetUser::find(Session::get('betuser'));
        $Details = BetUser::where(['sponsor'=>$profile->userid])->orderBy('updated_at','DESC')->get();
        return view('userpanel.myFollowerList',['Details'=>$Details]);
    }
    //Betting history
    public function betHistory(){
        $betData = UserBet::where(['user'=>Session::get('betuser')])->orderBy('updated_at', 'desc')->get();
        return view('userpanel.bettingHistory',['betData'=>$betData]);
    }
    //account statement history
    public function customerAccountStmt(){
        $details = BetUser::find(Session::get('betuser'));
        $stmt = BetUserStatement::where(['user'=>Session::get('betuser')])->orderBy('id','DESC')->get();
        return view('userpanel.statement',['stmt'=>$stmt,'details'=>$details]);
    }
    
    //Withdrawal controller
    public function makeWithdraw(){
        return view('userpanel.makeWithdraw');
    }
    
    public function withdrawHistory(){
        $details = BetUser::find(Session::get('betuser'));
        $history = WithdrawalRequest::where(['user'=>$details->id])->orderBy('updated_at', 'desc')->get();
        return view('userpanel.withdrawHistory',['details'=>$details,'history'=>$history]);
    }
    
    //Coin 2 Coin Transfer controller
    public function makeC2CTransfer(){
        return view('userpanel.makeC2CTransfer');
    }
    
    public function C2CTransferHistory(){
        $details = BetUser::find(Session::get('betuser'));
        $history = CoinTransfer::where(['user'=>$details->id])->orderBy('updated_at', 'desc')->get();
        return view('userpanel.C2CTransferHistory',['details'=>$details,'history'=>$history]);
    }
    
    public function C2CReceivingHistory(){
        $details = BetUser::find(Session::get('betuser'));
        $history = CoinTransfer::where(['c2cUser'=>$details->userid])->orderBy('updated_at', 'desc')->get();
        return view('userpanel.C2CReceivingHistory',['details'=>$details,'history'=>$history]);
    }
}
