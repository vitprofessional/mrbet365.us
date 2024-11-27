<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BetUser;
use App\Models\UserBet;
use App\Models\BetUserStatement;
use App\Models\Deposit;
use App\Models\Matche;
use App\Models\BettingClub;
use App\Models\ClubStatement;
use App\Models\AdminBalanceUsesHistory;
use App\Models\AdminUser;
use App\Models\ClubWithdraw;
use App\Models\Team;
use App\Models\Slider;
use App\Models\BetAnswer;
use App\Models\BetOption;
use App\Models\Tournament;
use App\Models\MatchQuestion;
use App\Models\MatchAnswer;
use App\Models\FixedQuestion;
use App\Models\SiteConfig;
use App\Models\WithdrawalRequest;
use App\Traits\UploadTrait;
use Session;
use DB;
use Hash;
use App\Events\BetUpdated;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class AdminPanelController extends Controller
{
    
    use UploadTrait;
    public function __construct(){
        $this->middleware('BetAdmin');
    }
    

    //
    public function saveConfig (Request $requ){
        $getData    = SiteConfig::find($requ->configID);
        if(empty($getData)):
            $getData   = new SiteConfig();
        endif;

        $getData->siteNotice        =$requ->siteNotice;
        $getData->depositMessage    =$requ->depositMessage;
        $getData->minBet            =$requ->minBet;
        $getData->minWithdraw       =$requ->minWithdraw;
        $getData->minClubWitdraw    =$requ->minClubWitdraw;
        $getData->maxClubWitdraw    =$requ->maxClubWitdraw;
        $getData->minDeposit        =$requ->minDeposit;
        $getData->minCoinTransfer   =$requ->minCoinTransfer;
        $getData->maxBet            =$requ->maxBet;
        $getData->maxWithdraw       =$requ->maxWithdraw;
        $getData->maxDeposit        =$requ->maxDeposit;
        $getData->maxCoinTransfer   =$requ->maxCoinTransfer;
        $getData->clubRate          =$requ->clubRate;
        $getData->sponsorRate       =$requ->sponsorRate;
        $getData->partialOne        =$requ->partialOne;
        $getData->partialTwo        =$requ->partialTwo;
        $getData->coinTransferStatus=$requ->coinTransferStatus;
        $getData->userBetStatus     =$requ->userBetStatus;
        $getData->userWithdrawStatus=$requ->withdrawalStatus;
        $getData->userDepositStatus =$requ->depositStatus;
        $getData->clubWithdrawStatus=$requ->clubWithdrawStatus;
        $getData->overBet           =$requ->overBet;
        $getData->underBet          =$requ->underBet;
        if($getData->save()):
            return back()->with('success','Sucess! Server update successfull');
        else:
            return back()->with('error','Sorry! Server update failed');
        endif;
    }

    //User controller
    public function updateUser(Request $requ){
        $profile    = BetUser::find($requ->profileid);
        if(count($profile)>0):
            $profile->userid    = $requ->userId;
            $profile->email     = $requ->email;
            if(!empty($requ->sponsor)):
                $profile->sponsor   = $requ->sponsor;
            endif;
            $profile->phone     = $requ->phoneNumber;
            if($profile->save()):
                return back()->with('success','Success! Profile updated successfully');
            else:
                return back()->with('error','Sorry! Profile updated filed to save');
            endif;
        else:
            return back()->with('error','Sorry! No profile to update');
        endif;
    }
    
    public function changeUserPass(Request $requ){
        if($requ->newpas!=$requ->conpass):
            return back()->with('error','Sorry! New password does not match with confirm password');
        else:
            $profile    = BetUser::find($requ->profileid);
            if(count($profile)>0):
                $hashpass   = Hash::make($requ->newpas);
                $profile->plainpassword = $requ->newpass;
                $profile->hashpassword  = $hashpass;
                if($profile->save()):
                    return back()->with('success','Success! Profile updated successfully');
                else:
                    return back()->with('error','Sorry! Profile updated filed to save');
                endif;
            else:
                return back()->with('error','Sorry! No profile to update');
            endif;
        endif;
    }
    
    public function confirmA2CTransfer(Request $requ){
        $profile        = BetUser::find($requ->profileid);
        $chkcustomer    = BetUser::where(['userid'=>$requ->customerId])->get();
        if(count($chkcustomer)>0):
            foreach($chkcustomer as $cu):
                $custprofileid  = $cu->id;
            endforeach;
            //Customer profile check for transfer balance
            $custprofile    = BetUser::find($custprofileid);
            if(count($profile)>0):
                //Customer new balance update
                $custnewbalance = $custprofile->balance+$requ->deductAmount; 
                $custprofile->balance = $custnewbalance; 
                
                //Update profile balance
                $newbalance = $profile->balance-$requ->deductAmount; 
                $profile->balance   = $newbalance;
                if($profile->save()):
                    $custprofile->save();
                    return back()->with('success','Success! A2C Transfer Successfully');
                else:
                    return back()->with('error','Sorry! A2C Transfer Failed to Successful');
                endif;
            else:
                return back()->with('error','Sorry! No profile found from transfer balance');
            endif;
        else:
            return back()->with('error','Sorry! No details found to transfer');
        endif;
    }
    
    public function confirmA2ATransfer(Request $requ){
        $profile    = BetUser::find($requ->profileid);
        if(count($profile)>0):
            $newbalance = $profile->balance-$requ->deductAmount;
            $profile->balance   = $newbalance;
            if($profile->save()):
                return back()->with('success','Success! A2C Transfer Successfully');
            else:
                return back()->with('error','Sorry! A2C Transfer Failed to Successful');
            endif;
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    //Deposit accept
    public function acceptDeposit($id){
        $chk    = Deposit::find($id);
        if(count($chk)>0):
            $profile = BetUser::find($chk->user);
            if(count($profile)>0):
                $adminAccount = AdminUser::find(Session::get('BetAdmin'));
                if(count($adminAccount)>0):
                    $adminBalance = $adminAccount->accountBalance;
                    $newAdminBalance    = $adminBalance-$chk->amount;
                    $adminAccount->accountBalance = $newAdminBalance;
                endif;
                $pbalance = $profile->balance;
                $newbalance = $pbalance+$chk->amount;
                $profile->balance = $newbalance;
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
                $statement->currentBalance  = $newbalance;
                $statement->transAmount  = $chk->amount;
                $statement->note   = "Deposit";
                $statement->transType   = "Credit";
                $statement->generateBy   = $adminAccount->id;
                $statement->save();
                //end statement
                if($adminAccount->save()):
                    
                    $adminStatement   = AdminBalanceUsesHistory::where(['adminid'=>$adminAccount->id])->get()->last();
                    if(count($adminStatement)>0):
                        $admstmtBal    = $adminStatement->currentBalance;
                    else:
                        $admstmtBal    = $adminBalance;
                    endif;
                    //Create statement
                    $adminStatement= new AdminBalanceUsesHistory();
                    $adminStatement->userid         = $profile->id;
                    $adminStatement->adminid        = $adminAccount->id;
                    $adminStatement->trnsId         = $id;
                    $adminStatement->prevBalance    = $admstmtBal;
                    $adminStatement->currentBalance = $newAdminBalance;
                    $adminStatement->trnsType       = "Deposit";
                    $adminStatement->amount         = $chk->amount;
                    $adminStatement->status         = "Complete";
                    $adminStatement->save();
                    //end statement
                    
                    $profile->save();
                    $chk->acceptBy  = $adminAccount->id;
                    $chk->status    = 'Accept';
                    $chk->save();
                    return redirect(route('pendingDeposit'))->with('success','Success! Balance update successfully');
                else:
                    return redirect(route('pendingDeposit'))->with('error','Sorry!Balance update failed');
                endif;
            else:
                return redirect(route('pendingDeposit'))->with('error','Sorry! No profile found to update');
            endif;
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    public function rejectDeposit($id){
        $chk    = Deposit::find($id);
        if(count($chk)>0):
            $chk->status    = 'Unpaid';
            $chk->save();
            return back()->with('error','Success! Deposit successfully rejected');
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    public function returnDeposit($id){
        $chk    = Deposit::find($id);
        if(count($chk)>0):
            $chk->status    = 'Pending';
            $chk->save();
            return back()->with('success','Success! Deposit profile updated successfully');
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    public function refundDeposit($id){
        $chk    = Deposit::find($id);
        if(count($chk)>0):
            $adminAccount = AdminUser::find(Session::get('BetAdmin'));
            if(count($adminAccount)>0):
                $adminBalance = $adminAccount->accountBalance;
                $newAdminBalance    = $adminBalance+$chk->amount;
                $adminAccount->accountBalance = $newAdminBalance;
            endif;
            $profile            = BetUser::find($chk->user);
            $newBalance         = $profile->balance-$chk->amount;
            $profile->balance   = $newBalance;
            if($adminAccount->save()):
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
                $statement->currentBalance  = $newBalance;
                $statement->transAmount  = $chk->amount;
                $statement->note   = "Deposit Return";
                $statement->transType   = "Debit";
                $statement->generateBy   = $adminAccount->id;
                $statement->save();
                //End bet user statement 
                //Admin Statement start
                $adminStatement   = AdminBalanceUsesHistory::where(['adminid'=>$adminAccount->id])->get()->last();
                if(count($adminStatement)>0):
                    $admstmtBal    = $adminStatement->currentBalance;
                else:
                    $admstmtBal    = $adminBalance;
                endif;
                //Create statement
                $adminStatement= new AdminBalanceUsesHistory();
                $adminStatement->userid         = $profile->id;
                $adminStatement->adminid        = $adminAccount->id;
                $adminStatement->trnsId         = $id;
                $adminStatement->prevBalance    = $admstmtBal;
                $adminStatement->currentBalance = $newAdminBalance;
                $adminStatement->trnsType       = "Deposit Return";
                $adminStatement->amount         = $chk->amount;
                $adminStatement->status         = "Complete";
                $adminStatement->save();
                //end statement
                $profile->save();
                $chk->status    = 'Pending';
                $chk->save();
                return back()->with('success','Success! Deposit profile updated successfully');
            else:
                return back()->with('error','Sorry! No data found');
            endif;
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    //Withdrawal controller
    public function processingWithdrawal($id){
        $chk    = WithdrawalRequest::find($id);
        if(count($chk)>0):
            $chk->status    = 'Processing';
            $chk->save();
            return back()->with('success','Success! Request enqueed for processing');
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    public function confirmWithdrawal(Request $requ){
        $chk    = WithdrawalRequest::find($requ->transid);
        if(count($chk)>0):
            $chk->status    = 'Paid';
            $chk->trans_id  = $requ->trans_id;
            $chk->acceptBy  = Session::get('BetAdmin');
            $chk->save();
            return redirect(route('processWithdrawRequest'))->with('success','Success! Withdrawal successfully complete');
        else:
            return back()->with('error','Sorry! No record found to update');
        endif;
    }
    
    public function rejectWithdrawal($id){
        $chk    = WithdrawalRequest::find($id);
        if(count($chk)>0):
            $profile = BetUser::find($chk->user);
            if(count($profile)>0):
                $pbalance   = $profile->balance;
                $nbalance   = $chk->amount+$pbalance;
                $profile->balance   = $nbalance;
                //Update user statement
                $statement   = BetUserStatement::where(['user'=>$chk->user])->get()->last();
                
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
                $statement->currentBalance  = $nbalance;
                $statement->transAmount  = $chk->amount;
                $statement->note   = "WithdrawReject";
                $statement->transType   = "Credit";
                //Statement table end
                if($profile->save()):
                    $statement->save();
                    $chk->status    = 'Unpaid';
                    $chk->save();
                    return back()->with('error','Success! Withdrawal request rejected successfully');
                else:
                    return back()->with('error','Sorry! Withdrawal request failed to reject');
                endif;
            else:
                return back()->with('error','Sorry! No profile found to update');
            endif;
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    //Club Withdrawal controller
    public function clubProcessWithdraw($id){
        $chk    = ClubWithdraw::find($id);
        if(count($chk)>0):
            $chk->status    = 'Processing';
            $chk->save();
            return back()->with('success','Success! Request enqueed for processing');
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    public function clubConfirmWithdraw(Request $requ){
        $chk    = ClubWithdraw::find($requ->transid);
        if(count($chk)>0):
            $chk->status    = 'Paid';
            $chk->trans_id  = $requ->trans_id;
                            
            //update Main Balance
            $club = BettingClub::find($chk->club);
            $profile = BetUser::where(['userid'=>$club->clubid])->first();
            $newmainbalance = $profile->balance + $chk->amount;
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
            $statement->transAmount  = $chk->amount;
            $statement->note   = "ClubWithdraw";
            $statement->transType   = "Credit";
            $statement->save();
            //Statement table end
            $profile->save();
            
            $chk->save();
            return redirect(route('clubPendingWithdraw'))->with('success','Success! Withdrawal successfully complete');
        else:
            return back()->with('error','Sorry! No record found to update');
        endif;
    }
    
    public function clubRejectWithdraw($id){
        $chk    = ClubWithdraw::find($id);
        if(count($chk)>0):
            $profile = BettingClub::find($chk->club);
            if(count($profile)>0):
                $pbalance   = $profile->balance;
                $nbalance   = $chk->amount+$pbalance;
                $profile->balance   = $nbalance;
                //Update user statement
                $statement   = ClubStatement::where(['club'=>$chk->club])->get()->last();
                
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
                $statement->currentBalance  = $nbalance;
                $statement->transAmount  = $chk->amount;
                $statement->note   = "WithdrawReject";
                $statement->transType   = "Credit";
                //Statement table end
                if($profile->save()):
                    $statement->save();
                    $chk->status    = 'Unpaid';
                    $chk->save();
                    return back()->with('success','Success! Withdrawal status updated successfully');
                else:
                    return back()->with('error','Sorry! Withdrawal status updated failed');
                endif;
            else:
                return back()->with('error','Sorry! No profile found to update');
            endif;
        else:
            return back()->with('error','Sorry! No profile found to update');
        endif;
    }
    
    //Category controller
    public function saveCategory(Request $requ){
        $chk    = Category::where(['name'=>$requ->catName])->get();
        if(count($chk)>0):
            return back()->with('error','Sorry! Category already exist');
        else:
            $category            =  new Category();// Form validation
    
            if ($requ->hasFile('catLogo')) {
                $image = $requ->file('catLogo');
                $name = Str::slug($requ->input('catName')).'_'.time().'.'.$image->getClientOriginalExtension();
                $folder = '/public/uploads/images/';
                $destinationPath = $folder;
                $image->move($destinationPath, $name);
                $filePath = $folder.$name;
                $category->catLogo = $filePath;
            }
            $category->name     = $requ->catName;
            if($category->save()):
                return back()->with('success','Success! Category created successfully');
            else:
                return back()->with('error','Sorry! Category failed to save');
            endif;
        endif;
    }
    
    public function updateCategory(Request $requ){
        $category    = Category::find($requ->catId);
        if(count($category)>0):
            if ($requ->hasFile('catLogo')) {
                $image = $requ->file('catLogo');
                $name = Str::slug($requ->input('catName')).'_'.time().'.'.$image->getClientOriginalExtension();
                $folder = '/public/uploads/images/';
                $destinationPath = $folder;
                $image->move($destinationPath, $name);
                $filePath = $folder.$name;
                $filename = $category->catLogo;

                if(File::exists($filename)) {
                    File::delete($filename);
                }
                $category->catLogo = $filePath;
            }
            $category->name     = $requ->catName;
            if($category->save()):
                return back()->with('success','Success! Category updated successfully');
            else:
                return back()->with('error','Sorry! Category failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No category found to update');
        endif;
    }
    
    //Slider controller
    public function saveSlider(Request $requ){
        // return var_dump($requ->slider);
        $chk    = Slider::whereNotNull('heading')->where(['heading'=>$requ->heading])->get();
        if(count($chk)>0):
            return back()->with('error','Sorry! Slider already exist');
        else:
            $slider            =  new Slider();// Form validation
            if ($requ->hasFile('slider')) {
                // $image = $requ->file('slider');
    			$image = $requ->file('slider');
                $detectedType = mime_content_type($_FILES['slider']['tmp_name']);
    			$allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp','image/PNG', 'image/JPEG', 'image/JPG', 'image/WEBP'];
                // $error = !in_array($detectedType, $allowedTypes);
                if(!in_array($detectedType, $allowedTypes)):
                    return back()->with('error','Sorry! File type must be JPG,JPEG,PNG etc');
                endif;
                $name = Str::slug($requ->input('heading')).'_'.time().'.'.$image->getClientOriginalExtension();
                $folder = '/public/uploads/images/';
    			Image::make($image->getRealPath())->resize(750, 290)->save(public_path('/uploads/images/').$name);
                $filePath = $folder.$name;
                $slider->slider = $filePath;
            }
            $slider->heading     = $requ->heading;
            $slider->details     = $requ->details;
            $slider->btnTxt      = $requ->btnTxt;
            if($slider->save()):
                return back()->with('success','Success! Slider created successfully');
            else:
                return back()->with('error','Sorry! Slider failed to save');
            endif;
        endif;
    }
    
    public function updateSlider(Request $requ){
        $slider    = Slider::find($requ->slideId);
        if(count($slider)>0):
            // return $requ->heading;
            if ($requ->hasFile('slide')) {
    			$image = $requ->file('slide');
                $detectedType = mime_content_type($_FILES['slide']['tmp_name']);
    			$allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                // $error = !in_array($detectedType, $allowedTypes);
                if(!in_array($detectedType, $allowedTypes)):
                    return back()->with('error','Sorry! File type must be JPG,JPEG,PNG etc');
                endif;
                $name = Str::slug($requ->input('heading')).'_'.time().'.'.$image->getClientOriginalExtension();
                $folder = '/public/uploads/images/';
    			Image::make($image->getRealPath())->resize(750, 290)->save(public_path('/uploads/images/').$name);
                $filePath = $folder.$name;
                $filename = $slider->slider;

                if(File::exists($filename)) {
                    File::delete($filename);
                }
                $slider->slider = $filePath;
            }
            $slider->heading     = $requ->heading;
            $slider->details     = $requ->details;
            $slider->btnTxt      = $requ->btnTxt;
            if($slider->save()):
                return back()->with('success','Success! Slider updated successfully');
            else:
                return back()->with('error','Sorry! Slider failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No category found to update');
        endif;
    }
    
    //Team controller
    public function saveTeam(Request $requ){
        $chk    = Team::where(['team'=>$requ->teamName,'catId'=>$requ->catId])->get();
        if(count($chk)>0):
            return back()->with('error','Sorry! Team already exist');
        else:
            $team            =  new Team();
            $team->team      = $requ->teamName;
            $team->catId     = $requ->catId;
            //$cat->creator  = Session::get('AdminRule');
            if($team->save()):
                return back()->with('success','Success! Team created successfully');
            else:
                return back()->with('error','Sorry! Team failed to save');
            endif;
        endif;
    }
    
    public function updateTeam(Request $requ){
        $team    = Team::find($requ->teamId);
        if(count($team)>0):
            $team->team      = $requ->teamName;
            $team->catId     = $requ->catId;
            //$chk->creator   = Session::get('AdminRule');
            if($team->save()):
                return back()->with('success','Success! Team updated successfully');
            else:
                return back()->with('error','Sorry! Team failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No team found to update');
        endif;
    }
    
    
    //Team controller
    public function saveTournament(Request $requ){
        $chk    = Tournament::where(['cupname'=>$requ->cupName,'catId'=>$requ->catId])->get();
        if(count($chk)>0):
            return back()->with('error','Sorry! Tournament already exist');
        else:
            $tournament            =  new Tournament();
            $tournament->cupName   = $requ->cupName;
            $tournament->catId     = $requ->catId;
            //$cat->creator  = Session::get('AdminRule');
            if($tournament->save()):
                return back()->with('success','Success! Tournament created successfully');
            else:
                return back()->with('error','Sorry! Tournament failed to save');
            endif;
        endif;
    }
    
    public function updateTournament(Request $requ){
        $tournament    = Tournament::find($requ->tId);
        if(count($tournament)>0):
            $tournament->cupName   = $requ->cupName;
            $tournament->catId     = $requ->catId;
            //$chk->creator   = Session::get('AdminRule');
            if($tournament->save()):
                return back()->with('success','Success! Tournament updated successfully');
            else:
                return back()->with('error','Sorry! Tournament failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No tournament found to update');
        endif;
    }
    
    //Club controller
    public function saveClub(Request $requ){
        if($requ->loginPass!=$requ->confirmPass):
            return back()->with('error','Sorry! Confirm password does not match with login password');
        else:
            $chk    = BettingClub::where(['clubid'=>$requ->loginID])->get();
            if(count($chk)>0):
                return back()->with('error','Sorry! Club already exist');
            else:
                $chk            =  new BettingClub();
                $hashpass       = Hash::make($requ->loginPass);
                $chk->fullname  = $requ->clubName;
                $chk->clubid    = $requ->loginID;
                $chk->plainpassword = $requ->loginPass;
                $chk->hashpassword  = $hashpass;
                //$chk->catId   = $requ->catId;
                //$cat->creator  = Session::get('AdminRule');
                if($chk->save()):
                    return back()->with('success','Success! Club created successfully');
                else:
                    return back()->with('error','Sorry! Club failed to save');
                endif;
            endif;
        endif;
    }
    
    public function updateClub(Request $requ){
        $club    = BettingClub::find($requ->clubid);
        if(count($club)>0):
                $club->fullname      = $requ->clubName;
                $club->clubid    = $requ->loginID;
                if(!empty($requ->loginPass)):
                    $hashpass       = Hash::make($requ->loginPass);
                    $club->plainpassword = $requ->loginPass;
                    $club->hashpassword  = $hashpass;
                endif;
                $club->email    = $requ->clubEmail;
                $club->phone    = $requ->clubMobile;
                
            //$chk->creator   = Session::get('AdminRule');
            if($club->save()):
                return back()->with('success','Success! Club updated successfully');
            else:
                return back()->with('error','Sorry! Club failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No club found to update');
        endif;
    }
    
    //Match controller
    public function saveMatch(Request $requ){
        if($requ->ateam == $requ->bteam):
            return back()->with('error','Sorry! you can not create tournament with same team');
        else:
            $chk    = Matche::where(['matchName'=>$requ->matchName])->get();
            if(count($chk)>0):
                return back()->with('error','Sorry! Match already exist');
            else:
                $chk            =  new Matche();
                $chk->matchName = $requ->matchName;
                $chk->category  = $requ->category;
                $chk->teamA     = $requ->ateam;
                $chk->teamB     = $requ->bteam;
                $chk->tournament= $requ->tournament;
                $chk->matchTime = $requ->matchTime;
                $chk->status    = 2;
                //$cat->creator = Session::get('AdminRule');
                if($chk->save()):
                    return back()->with('success','Success! Match created successfully');
                else:
                    return back()->with('error','Sorry! Match failed to save');
                endif;
            endif;
        endif;
    }
    
    public function updateMatch(Request $requ){
        $chk    = Matche::find($requ->matchid);
        if(count($chk)>0):
            $chk->matchName = $requ->matchName;
            $chk->category  = $requ->category;
            $chk->teamA     = $requ->ateam;
            $chk->teamB     = $requ->bteam;
            $chk->tournament= $requ->tournament;
            $chk->matchTime = $requ->matchTime;
                
            //$chk->creator   = Session::get('AdminRule');
            if($chk->save()):
                return back()->with('success','Success! Match updated successfully');
            else:
                return back()->with('error','Sorry! Match failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No match found to update');
        endif;
    }
    
    //BetOption controller
    public function saveBetOption(Request $requ){
        $chk    = BetOption::where(['optionName'=>$requ->optName])->get();
        if(count($chk)>0):
            return back()->with('error','Sorry! Bet question already exist');
        else:
            $chk            =  new BetOption();
            $chk->optionName = $requ->optName;
            $chk->optType = $requ->optType;
            $chk->catId  = $requ->catId;
            $chk->status     = 1;
            if($chk->save()):
                return back()->with('success','Success! Bet question created successfully');
            else:
                return back()->with('error','Sorry! Bet question failed to save');
            endif;
        endif;
    }
    
    public function updateBetOption(Request $requ){
        $chk        = BetOption::find($requ->optionId);
        $optType    = $chk->optType;
        if(count($chk)>0):
            $chk->optionName = $requ->optName;
            $chk->optType = $optType;
            $chk->catId  = $requ->catId;
            $chk->status     = 1;
            if($chk->save()):
                return back()->with('success','Success! Bet question update successfully');
            else:
                return back()->with('error','Sorry! Bet question failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No question found to update');
        endif;
    }
    
    //BetAnswer controller
    public function saveBetAnswer(Request $requ){
        $chk            =  new BetAnswer();
        if(!empty($requ->optVal)):
            for($i=0;$i<count($requ->optVal);$i++){
                $date = date('Y-m-d H:i:s');
                $savedb = [
                    'catId'   =>   $requ->catId,    
                    'optId'  =>   $requ->optId,    
                    //'optType'  =>   $requ->optType,    
                    'optVal'  =>   $requ->optVal[$i],    
                    'returnVal'  =>   $requ->returnVal[$i],    
                    'status'   =>   1,
                    'created_at'   =>   $date,
                    'updated_at'   =>   $date,
                ];
                $save = DB::table('bet_answers')->insert($savedb);
            }
        else:
            $chk->catId     = $requ->catId;
            $chk->optId     = $requ->optId;
            //$chk->optType   = $requ->optType;
            $chk->status    = 1;
        endif;
        if($save || $chk->save()):
            return back()->with('success','Success! Answer created successfully');
        else:
            return back()->with('error','Sorry! Answer failed to save');
        endif;
    }
    
    public function updateBetAnswer(Request $requ){
        $chk    = BetAnswer::where(['optId'=>$requ->optId])->delete();
            
        $chk    = new BetAnswer();
        if(!empty($requ->optVal)):
            for($i=0;$i<count($requ->optVal);$i++){
                $date = date('Y-m-d H:i:s');
                $savedb = [
                    'catId'   =>   $requ->catId,    
                    'optId'  =>   $requ->optId,    
                    //'optType'  =>   $requ->optType,    
                    'optVal'  =>   $requ->optVal[$i],    
                    'returnVal'  =>   $requ->returnVal[$i],    
                    'status'   =>   1,
                    'created_at'   =>   $date,
                    'updated_at'   =>   $date,
                ];
                $save = DB::table('bet_answers')->insert($savedb);
            }
            //return "Done";
        else:
            $chk->catId     = $requ->catId;
            $chk->optId     = $requ->optId;
            //$chk->optType   = $requ->optType;
            $chk->status    = 1;
        endif;
        if($save || $chk->save()):
            return back()->with('success','Success! Answer updated successfully');
        else:
            return back()->with('error','Sorry! Answer failed to updated');
        endif;
    }
    
    //MatchQuestion controller
    public function saveMatchQuestion(Request $requ){
        $chk    = MatchQuestion::where(['quesId'=>$requ->optId,'matchId'=>$requ->matchId])->get();
        if(count($chk)>0):
            return back()->with('error','Sorry! Question already placed for this match');
        else:
            if($requ->optType<3):
                $chkFixed   = FixedQuestion::where(['quesId'=>$requ->optId,'matchId'=>$requ->matchId])->get();
                if(count($chkFixed)>0):
                    return back()->with('error','Sorry! Question already placed for this match');
                else:
                    $fixed_answer               = new FixedQuestion;
                    $fixed_answer->catId        = $requ->catId;
                    $fixed_answer->tournament   = $requ->tournament;
                    $fixed_answer->matchId      = $requ->matchId;
                    $fixed_answer->quesId       = $requ->optId;
                    $fixed_answer->status       = 3;
                    $fixed_answer->teamA        = $requ->teamA;
                    $fixed_answer->teamB        = $requ->teamB;
                    if(!empty($requ->tie)):
                        $fixed_answer->draw      = $requ->tie;
                    endif;
                endif;
            else:
                $checkExistquestion     =  MatchQuestion::where(['matchId'=>$requ->matchId,'quesId'=>$requ->optId])->get();
                $question   =  new MatchQuestion();
                if(count($checkExistquestion)>0):
                    return back()->with('error','Sorry! Question already placed for this match');
                else:
                    $question->catId        = $requ->catId;
                    $question->tournament   = $requ->tournament;
                    $question->matchId      = $requ->matchId;
                    $question->quesId       = $requ->optId;
                    $question->status       = 3;
                    if($question->save()):
                        $getQid     =  MatchQuestion::where(['matchId'=>$requ->matchId,'quesId'=>$requ->optId])->get();
                        foreach($getQid as $gq):
                            $qId    = $gq->id;
                        endforeach;
                        if(!empty($requ->optVal)):
                            for($i=0;$i<count($requ->optVal);$i++){
                                $date = date('Y-m-d H:i:s');
                                $savedb = [
                                    'quesId'        =>   $qId,    
                                    'answer'        =>   $requ->optVal[$i],     
                                    'returnValue'   =>   $requ->returnVal[$i],   
                                    'created_at'    =>   $date,
                                    'updated_at'    =>   $date,
                                ];
                                $save = DB::table('match_answers')->insert($savedb);
                            }
                        endif;
                    endif;
                endif;
            endif;
            if($save || $fixed_answer->save()):
                if($save):
                    event(new BetUpdated($savedb));
                    return back()->with('success','Success! Answer created successfully');
                elseif($fixed_answer->save()):
                    event(new BetUpdated(['name' => 'hello world from Laravel 5.3']));
                    return back()->with('success','Success! Answer created successfully');
                else:
                    event(new BetUpdated("Blank result"));
                endif;
            else:
                return back()->with('error','Sorry! Answer failed to save');
            endif;
        endif;
    }
    

    //update single question
    public function returnBets($id){  
        $BetData = UserBet::where(['id'=>$id])->where(function($query) {
    		$query->where(['status'=>1])
    		->orWhere(['status'=>2]);
    	})->first();
        if(count($BetData)>0):
            //Set win answer to database
            $betAmount      = $BetData->betAmount;

            //Fetch user table to update balance
            $profile = BetUser::find($BetData->user);
            $profileBalance = $profile->balance;
            $newBalance = $profileBalance+$betAmount;
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
            $statement->transAmount     = $betAmount;
            $statement->note            = "BetReturn";
            $statement->transType       = "Credit";$sd = SiteConfig::first();
                    
            //Sponsor data
            $sponsor = $profile->sponsor;
            $sponsorBonus   = $sd->sponsorRate;
            $sponsorAmount  = ($sponsorBonus/100)*$BetData->betAmount;
            
            //Club data
            $club = $profile->club;
            $clubBonus   = $sd->clubRate;
            $clubAmount  = ($clubBonus/100)*$BetData->betAmount;
            //Sponsor balance update
            if(!empty($sponsor)):
                $sponsorProfile = BetUser::where(['userid'=>$sponsor])->get()->last();
                //sponsor statement update 
                
                //Sponsor balance update
                if(count($sponsorProfile)>0):
                    $spBal  = $sponsorProfile->balance;
                    $spNewBal   = $spBal-$sponsorAmount;
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
                    $spStatement->note   = "BetReturn";
                    $spStatement->transType   = "Debit";
                    //Sponsor statement and profile update
                    $spStatement->save();
                    $sponsorProfile->save();
                endif;
            endif;
            
            //Club balance update
            if(!empty($club)):
                $clubProfile = BettingClub::where(['clubid'=>$club])->get()->last();
                if(count($clubProfile)>0):
                    $clubBal  = $clubProfile->balance;
                    $clubNewBal   = $clubBal-$clubAmount;
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
                    $clubStatement->note   = "BetReturn";
                    $clubStatement->transType   = "Debit";
                    //Club statement and profile update
                    $clubStatement->save();
                    $clubProfile->save();
                endif;
            endif;
            
            $statement->save();
            //end statement
            
            //update user balance
            $profile->balance = $newBalance;
            $profile->save();
            //Bet data update
            $BetData->status    = 3;
            $BetData->userProfit    = NULL;
            $BetData->winAnswer     = NULL;
            $BetData->siteProfit    = NULL;
            $BetData->betReturnAmount = $betAmount;
            $BetData->save();
        
            return back()->with('success','Bet return successfully complete');
        else:
            return back()->with('error','Bet return to failed');
        endif;
    } 
    public function betReturn($matchId,$id){  
        $data = UserBet::where(['betOption'=>$id,'matchId'=>$matchId])->where(function($query) {
    		$query->where(['status'=>1])
    		->orWhere(['status'=>2]);
    	})->get();
        //return count($data);
        if(count($data)>0):
            foreach($data as $BetData):
                //Set win answer to database
                $betAmount      = $BetData->betAmount;

                //Fetch user table to update balance
                $profile = BetUser::find($BetData->user);
                $profileBalance = $profile->balance;
                $newBalance = $profileBalance+$betAmount;
                $statement   = BetUserStatement::where(['user'=>$profile->id])->get()->last();
                if(count($statement)>0):
                    $stmtBal    = $statement->currentBalance;
                else:
                    $stmtBal    = $profile->balance;
                endif;
                $sd = SiteConfig::first();
                //Sponsor data
                return $sponsor = $profile->sponsor;
                $sponsorBonus   = $sd->sponsorRate;
                $sponsorAmount  = ($sponsorBonus/100)*$BetData->betAmount;
                
                //Club data
                $club = $profile->club;
                $clubBonus   = $sd->clubRate;
                $clubAmount  = ($clubBonus/100)*$BetData->betAmount;
                //Create statement
                $statement= new BetUserStatement();
                $statement->user  = $profile->id;
                //$statement = BetUserStatement::find($statement->id);
                $statement->prevBalance     = $stmtBal;
                $statement->currentBalance  = $newBalance;
                $statement->transAmount     = $betAmount;
                $statement->note            = "BetReturn";
                $statement->transType       = "Credit";
                $statement->save();
                //end statement
                
                    $sd = SiteConfig::first();
                    //Sponsor data
                    return $sponsor = $profile->sponsor;
                    $sponsorBonus   = $sd->sponsorRate;
                    $sponsorAmount  = ($sponsorBonus/100)*$BetData->betAmount;
                    
                    //Club data
                    $club = $profile->club;
                    $clubBonus   = $sd->clubRate;
                    $clubAmount  = ($clubBonus/100)*$BetData->betAmount;
                    //Sponsor balance update
                    if($sponsor>0):
                        $sponsorProfile = BetUser::where(['userid'=>$sponsor])->get()->last();
                        //sponsor statement update 
                        
                        //Sponsor balance update
                        if(count($sponsorProfile)>0):
                            $spBal  = $sponsorProfile->balance;
                            $spNewBal   = $spBal-$sponsorAmount;
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
                            $spStatement->note   = "BetReturn";
                            $spStatement->transType   = "Debit";
                            //Sponsor statement and profile update
                            $spStatement->save();
                            $sponsorProfile->save();
                        endif;
                    endif;
                    
                    //Club balance update
                    $clubProfile = BettingClub::where(['clubid'=>$club])->get()->last();
                    if(count($clubProfile)>0):
                        $clubBal  = $clubProfile->balance;
                        $clubNewBal   = $clubBal-$clubAmount;
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
                        $clubStatement->note   = "BetReturn";
                        $clubStatement->transType   = "Debit";
                        //Club statement and profile update
                        $clubStatement->save();
                        $clubProfile->save();
                    endif;
                
                //update user balance
                $profile->balance = $newBalance;
                $profile->save();
                //Bet data update
                $BetData->status    = 3;
                $BetData->userProfit    = NULL;
                $BetData->winAnswer     = NULL;
                $BetData->siteProfit    = NULL;
                $BetData->betReturnAmount = $betAmount;
                $BetData->save();
            endforeach;
            return back()->with('success','Bet return successfully complete');
        else:
            return back()->with('error','Bet return to failed');
        endif;
    } 
    
}
