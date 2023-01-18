<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankBranch;
use App\Company;
use App\CompanyBank;
use App\CompanyBankBranch;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::paginate(10);
        if(request('search'))
            {
                $attr = request()->validate(['search'=>'max:255']);
                $companies = Company::where('en_name','like','%'.$attr['search'].'%','or','ar_name','like','%'.$attr['search'].'%')
                    ->orWhere('address','like','%'.$attr['search'].'%')
                    ->orWhere('section','like','%'.$attr['search'].'%')
                    ->paginate(10);
            }
            
        //$companies = $companies->sortByDesc('created_at');
        //dd($companies);
        return view('companies.companies', [
            'companies' => $companies,
        ]);
    }
    public function create()
    {
        $banks = Bank::all();
        return view('companies.createCompany', [
            'banks' => $banks
        ]);
    }

    public function show($id)
    {
        $company = Company::find($id);
        $banks = CompanyBank::where('company_id','=',$company->id)
        ->join('banks','company_banks.bank_id','=','banks.id')
        ->get();
        $branchs = CompanyBankBranch::where('company_id','=',$company->id)
        ->join('bank_branches','company_bank_branches.bank_branch_id','=','bank_branches.id')
        ->get();
        return view('companies.show',['company'=>$company,'banks'=>$banks,'branches'=>$branchs]);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'ar_name' => 'required|min:1|max:45|unique:companies',
            'en_name' => 'required|min:1|max:45|unique:companies',
            'code' => 'required|min:1|max:45',
            'phone1' => 'required|min:1|max:10|unique:companies',
            'phone2' => 'required|min:1|max:10|unique:companies',
            'capital' => 'required|min:1|max:45',
            'license' => 'required|min:1|max:45',
            'address' => 'required|min:5|max:255',
            'section' => 'required|min:2|max:255',
            'founders_list' => 'required|min:2',
            'share_report' => 'required|min:2',
            'min_stock' => 'required|min:2',
            'stocks' => 'required|min:2',
            'start_date' => 'required|min:2',
            'end_date' => 'required|min:2',
            'foundation' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'system' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'ad' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'version' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'version_spend' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'enner_system' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'banks' => 'required|array|min:1',
            'banks_branches' => 'required|array|min:1',
        ]);
        //store all input except files and arrays
        $company = Company::create($request->except(['foundation', 'system', 'ad', 'version', 'version_spend', 'enner_system', 'banks', 'banks_branches']));

        //store banks
        foreach ($request->banks as $bank) {
            CompanyBank::create([
                'company_id' => $company->id,
                'bank_id' => $bank
            ]);
        }
        //store banks branch
        foreach ($request->banks_branches as $banks_branch) {
            CompanyBankBranch::create([
                'company_id' => $company->id,
                'bank_branch_id' => $banks_branch
            ]);
        }
        //store files
        if ($request->hasFile('foundation'))
            $company->foundation =$request->file('foundation')->store('public/company');;
        if ($request->hasFile('system'))
            $company->system = $request->file('system')->store('public/company');
        if ($request->hasFile('ad'))
            $company->ad = $request->file('ad')->store('public/company');
        if ($request->hasFile('version'))
            $company->version = $request->file('version')->store('public/company');
        if ($request->hasFile('version_spend'))
            $company->version_spend =$request->file('version_spend')->store('public/company');
        if ($request->hasFile('enner_system'))
            $company->enner_system = $request->file('enner_system')->store('public/company');

        $company->save();
        return back()->with('success','تم الاضافه بنجاح');
    }

    public function edit($id)
    {

        $company=Company::find($id);
        if($company==null){
            abort(404);
        }
        $banks = Bank::all();
        $branchs=BankBranch::all();
        $companyBanks=CompanyBank::select('bank_id')->where('company_id',$company->id)->pluck('bank_id')->toArray();
        $companyBankBranchs=CompanyBankBranch::select('bank_branch_id')->where('company_id',$company->id)->pluck('bank_branch_id')->toArray();

        return view('companies.update',[
            'company'=>$company,
            'banks'=>$banks,
            'branches'=>$branchs,
            'companyBanks'=>$companyBanks,
            'companyBankBranches'=>$companyBankBranchs
        ]);
    }

    public function update($id, Request $request)
    {

        $company=Company::find($id);
        if ($company==null){
            return abort(404);
        }
        $this->validate($request, [
            'ar_name' => 'required|min:1|max:45|unique:companies,ar_name,'.$company->id,
            'en_name' => 'required|min:1|max:45|unique:companies,en_name,'.$company->id,
            'code' => 'required|min:1|max:45',
            'phone1' => 'required|min:1|max:10|unique:companies,ar_name,'.$company->id,
            'phone2' => 'required|min:1|max:10|unique:companies,ar_name,'.$company->id,
            'capital' => 'required|min:1|max:45',
            'license' => 'required|min:1|max:45',
            'address' => 'required|min:5|max:255',
            'section' => 'required|min:2|max:255',
            'founders_list' => 'required|min:2',
            'share_report' => 'required|min:2',
            'min_stock' => 'required|min:2',
            'stocks' => 'required|min:2',
            'start_date' => 'required|min:2',
            'end_date' => 'required|min:2',
            'foundation' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'system' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'ad' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'version' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'version_spend' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'enner_system' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt',
            'banks' => 'required|array|min:1',
            'banks_branches' => 'required|array|min:1',
        ]);
        //store all input except files and arrays
        $company->update($request->except(['foundation', 'system', 'ad', 'version', 'version_spend', 'enner_system', 'banks', 'banks_branches','stocks']));
        
        $company->stocks=$request->stocks;
        $company->save();

        //store banks
        CompanyBank::where('company_id',$company->id)->delete();
        foreach ($request->banks as $bank) {
            CompanyBank::create([
                'company_id' => $company->id,
                'bank_id' => $bank
            ]);
        }
        //store banks branch
        CompanyBankBranch::where('company_id',$company->id)->delete();
        foreach ($request->banks_branches as $banks_branch) {
            CompanyBankBranch::create([
                'company_id' => $company->id,
                'bank_branch_id' => $banks_branch
            ]);
        }
        //store files
        if ($request->hasFile('foundation')) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->foundation);
            $company->foundation =$request->file('foundation')->store('public/company');;
        }
        if ($request->hasFile('system')) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->system);
            $company->foundation =$request->file('system')->store('public/company');;
        }
        if ($request->hasFile('ad')) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->ad);
            $company->foundation =$request->file('ad')->store('public/company');;
        }
        if ($request->hasFile('version')) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->version);
            $company->foundation =$request->file('version')->store('public/company');;
        }
        if ($request->hasFile('version_spend')) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->version_spend);
            $company->foundation =$request->file('version_spend')->store('public/company');;
        }
        if ($request->hasFile('enner_system')) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->enner_system);
            $company->foundation =$request->file('enner_system')->store('public/company');;
        }

        $company->save();
        return redirect()->route('companies.index')->with('success','تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        
        $company=Company::find($id);
        if ($company==null){
            abort(404);
        }
        CompanyBank::where('company_id',$id)->delete();
        CompanyBankBranch::where('company_id',$id)->delete();
        if ($company->foundation!=null) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->foundation);

        }
        if ($company->system!=null) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->system);

        }
        if ($company->ad!=null) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->ad);

        }
        if ($company->version!=null) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->version);

        }
        if ($company->version_spend!=null) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->version_spend);

        }
        if ($company->enner_system!=null) {
            Storage::disk(config('voyager.storage.disk'))->delete($company->enner_system);

        }
        $company->delete();
        return redirect('/companies')->with('success','تم الحذف بنجاح');
    }
    public function saveSetting(Request $request){
        $this->validate($request,[
            'expired_date'=>'required|numeric',
            'stock_status'=>'required|numeric'
        ]);
        Setting::first()->update($request->except('_token'));

        return redirect()->back()->with(['success'=>'تمت العميلة بنجاح']);
    }
}
