<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankBranch;
use App\CompanyBank;
use App\CompanyBankBranch;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(){
        $banks = Bank::paginate(10);
        if(request('search'))
            {
                $attr = request()->validate(['search'=>'max:255']);
                $banks = Bank::where('ar_name','like','%'.$attr['search'].'%','or','en_name','like','%'.$attr['search'].'%')->paginate(10);
            }
        //$banks = $banks->sortByDesc('created_at');
        return view('banks.banks',['banks'=>$banks]);
    }

    public function create(){
        return view('banks.create');
    }
    public function show($id){
        $bank = Bank::find($id);
        return view('banks.show',['bank'=>$bank]);
    }
    public function store(Request $request){
        $attr = $request->validate(
            [
                'en_name'=>'required|max:255',
                'ar_name'=>'required|max:255',
                'code'=>'required|max:10',
                'contact'=>'required|max:255'
            ]
        );
        Bank::create($attr);
        return back()->with(['success'=>'تمت إضافة البنك بنجاح']);
    }
    
    public function edit($id){
        $bank = Bank::find($id);

        return view('banks.update',['bank'=>$bank]);
    }
    public function update($id,Request $request){
        $bank = Bank::find($id);
        $attr = $request->validate([
                'en_name'=>'required|max:255',
                'ar_name'=>'required|max:255',
                'code'=>'required|max:10',
                'contact'=>'required|max:255'
        ]);
        $bank->update($attr);
        return back()->with(['success'=>'تم التعديل بنجاح']);
    }
    public function destroy($id){


        $branches=BankBranch::select('id')->where('bank_id',$id)->pluck('id')->toArray();
        BankBranch::where('bank_id',$id)->delete();

        Bank::where('id',$id)->delete();
        CompanyBank::where('bank_id',$id)->delete();
        CompanyBankBranch::whereIn('bank_branch_id',$branches)->delete();
        return back()->with('success');
    }
    public function destroyBulk(Request $request){
        foreach($request->banks as $bank)
            {
                BankBranch::where('bank_id','=',$bank)->delete();
                Bank::destroy($bank);
            }
            
        return back()->with('success');
    }
    public function getBranchesJson(Request $request){
        $ids=str_replace('[','',$request->id);
        $ids=str_replace(']','',$request->id);
        $ids=str_replace('\\','',$request->id);
        $ids=str_replace('"','',$request->id);

        $branches=BankBranch::whereIn('bank_id',explode(',',$ids))->get()->load('bank');
        return response()->json([
            'data'=>$branches
        ]);
    }
    public function getBranchesJsonSingle(Request $request){

        $branches=User::where('bank_id',$request->id)->where('role_id',4)->where('branch_id','!=',null)->where('branch_id','!=',0)->get()->load('branch');
        return response()->json([
            'data'=>$branches
        ]);
    }
    public function getBranchesJsonn(Request $request){

        $branches=BankBranch::where('bank_id',$request->id)->get();
        return response()->json([
            'data'=>$branches
        ]);
    }
}
