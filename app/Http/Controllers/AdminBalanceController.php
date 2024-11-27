<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServerCoin;
use App\Models\AdminUser;
use App\Models\AdminBalanceHistory;
use Session;

class AdminBalanceController extends Controller
{
    public function __construct(){
        $this->middleware('BetAdmin');
    }
    
    public function serverCoin(){
        $adminDetails   = AdminUser::find(Session::get('BetAdmin'));
        $coin   = ServerCoin::all();
        return view('admin.serverCoin')->with(['coin'=>$coin,'adminDetails'=>$adminDetails]);
    }
    
    public function createServerCoin(Request $requ){
        $newCoin    = new ServerCoin();
        $newCoin->amount= $requ->coinAmount;
        $adminDetails   = AdminUser::find(Session::get('BetAdmin'));
        $newAdminBal    = $adminDetails->accountBalance+$requ->coinAmount;
        $adminDetails->accountBalance   = $newAdminBal;
        if($newCoin->save()):
            $adminDetails->save();
            return back()->with('success','Success! Coin amount created successfully');
        else:
            return back()->with('error','Sorry! Coin amount created failed');
        endif;
    }
    
    //Other admin balance management
    public function adminCoin(){
        $coin   = AdminBalanceHistory::all();
        return view('admin.adminCoin')->with(['coin'=>$coin]);
    }
    
    public function createAdminCoin(Request $requ){
        $newCoin            = new AdminBalanceHistory();
        $SADetails          = AdminUser::find(Session::get('BetAdmin'));
        $newCoin->amount    = $requ->coinAmount;
        $newCoin->adminid   = $requ->adminId;
        $newCoin->generateBy= $SADetails->adminid;
        
        //super admin balance update
        $newSAdminBal    = $SADetails->accountBalance-$requ->coinAmount;
        $SADetails->accountBalance   = $newSAdminBal;
        
        //admin balance update
        $adminDetails   = AdminUser::find($requ->adminId);
        $newAdminBal    = $adminDetails->accountBalance+$requ->coinAmount;
        $adminDetails->accountBalance   = $newAdminBal;
        if($newCoin->save()):
            $adminDetails->save();
            $SADetails->save();
            return back()->with('success','Success! Account recharge successfully');
        else:
            return back()->with('error','Sorry! Account recharge failed');
        endif;
    }
}
