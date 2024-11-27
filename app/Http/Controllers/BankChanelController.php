<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankChanel;

class BankChanelController extends Controller
{
    public function __construct(){
        $this->middleware('BetAdmin');
    }
    
    //BankChanel controller
    public function newBankChanel(){
        return view('admin.newBankChanel');
    }
    
    public function manageBankChanel(){
        $bankChanel   = BankChanel::all();
        return view('admin.bankChanels',['bankChanel'=>$bankChanel]);
    }
    
    public function editBankChanel($id){
        $bankChanel   = BankChanel::find($id);
        return view('admin.editBankChanel',['bankChanel'=>$bankChanel]);
    }
    
    public function deleteBankChanel($id){
        $bankChanel   = BankChanel::find($id);
        if(count($bankChanel)>0):
            $bankChanel->delete();
            return back()->with('success','Success! Record deleted successfully');
        else:
            return back()->with('error','Sorry! No record found to delete');
        endif;
    }
    
    public function saveBankChanel(Request $requ){
        $existData = BankChanel::where(['paymentType'=>$requ->pmtType,'accountNumber'=>$requ->accountNumber])->get();
        if(count($existData)>0):
            return back()->with('error','Sorry! Account number already exist in database');
        else:
            $activeAccount = BankChanel::where(['paymentType'=>$requ->pmtType,'status'=>'Active'])->first();
            if(count($activeAccount)>0):
                $activeAccount->status  = "Inactive";
                $activeAccount->save();
            endif;
            
            $newChanel  = new BankChanel();
            $newChanel->accountNumber   = $requ->accountNumber;
            $newChanel->paymentType     = $requ->pmtType;
            $newChanel->status          = $requ->pmtStatus;
            if($newChanel->save()):
                return back()->with('success','Bank details added successfully');
            else:
                return back()->with('error','Bank details failed to add');
            endif;
        endif;
    }
    
    public function updateBankChanel(Request $requ){
        $existData = BankChanel::find($requ->bankId);
        if(count($existData)>0):
            if($requ->pmtStatus=="Active"):
                $activeAccount = BankChanel::where(['paymentType'=>$requ->pmtType,'status'=>'Active'])->first();
                if(count($activeAccount)>0):
                    $activeAccount->status  = "Inactive";
                    $activeAccount->save();
                endif;
            endif;
            $existData->accountNumber   = $requ->accountNumber;
            $existData->paymentType     = $requ->pmtType;
            $existData->status          = $requ->pmtStatus;
            if($existData->save()):
                return back()->with('success','Bank details updated successfully');
            else:
                return back()->with('error','Bank details failed to update');
            endif;
        else:
            return back()->with('error','Sorry! No records found');
        endif;
    }
}
