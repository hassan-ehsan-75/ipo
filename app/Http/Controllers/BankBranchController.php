<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankBranch;
use App\CompanyBankBranch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankBranchController extends Controller
{
    public function index(){
        $branches = BankBranch::with('bank')->paginate(10);
        if(request('search'))
            {
                $attr = request()->validate(['search'=>'max:255']);
                $branches = BankBranch::where('name','like','%'.$attr['search'].'%')->with('bank')->paginate(10);
            }
        //$branches = $branches->sortByDesc('created_at');
        return view('branches.branches',['branches'=>$branches]);
    }
    public function show($id){
        $branch = BankBranch::with('bank')->find($id);
        return view('branches.show',['branch'=>$branch]);
    }
    public function create(){
        $banks = Bank::all();
        return view('branches.create',['banks'=>$banks]);

    }
    public function store(){
        $attr = request()->validate([
            'name'=>'required|max:255',
            'respon_person'=>'required|max:255',
            'bank_id'=>'required'
        ]);
        BankBranch::create($attr);
        return back()->with(['success'=>'تم إضافة الفرع بنجاح']);
    }
    public function edit($id){
        $branch = BankBranch::with('bank')->find($id);
        $banks = Bank::all();
        return view('branches.edit',['branch'=>$branch,'banks'=>$banks]);
    }
    public function update($id){
        $attr = request()->validate([
            'name'=>'required|max:255',
            'respon_person'=>'required|max:255',
            'bank_id'=>'required'
        ]);
        $branch = BankBranch::find($id);
        $branch->update($attr);
        return back()->with(['success'=>'تم تعديل الفرع بنجاح']);
    }
    public function destroy($id){
        BankBranch::destroy($id);
        CompanyBankBranch::where('bank_branch_id',$id)->delete();
        return back()->with('success');
    }
}
