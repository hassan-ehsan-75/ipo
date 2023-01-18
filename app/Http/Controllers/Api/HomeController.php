<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\CompanyBank;
use App\CompanyBankBranch;
use App\Form;
use App\Helpers\SendMessage;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Category;
use TCG\Voyager\Models\Post;

class HomeController extends Controller
{
    public function companies()
    {
        $companies = Company::all();

        if(request('search'))
        {
            $attr = request()->validate(['search'=>'max:255']);
            $companies = Company::where('en_name','like','%'.$attr['search'].'%','or','ar_name','like','%'.$attr['search'].'%')
                ->orWhere('address','like','%'.$attr['search'].'%')
                ->orWhere('section','like','%'.$attr['search'].'%')
                ->get();
        }

        return response()->json(['companies'=>$companies]);
    }
    public function showCompany($id)
    {
        $company = Company::find($id);
        $banks = CompanyBank::where('company_id','=',$company->id)
            ->join('banks','company_banks.bank_id','=','banks.id')
            ->get();
        $branchs = CompanyBankBranch::where('company_id','=',$company->id)
            ->join('bank_branches','company_bank_branches.bank_branch_id','=','bank_branches.id')
            ->get();
        return response()->json(['company'=>$company,'banks'=>$banks,'branches'=>$branchs]);
    }
    public function forms(){
        if(request('search'))
        {
            $attr = request()->validate(['search'=>'max:255']);
            $forms = Form::where('name','like','%'.$attr['search'].'%')->paginate(10);
        }else
            $forms = Form::paginate(10);

        return response()->json(['forms'=>$forms]);
    }

    public function showForm($id){
        $form=Form::find($id);
        return response()->json(['form'=>$form]);
    }
}
