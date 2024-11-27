<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminUser;
use App\Models\SiteConfig;
use Session;
use DB;
use Hash;

class AdminSystemManageController extends Controller
{
    public function __construct(){
        $this->middleware('BetAdmin');
    }
    
    public function serverConfig(){
        $sitedetails   = SiteConfig::all();
        return view('admin.serverConfig',['sitedetails'=>$sitedetails]);
    }
    
    //Admin System Manage controller
    public function newAdminProfile(){
        return view('admin.newAdminProfile');
    }
    
    public function manageAdmin(){
        $data[] = Session::get('BetAdmin');
        $adminUser   = AdminUser::whereNotIn('id',$data)->get();
        return view('admin.manageAdmin',['adminUser'=>$adminUser]);
    }
    
    public function editAdminProfile($id){
        $adminUser   = AdminUser::find($id);
        return view('admin.editAdminProfile',['adminUser'=>$adminUser]);
    }
    
    public function deleteAdminProfile($id){
        $adminUser   = AdminUser::find($id);
        if(count($adminUser)>0):
            $adminUser->delete();
            return back()->with('success','Success! Admin profile deleted successfully');
        else:
            return back()->with('error','Sorry! No data found to delete');
        endif;
    }
    
    public function inactiveAdminProfile($id){
        $adminUser   = AdminUser::find($id);
        if(count($adminUser)>0):
            $adminUser->status = "Inactive";
            $adminUser->save();
            return back()->with('success','Success! Profile status changed sucessfully');
        else:
            return back()->with('error','Sorry! No data found to update');
        endif;
    }
    
    public function activeAdminProfile($id){
        $adminUser   = AdminUser::find($id);
        if(count($adminUser)>0):
            $adminUser->status = "Active";
            $adminUser->save();
            return back()->with('success','Success! Profile status changed sucessfully');
        else:
            return back()->with('error','Sorry! No data found to update');
        endif;
    }
    
    public function saveAdminProfile(Request $requ){
        $existAdmin = AdminUser::where(['adminid'=>$requ->adminId])->orWhere(['email'=>$requ->email])->first();
        if(count($existAdmin)>0):
            if($existAdmin->adminid == $requ->adminId):
                return back()->with('error','Sorry! Admin '.$requ->adminId.' account already exist');
            else:
                return back()->with('error','Sorry! Admin '.$requ->email.' account already exist');
            endif;
        else:
            $hashPass   = Hash::make($requ->adminPass);
            $newAdmin   = new AdminUser();
            $newAdmin->adminid  = $requ->adminId;
            $newAdmin->email    = $requ->email;
            $newAdmin->phone    = $requ->mobile;
            $newAdmin->rule     = $requ->adminRule;
            $newAdmin->plainpass= $requ->adminPass;
            $newAdmin->hashpass = $hashPass;
            $newAdmin->status   = $requ->status;
            if($newAdmin->save()):
                return back()->with('success','Success! Admin profile creation successful');
            else:
                return back()->with('error','Sorry! Admin profile creation failed');
            endif;
        endif;
    }
    
    public function updateAdminProfile(Request $requ){
        $existAdmin = AdminUser::find($requ->adminProfileId);
        if(count($existAdmin)>0):
            $hashPass   = Hash::make($requ->adminPass);
            $existAdmin->adminid  = $requ->adminId;
            $existAdmin->email    = $requ->email;
            $existAdmin->phone    = $requ->mobile;
            $existAdmin->rule     = $requ->adminRule;
            $existAdmin->status   = $requ->status;
            
            //If password field have data it will update
            if(!empty($requ->adminPass)):
                $existAdmin->plainpass= $requ->adminPass;
                $existAdmin->hashpass = $hashPass;
            endif;
            if($existAdmin->save()):
                return back()->with('success','Success! Admin profile update successful');
            else:
                return back()->with('error','Sorry! Admin profile update failed');
            endif;
        else:
            return back()->with('error','Sorry! Profile not found');
        endif;
    }
}
