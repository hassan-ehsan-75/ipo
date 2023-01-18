<?php

namespace App\Http\Controllers\Api;

use App\ActiveStock;
use App\Bank;
use App\Company;
use App\CompanyBankBranch;
use App\Helpers\SendMessage;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Stock;
use Carbon\Carbon;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    public function index(Request $request)
    {

        
        if ($request->branch==1) {
            $stocks = Stock::where('user_id', $request->user_id)->with(['company', 'bank']);
            if (request('search')) {
                $attr = request()->validate(['search' => 'max:255']);
                $stocks = Stock::where('user_id',$request->user_id)
                    ->Orwhere([['full_name', 'like', '%' . $attr['search'] . '%'],['user_id',$request->user_id]])
                    ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%'],['user_id',$request->user_id]])
                    ->with('company', 'bank');
            }
        }
        else {
            $stocks = Stock::where('bank_id', $request->bank)->with(['company', 'bank']);
            if (request('search')) {
                $attr = request()->validate(['search' => 'max:255']);

                $stocks = Stock::where('bank_id',$request->bank)
                    ->Orwhere([['full_name', 'like', '%' . $attr['search'] . '%'],['bank_id',$request->bank]])
                    ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%'],['bank_id',$request->bank]])
                    ->with('company', 'bank');
            }

        }
        if (request()->type&&\request()->type!=0){
            $active=ActiveStock::select('stock_id')->where('type',\request()->type)->get()->toArray();
            $stocks=$stocks->where('status',1)->whereIn('id',$active);
        }
        $stocks=$stocks->orderBy('id','desc')->paginate(10);
        return response()->json( ['stocks' => $stocks]);
    }
    public function show($id)
    {
        $stock = Stock::with('company','bank','activeStock')->find($id);
        return response()->json( ['stock' => $stock]);
    }
    public function create($type,Request $request)
    {
        if ($type != 1 && $type != 2)
            return response()->json(['type' => 3, 'companies' => [], 'banks' => []]);

            $companies_ids = CompanyBankBranch::select('company_id')->where('bank_branch_id', $request->branch_id)
                ->pluck('company_id')->toArray();
            $companies = Company::whereIn('id', $companies_ids)->get();

        $banks = Bank::where('id',$request->bank_id)->get();

        return response()->json(['type' => $type, 'companies' => $companies, 'banks' => $banks]);
    }

    public function store(Request $request,$type)
    {


            $companyB = CompanyBankBranch::where('bank_branch_id', $request->branch_id)
                ->where('company_id', $request->company_id)->first();
            if ($companyB == null) {
                return response()->json( ['error' => 'هذا الفرع غير مشارك بالاكتتاب','status'=>-1,'inputs'=>$request->input()]);
            }

        $company=Company::find($request->company_id);


        if (Carbon::now() > $company->end_date.' 16:00')
            return response()->json( ['error' => 'انتهى وقت الاكتتاب','status'=>-1,'inputs'=>$request->input()]);

        if (Carbon::now() > $company->end_date.' 16:00')
            return response()->json( ['error' => 'انتهى وقت الاكتتاب','status'=>-1,'inputs'=>$request->input()]);

        if ($company->min_stock>$request->stock_number){
            return response()->json( ['error' => 'عدد الاسهم المراد الاكتتاب عليها اقل من العدد الادني','inputs'=>$request->input(),'status'=>-1]);
        }
        if ($request->stock_number>12250000){
            return response()->json( ['error' => 'عدد الاسهم المراد الاكتتاب عليها اكبر من العدد المسموح','inputs'=>$request->input(),'status'=>-1]);
        }
        if (Setting::first()->stock_status==0){
            return response()->json( ['error' => 'الاكتتاب متوقف حاليا','inputs'=>$request->input(),'status'=>-1]);
        }
        //array_merge($request->all(),['type'=>$type,'user_id'=>auth()->user()->id]);



        $stock = Stock::create($request->except(['identity_img','family_img','civil_img', 'record_img','branch_id']));

        if ($request->hasFile('identity_img'))
            $stock->identity_img = $request->file('identity_img')->store('public/stock');
        if ($request->hasFile('family_img'))
            $stock->family_img = $request->file('family_img')->store('public/stock');
        if ($request->hasFile('procuration_img'))
            $stock->procuration_img = $request->file('procuration_img')->store('public/stock');
        if ($request->hasFile('civil_img'))
            $stock->civil_img = $request->file('civil_img')->store('public/stock');
        if ($request->hasFile('record_img'))
            $stock->record_img = UploadFile::upload($request->file('record_img'), 'stock');
        $stock->save();
        //dd($stock);
        \Log::info("CREATE");
        \Log::info($request->except(['identity_img','family_img','civil_img', 'record_img','branch_id']));
        return response()->json( ['success' => 'تم الاضافه بنجاح','status'=>1]);
    }

    public function edit($id,Request $request)
    {

        $stock = Stock::find($id);
        $time2 = Carbon::now()->diffInHours(Carbon::parse($stock->created_at));
        if ($time2>24){
            return response()->json( ['error' => 'غير مسموح بالعملية','status'=>-1]);
        }
        $banks = Bank::where('id',10)->get();
        $ids = CompanyBankBranch::select('company_id')->where('bank_branch_id', $request->branch_id)
            ->pluck('company_id')->toArray();
        $companies = Company::whereIn('id', $ids)->get();
        return response()->json(['stock'=>$stock,'companies'=>$companies,'banks'=>$banks ,'status'=>1]);
    }
    public function update($id, Request $request)
    {


        $stock = Stock::find($id);
        $setting=Setting::first();
        if($stock == null)
            return response()->json( ['error' => 'غير موجود','status'=>-2]);

        $time2 = Carbon::now()->diffInHours(Carbon::parse($stock->created_at));
        if ($time2>$setting->expired_date){
            return response()->json( ['error' => 'غير مسموح بالعملية','status'=>-2]);
        }
        if ($setting->stock_status==0){
            return response()->json( ['error' => 'الاكتتاب متوقف حاليا','inputs'=>$request->input(),'status'=>-1]);
        }

            $companyB = CompanyBankBranch::where('bank_branch_id', $request->branch_id)
                ->where('company_id', $request->company_id)->first();
            if ($companyB == null) {
                return response()->json( ['error' => 'هذا الفرع غير مشارك بالاكتتاب','status'=>-1,'input'=>$request->input()]);
            }

        $company=Company::find($request->company_id);
        if ($company->min_stock>$request->stock_number){
            return response()->json( ['error' => 'عدد الاسهم المراد الاكتتاب عليها اقل من العدد الادني','status'=>-1,'input'=>$request->input()]);
        }
        if ($request->stock_number>12250000){

                return response()->json( ['error' => 'عدد الاسهم المراد الاكتتاب عليها اكبر من العدد المسموح','status'=>-1,'input'=>$request->input()]);
        }

            $request->request->add(['user_id' => $request->user_id]);


        $stock->update($request->except(['identity_img','family_img','procuration_img','civil_img', 'record_img','branch_id']));

        if ($request->hasFile('identity_img')) {
            Storage::delete($stock->identity_img);
            $stock->identity_img = $request->file('identity_img')->store('public/stock');

        }
        if ($request->hasFile('record_img')) {
            Storage::delete($stock->record_img);
            $stock->record_img = UploadFile::upload($request->file('record_img'), 'stock');
        }
        if ($request->hasFile('family_img')) {
            Storage::delete($stock->family_img);
            $stock->family_img = $request->file('family_img')->store('public/stock');
        }
        if ($request->hasFile('procuration_img')) {
            Storage::delete($stock->procuration_img);
            $stock->procuration_img = $request->file('procuration_img')->store('public/stock');
        }
        if ($request->hasFile('civil_img')) {
            Storage::delete($stock->civil_img);
            $stock->civil_img = $request->file('civil_img')->store('public/stock');
        }
        $stock->save();
        \Log::info("UPDATE");
        \Log::info($request->except(['identity_img','family_img','civil_img', 'record_img','branch_id']));
        return response()->json( ['success' => 'تم التعديل بنجاح','status'=>1]);
    }
    public function destroy($id)
    {
        $stock = Stock::find($id);
        if ($stock==null)
            return response()->json( ['error' => 'غير موجود','status'=>-1]);
        if($stock->identity_img != null)
            Storage::delete($stock->identity_img);
        if($stock->record_img != null)
            Storage::delete($stock->record_img);
        if($stock->family_img != null)
            Storage::delete($stock->family_img);
        if($stock->procuration_img != null)
            Storage::delete($stock->procuration_img);
        if($stock->civil_img != null)
            Storage::delete($stock->civil_img);
        $stock->delete();
        return response()->json( ['success' => 'تم الحذف بنجاح','status'=>1]);
    }

    public function activate(Request $request,$id){

        $stock=Stock::find($id);
        if ($stock==null)
            return response()->json( ['error' => 'غير موجود','status'=>-1]);

        $active=ActiveStock::where('stock_id',$stock->id)->first();
        if ($active){
            return response()->json( ['error' => 'الاكتتاب مفعل مسبقا','status'=>-1]);
        }
        ActiveStock::create([
           'stock_id'=>$stock->id,
            'rec_img'=>$request->file('rec_img')->store('public/stock'),
            'stock_img'=>$request->file('stock_img')->store('public/stock'),
            'type'=>$request->type
        ]);
        $stock->status=1;
        $stock->save();
        return response()->json( ['success' => 'تم التفعيل بنجاح','status'=>1]);
    }
}
