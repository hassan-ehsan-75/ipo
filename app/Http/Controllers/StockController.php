<?php

namespace App\Http\Controllers;

use App\ActiveStock;
use App\Bank;
use App\Company;
use App\CompanyBankBranch;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockRequest;
use App\Setting;
use App\Stock;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    public function index($bank=0,$branch=0,$status=3,$duplicate=0)
    {

        if($duplicate==0) {
            if (auth()->user()->role_id == 1) {

                if (request('search')) {
                    $attr = request()->validate(['search' => 'max:255']);
                    $stocks = Stock::where([['full_name', 'like', '%' . $attr['search'] . '%']])
                        ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%']])
                        ->Orwhere([['id', $attr['search']]])
                        ->Orwhere([['mobile', $attr['search']]])
                        ->with('company', 'bank', 'user');
                } else {
                    $stocks = Stock::with(['company', 'bank', 'user']);
                }
            } else {

                if (auth()->user()->branch != null) {
                    $role_condition = [];
                    if (auth()->user()->role_id == 7) {
                        $users = User::select('id')->where('branch_id', auth()->user()->branch_id)->pluck('id');
                        if (request('search')) {
                            $attr = request()->validate(['search' => 'max:255']);
                            $stocks = Stock::whereIn('user_id', $users)->where(function ($q) use ($attr) {
                                $q->where([['full_name', 'like', '%' . $attr['search'] . '%']])
                                    ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%']])
                                    ->Orwhere([['id', $attr['search']]])
                                    ->Orwhere([['mobile', $attr['search']]]);
                            })->with('company', 'bank', 'user');
                        } else {
                            $stocks = Stock::whereIn('user_id', $users)->with(['company', 'bank', 'user']);
                        }
                    } else {
                        if (request('search')) {
                            $attr = request()->validate(['search' => 'max:255']);
                            $stocks = Stock::where([['full_name', 'like', '%' . $attr['search'] . '%'], ['user_id', auth()->user()->id]])
                                ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%'], ['user_id', auth()->user()->id]])
                                ->Orwhere([['id', $attr['search']], ['user_id', auth()->user()->id]])
                                ->Orwhere([['mobile', $attr['search']], ['user_id', auth()->user()->id]])
                                ->with('company', 'bank', 'user');
                        } else {
                            $stocks = Stock::where('user_id', auth()->user()->id)->with(['company', 'bank', 'user']);
                        }
                    }


                } else if (auth()->user()->bank != null) {

                    if (request('search')) {
                        $attr = request()->validate(['search' => 'max:255']);
                        $stocks = Stock::where([['full_name', 'like', '%' . $attr['search'] . '%'], ['bank_id', auth()->user()->bank_id]])
                            ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%'], ['bank_id', auth()->user()->bank_id]])
                            ->Orwhere([['id', $attr['search']], ['bank_id', auth()->user()->bank_id]])
                            ->Orwhere([['mobile', $attr['search']], ['bank_id', auth()->user()->bank_id]])
                            ->with('company', 'bank', 'user');
                    } else {
                        $stocks = Stock::where('bank_id', auth()->user()->bank_id)
                            ->with(['company', 'bank', 'user']);
                    }

                } else {
                    if (request('search')) {
                        $attr = request()->validate(['search' => 'max:255']);
                        $stocks = Stock::where([['full_name', 'like', '%' . $attr['search'] . '%']])
                            ->Orwhere([['last_name', 'like', '%' . $attr['search'] . '%']])
                            ->Orwhere([['id', $attr['search']]])
                            ->Orwhere([['mobile', $attr['search']]])
                            ->with('company', 'bank', 'user');
                    } else {
                        $stocks = Stock::with(['company', 'bank', 'user']);
                    }
                }

            }

            if (request()->type && \request()->type != 0) {
                $active = ActiveStock::select('stock_id')->where('type', \request()->type)->get()->toArray();
                $stocks = $stocks->where('status', 1)->whereIn('id', $active);
            }
            if ($bank != 0) {
                $stocks = $stocks->where('bank_id', $bank);
            }
            if ($branch != 0) {
                $users = User::select('id')->where('branch_id', $branch)->pluck('id');
                $stocks = $stocks->whereIn('user_id', $users);
            }
            if ($status != 3) {

                $stocks = $stocks->where('status', $status);
            }
            $stocks = $stocks->orderBy('id', 'desc')->paginate(10);
        }else{
            $stocks = DB::table('stocks')
                ->select('p_number', DB::raw('SUM(stock_number) as `stock_number`'), DB::raw('COUNT(*) as `count`'))
                ->groupBy( 'p_number')
                ->havingRaw('COUNT(*) > 1')
                ->orderBy('p_number','Desc')
                ->get();
        }
        //$stocks = $stocks->sortByDesc('created_at');
        return view('stocks.stocks', ['stocks' => $stocks,'bank'=>$bank,'branch'=>$branch,'status'=>$status,'duplicate'=>$duplicate]);
    }


    public function show($id)
    {
        $stock = Stock::with('company','bank','activeStock')->find($id);
        return view('stocks.show',['stock'=>$stock]);
    }


    public function create($type)
    {
        if ($type != 1 && $type != 2)
            abort(404);
        if(auth()->user()->role_id==1){
            $companies = Company::all();
            $banks = Bank::all();
        }else {
            $companies_ids = CompanyBankBranch::select('company_id')->where('bank_branch_id', auth()->user()->branch->id)
                ->pluck('company_id')->toArray();
            $companies = Company::whereIn('id', $companies_ids)->get();
            $banks = Bank::where('id',auth()->user()->bank_id)->get();
        }


        return view('stocks.create', ['type' => $type, 'companies' => $companies, 'banks' => $banks]);
    }
    public function store(StockRequest $request,$type)
    {


        if (auth()->user()->role_id!=1) {
            $request->request->add(['user_id' => auth()->user()->id, 'type' => $type,'bank_id'=>auth()->user()->bank_id]);

        }else{
            $this->validate($request,[
                'bank_id' => 'required|numeric',
                'branch_id' => 'required|numeric',
            ]);
            $request->request->add(['user_id' => $request->branch_id,'type'=>$type]);
        }
        if(Setting::first()->status==0){
            return redirect()->back()->withErrors(['error'=>'الاكتتاب متوقف حاليا']);
        }

        $stock = Stock::create($request->except(['identity_img','family_img','procuration_img','civil_img', 'record_img','branch_id','company']));
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

        $request->session()->flash('success','تم إضافة الاكتتاب بنجاح');
        \Log::info("CREATE");
        \Log::info($request->except(['identity_img','family_img','civil_img', 'record_img']));
        return back()->with(['success', 'تم إضافة الاكتتاب بنجاح']);
    }

    public function edit($id)
    {



        if(auth()->user()->role_id!=1)
            $stock = Stock::where('id',$id)->where('user_id',auth()->user()->id)->first();
        else
            $stock = Stock::find($id);

        if($stock == null)
            abort(404);
        $time2 = Carbon::now()->diffInHours(Carbon::parse($stock->created_at));
//        if ($time2>200&&auth()->user()->role_id!=1){
//            return redirect()->back();
//        }
        $banks = Bank::all();
        if(auth()->user()->role_id==1){
            $companies = Company::all();
        }else {
            $ids = CompanyBankBranch::select('company_id')->where('bank_branch_id', auth()->user()->branch->id)
                ->pluck('company_id')->toArray();
            $companies = Company::whereIn('id', $ids)->get();
        }
        return view('stocks.update', ['stock'=>$stock,'companies'=>$companies,'banks'=>$banks ]);
    }


    public function update($id, StockRequest $request)
    {


        if(auth()->user()->role_id!=1)
            $stock = Stock::where('id',$id)->where('user_id',auth()->user()->id)->first();
        else
            $stock = Stock::find($id);
        if($stock == null)
            abort(404);
        $setting=Setting::first();
        if($setting->status==0){
            return redirect()->back()->withErrors(['error'=>'الاكتتاب متوقف حاليا']);
        }

        $time2 = Carbon::now()->diffInHours(Carbon::parse($stock->created_at));
        if ($time2>$setting->expired_date&&auth()->user()->role_id!=1){
            return redirect()->back()->withErrors(['error'=>'انتهت صلاحيه التعديل']);;
        }
        if (auth()->user()->role_id!=1)
            $request->request->add(['user_id' => auth()->user()->id]);



        $stock->update($request->except(['identity_img','family_img','procuration_img','civil_img', 'record_img','branch_id','company']));
        if ($request->hasFile('identity_img')){
            Storage::delete($stock->identity_img);
            $stock->identity_img = $request->file('identity_img')->store('public/stock');
        }
        if ($request->hasFile('record_img')){
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
        \Log::info($request->except(['identity_img','family_img','civil_img', 'record_img']));
        $request->session()->flash('success','تم التعديل بنجاح');
        return back()->with(['success'=>'تم التعديل بنجاح']);
    }


    public function destroy($id)
    {
        if(auth()->user()->role_id!=1)
            $stock = Stock::where('id',$id)->where('user_id',auth()->user()->id)->first();
        else
            $stock = Stock::find($id);
        if($stock==null) abort(404);
        if($stock->identity_img != null)
            Storage::delete($stock->identity_img);
        if($stock->record_img != null)
            Storage::delete($stock->record_img);
        if($stock->family_img != null)
            Storage::delete($stock->family_img);
        if($stock->civil_img != null)
            Storage::delete($stock->civil_img);
        if($stock->civil_img != null)
            Storage::delete($stock->civil_img);
        $stock->delete();
        return redirect('/stockss');
    }

    public function activate(Request $request,$id){

        if(auth()->user()->role_id!=1)
            $stock = Stock::where('id',$id)->where('user_id',auth()->user()->id)->first();
        else
            $stock = Stock::find($id);
        if($stock == null)
            abort(404);
        if(Setting::first()->stock_status==0)
            return redirect()->back()->withErrors(['error'=>'الاكتتاب متوقف حاليا']);

        $this->validate($request,[
            'rec_img' => 'required|max:10000|mimes:jpeg,jpg,png,svg,webp,pdf',
            'stock_img' => 'required|max:10000|mimes:jpeg,jpg,png,svg,webp,pdf',
            'type' => 'required'
        ]);
        $active=ActiveStock::where('stock_id',$stock->id)->first();
        if ($active){
            $request->session()->flash('error','الاكتتاب مفعل مسبقا');
            return redirect()->back();
        }
        ActiveStock::create([
            'stock_id'=>$stock->id,
            'rec_img'=>$request->file('rec_img')->store('public/stock'),
            'stock_img'=>$request->file('stock_img')->store('public/stock'),
            'type'=>$request->type
        ]);
        $stock->status=1;
        $stock->save();
        $request->session()->flash('success','تم التفعيل بنجاح');
        return redirect()->to('/stockss');
    }
    public function showActive($id){
        $active=ActiveStock::where('stock_id',$id)->first();
        if ($active){
            session()->flash('error','الاكتتاب مفعل مسبقا');
            return redirect()->to('/stockss');
        }
        return view('stocks.activate',compact('id'));
    }
    public function deActive($id){
        $stock=Stock::findOrFail($id);
        if(Setting::first()->stock_status==0)
            return redirect()->back()->withErrors(['error'=>'الاكتتاب متوقف حاليا']);

        $stock->status=0;
        $active=ActiveStock::where('stock_id',$stock->id)->first();
        if ($active==null)
            return redirect()->back();
        if($active->rec_img != null)
            Storage::delete($active->rec_img);
        if($active->stock_img != null)
            Storage::delete($active->stock_img);
        ActiveStock::where('stock_id',$stock->id)->delete();
        $stock->save();
        session()->flash('success','تم الغاء التفعيل');
        return redirect()->to('/stockss');

    }
}
