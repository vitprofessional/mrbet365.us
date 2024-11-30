<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BetUser;
use App\Models\BettingClub;
use App\Models\AdminUser;
use App\Models\SiteConfig;
use Hash;
use Session;

class FrontController extends Controller
{
    public function frontHome(){
        $sd    = SiteConfig::all();
        if(count((array)$sd)>0):
            foreach($sd as $ds):
                $sdid   = $ds->id;
            endforeach;
            $siteDetails = SiteConfig::find($sdid);
        endif;
        return view('front-ui.home',['siteDetails'=>$siteDetails]);
        //return "Text here";
    }
    public function advanceBet(){
        $sd    = SiteConfig::all();
        if(count((array)$sd)>0):
            foreach($sd as $ds):
                $sdid   = $ds->id;
            endforeach;
            $siteDetails = SiteConfig::find($sdid);
        endif;
        return view('front-ui.advanceBet',['siteDetails'=>$siteDetails]);
        //return "Text here";
    }
    //User login function
    public function userLogin(){
        return view('front-ui.userlogin');
    }
    
    public function confirmLogin(Request $requ){
        $userid = strtolower($requ->userId);
        $betuser = BetUser::where(['email'=>$userid])->orWhere(['userid'=>$userid])->first();
        if(count((array)$betuser)>0):
            if($betuser->status==5):
                $hashpass  = $betuser->hashpassword;
                $sessionid  = $betuser->id;
            	$authuser = Hash::check($requ->loginPass,$hashpass);
                if($authuser):
                    session_start();
                    Session::regenerate();
                    Session::put('betuser',$sessionid);
                    Session::get('betuser');
                    $_SESSION['betuser']   = $sessionid;
            	    return redirect(url('/'));
            	else:
            	    return redirect(route('userLogin'))->with('error','Sorry! Wrong password provide');
            	endif;
            else:
                return redirect(route('userLogin'))->with('error','Sorry! You are banned from our site. Please contact support for more info');
            endif;
        else:
            return redirect(route('userLogin'))->with('error','Sorry! User not exist on our database.');
        endif;
    }
    
    
    //User register function
    public function userRegister(){
        return view('front-ui.userregister');
    }
    
    public function confirmRegister(Request $requ){
        if($requ->password != $requ->conPass):
            return redirect(route('userRegister'))->with('error','Sorry! Confirm password does not match');
        else:
            $userid     = strtolower($requ->userId);
            $usermail   = strtolower($requ->email);
            $betuser =   BetUser::where(['email'=>$usermail])->orWhere(['userid'=>$userid])->get();
            if(count((array)$betuser)>0):
                return redirect(route('userRegister'))->with('error','Sorry! UserID or Email already exist on our system');
            else:
                $hashpass   = Hash::make($requ->password);
                $betuser = new BetUser();
                $betuser->userid        = $userid;
                $betuser->email         = $usermail;
                $betuser->plainpassword = $requ->password;
                $betuser->hashpassword  = $hashpass;
                $betuser->phone         = $requ->phoneNumber;
                $betuser->country       = $requ->country;
                $betuser->sponsor       = $requ->sponsor;
                $betuser->club          = $requ->club;
                if($betuser->save()):
                    return redirect(route('userLogin'))->with('success','Congratulation! Account created sucessfully. Please login to continue');
                else:
                    return redirect(route('userRegister'))->with('error','Sorry! Account creation failed. Please try later');
                endif;
            endif;
        endif;
    }
    //Club Controller
    
    
    //login function
    public function clubLogin(){
        Session::flush();
        Session()->regenerate();
        session_start();
        session_destroy();
        //session_regenerate();
        return view('front-ui.clubLogin');
    }
    
    public function confirmClubLogin(Request $requ){
        $club = BettingClub::where(['email'=>$requ->clubId])->orWhere(['clubId'=>$requ->clubId])->first();
        if(count((array)$club)>0):
            if($club->status==5):
                $hashpass   = $club->hashpassword;
                $sessionid  = $club->id;
            	$authuser = Hash::check($requ->loginPass,$hashpass);
                if($authuser):
                    session_start();
                    Session::regenerate();
                        Session::put('BettingClub',$sessionid);
                        Session::get('BettingClub');
                        $_SESSION['BettingClub'] = $sessionid;
            	    return redirect(route('clubHome'));
            	else:
            	    return back()->with('error','Sorry! Wrong password provide');
            	endif;
            else:
                return back()->with('error','Sorry! This club have no permission to login. Please contact admin for more info.');
            endif;
        else:
            return back()->with('error','Sorry! Club not exist on database.');
        endif;
    }
    
    //Admin Controller
    
    
    //login function
    public function adminLogin(){
        return view('front-ui.adminLogin');
    }
    
    public function confirmAdminLogin(Request $requ){
        $admin = AdminUser::where(['email'=>$requ->adminId])->orWhere(['adminid'=>$requ->adminId])->first();
        if(count((array)$admin)>0):
            if($admin->status=="Active"):
                $hashpass   = $admin->hashpass;
                $sessionid  = $admin->id;
                $adminrule  = $admin->rule;
            	$authuser = Hash::check($requ->loginPass,$hashpass);
                if($authuser):
                    session_start();
                    Session::regenerate();
                        Session::put('BetAdmin',$sessionid,'AdminRule',$adminrule);
                        Session::put('AdminRule',$adminrule);
                        Session::get('BetAdmin');
                        Session::get('AdminRule');
                        $_SESSION['BetAdmin'] = $sessionid;
                        $_SESSION['AdminRule']  = $adminrule;
            	    return redirect(route('AdminHome'));
            	else:
            	    return back()->with('error','Sorry! Wrong password provide');
            	endif;
            else:
                return back()->with('error','Sorry! Admin profile are inactive. Please contact super admin');
            endif;
        else:
            return back()->with('error','Sorry! Admin account not exist on our database.');
        endif;
    }
    
    public function confirmSuperAdminRegister(Request $requ){
        if($requ->loginPass != $requ->conPass):
            return back()->with('error','Sorry! Confirm password does not match');
        else:
            $admin =   AdminUser::where(['email'=>$requ->email])->orWhere(['adminid'=>$requ->userId])->get();
            if(count((array)$admin)>0):
                return back()->with('error','Sorry! AdminID or Email already exist on our system');
            else:
                $hashpass   = Hash::make($requ->loginPass);
                $admin = new AdminUser();
                //$betuser->fullname      = $requ->fullName;
                $admin->adminid     = $requ->adminId;
                $admin->email       = $requ->adminEmail;
                $admin->plainpass   = $requ->loginPass;
                $admin->hashpass    = $hashpass;
                $admin->phone       = $requ->phoneNumber;
                $admin->company     = $requ->company;
                if($admin->save()):
                    return back()->with('success','Congratulation! Account created sucessfully. Please login to continue');
                else:
                    return back()->with('error','Sorry! Account creation failed. Please try later');
                endif;
            endif;
        endif;
    }
    
    //Logout controller
    
    public function userlogout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        session_start();
        session_destroy();
        //session_regenerate();
        return redirect(route('userLogin'))->with('error','Successfully logout!');
    }
    
    public function adminlogout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        session_start();
        session_destroy();
        //session_regenerate();
        return redirect(route('adminLogin'))->with('error','Successfully logout!');
    }
    
    public function clublogout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        session_start();
        session_destroy();
        //session_regenerate();
        return redirect(route('clubLogin'))->with('error','Successfully logout!');
    }
}
