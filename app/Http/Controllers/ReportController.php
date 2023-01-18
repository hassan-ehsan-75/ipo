<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankBranch;
use App\Company;
use App\CompanyBankBranch;
use App\Http\Controllers\Controller;
use App\Stock;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        if(auth()->user()->role_id==5&&auth()->user()->bank_id!=null) {
            $banks = Bank::where('id',auth()->user()->bank_id)->get();
            $branches = BankBranch::where('bank_id',auth()->user()->bank_id)->get();
        }elseif(auth()->user()->role_id==1){
            $banks = Bank::all();
            $branches = BankBranch::all();
        }elseif(auth()->user()->role_id==3){
            $banks = Bank::all();
            $branches = BankBranch::all()->load('bank');
        }else{
            $banks = [];
            $branches = [];
        }


        return view('reports.reports',['banks'=>$banks,'branches'=>$branches]);
    }
    public function stocks(Request $request){

        $stocks = Stock::where('status',1);
        if ($request->bankx&&$request->bankx!='all'){
            $stocks=$stocks->where('bank_id',$request->bankx);
        }

        if(auth()->user()->role_id==5&&auth()->user()->bank_id!=null) {
            $banks = Bank::where('id',auth()->user()->bank_id)->get();
            $stocks=$stocks->where('bank_id',auth()->user()->bank_id);
        }elseif(auth()->user()->role_id==1||auth()->user()->role_id==3){
            $banks = Bank::all();
        }else{
            $banks = [];
        }
        $stocks=$stocks->get();
        return view('reports.stocks',['stocks'=>$stocks,'banks'=>$banks]);
    }
    public function singleStockPrint($id){
        $stock = Stock::with('company')->find($id);
        return view('reports.singleStock',['stock'=>$stock]);
    }
    public function stocksPrint(Request $request){
        $this->validate($request,[
            'bank'=>'required',
            'num'=>'nullable',
            'price'=>'nullable',
            'date'=>'nullable',
        ]);

        $data=[];
        if ($request->bank!='all') {
            $bank = Bank::findOrFail($request->bank);
            $BankStocks = Stock::where('status',1)->where('bank_id', $bank->id);
            if(!empty($request->date)){
                $BankStocks=$BankStocks->where('created_at','like','%'.$request->date.'%');
            }
            $BankStocks=$BankStocks->sum('stock_number');
            $BanksStocks = Stock::where('status',1)->where('bank_id', '!=', $bank->id);
            if(!empty($request->date)){
                $BanksStocks=$BanksStocks->where('created_at','like','%'.$request->date.'%');
            }
            $BanksStocks=$BanksStocks->sum('stock_number');
            $data=['BankStocks'=>$BankStocks,'BanksStocks'=>$BanksStocks,'bank'=>$bank];
        }else{
            $stocks=Stock::selectRaw('bank_id,sum(stock_number) as stocks')->where('status',1)->groupBy('bank_id');
            if(!empty($request->date)){
                $stocks=$stocks->where('created_at','like','%'.$request->date.'%');
            }
                $stocks=$stocks->get()->load('bank');
            $data=['stocks'=>$stocks];
        }
        $company=Company::first();
        $s=Stock::where('status',1)->sum('stock_number');
        $where = array();
        if(!empty($request->num)) $where['stock_number'] = $request->num;
        if(!empty($request->price)) $where['total'] = $request->price;
        if(!empty($request->bank)&&$request->bank!='all') $where['bank_id'] = $request->bank;

            $total_stocks = Company::sum('stocks');
        $total_registered = Stock::where('status',1)->sum('stock_number');
        if(!empty($where)){
            $result = Stock::where('status',1)->where($where);
            if(!empty($request->date)){
                $result=$result->where('created_at','like','%'.$request->date.'%');
            }
            $result=$result->get();
            return view('reports.stockPrint',['stocks'=>$result,'total'=>$total_stocks,'registered'=>$total_registered,'data'=>$data,'company'=>$company,
                's'=>$s]);
        }else{
            $result = Stock::where('status',1);
            if(!empty($request->date)){
                $result=$result->where('created_at','like','%'.$request->date.'%');
            }
            $result=$result->get();
            return view('reports.stockPrint',[
                'stocks'=>$result,
                'total'=>$total_stocks,
                'registered'=>$total_registered,
                'data'=>$data,
                'company'=>$company,
                's'=>$s,
            ]);
        }
    }
    public function bankPrint(Request $request){
        $this->validate($request,[
            'bank_id'=>'required'
        ]);
        $bank=Bank::findOrFail($request->bank_id);
        $BankStocks=Stock::where('status',1)->where('bank_id',$bank->id)->sum('stock_number');
        $BanksStocks=Stock::where('status',1)->where('bank_id','!=',$bank->id)->sum('stock_number');
        $BanksStocksB=DB::table('stocks')->selectRaw('stocks.bank_id,sum(stocks.stock_number) as sum,b.name,u.branch_id')
            ->where('stocks.bank_id','=',$bank->id)
            ->where('stocks.status','=',1)
            ->join('users as u','u.id','stocks.user_id')
            ->join('bank_branches as b','u.branch_id','b.id')
            ->groupBy('u.branch_id','stocks.bank_id','b.name')->get();


        $info = DB::table('stocks')
        ->select(DB::raw('COUNT(stocks.id) as total_stock,SUM(stock_number) as total_number,SUM(total) as total,SUM(companies.stocks) as all_stock'))
        ->join('companies','companies.id','=','stocks.company_id')
        ->where('bank_id',$request->bank_id)
        ->where('status',1)
        ->get();
        $info2= DB::table('stocks')
            ->select(DB::raw('SUM(stock_number) as total_number'))
            ->join('companies','companies.id','=','stocks.company_id')
            ->where('status',1)
            ->get();
        $company=Company::first();
        $s=Stock::where('status',1)->sum('stock_number');
        $chart = DB::table('stocks')
            ->select(DB::raw('SUM(stock_number) as stock_number,SUM(companies.min_stock) as total_stocks'))
            ->join('company_bank_branches','company_bank_branches.company_id','=','stocks.company_id')
            ->join('companies','companies.id','=','stocks.company_id')
            ->where('stocks.bank_id',$request->bank_id)
            ->where('status',1)
            ->groupBy('company_bank_branches.company_id')
            ->get();
        //dd($chart);
        return view('reports.bankPrint',[
            'bank'=>$info,
            'bank2'=>$info2,
            'company'=>$company,
            's'=>$s,
            'bankk'=>$bank,
            'BankStocks'=>$BankStocks,
            'BanksStocks'=>$BanksStocks,
            'BanksStocksB'=>$BanksStocksB,

        ]);
    }
    public function branchPrint(Request $request){
        $this->validate($request,[
            'branch_id'=>'required'
        ]);
        $branch=BankBranch::findOrFail($request->branch_id);
        $bank=Bank::findOrFail($branch->bank_id);
        $branches=BankBranch::where('bank_id',$bank->id)->get();
        $BankStocks=Stock::where('status',1)->where('bank_id',$bank->id)->where('user_id','!=',User::where('branch_id',$branch->id)->first()->id)->sum('stock_number');
        $branchStocks=Stock::where('status',1)->whereIn('user_id',User::select('id')->where('branch_id',$branch->id)->pluck('id'))->sum('stock_number');

        $info = DB::table('stocks')
        ->select(DB::raw('COUNT(stocks.id) as total_stock,SUM(stock_number) as total_number,SUM(total) as total,SUM(companies.stocks) as all_stock'))
        ->join('bank_branches','bank_branches.bank_id','=','stocks.bank_id')
        ->join('companies','companies.id','=','stocks.company_id')
        ->where('bank_branches.id',$request->branch_id)
        ->where('stocks.status',1)
        ->get();
        //dd($info);
        $company=Company::first();
        $s=Stock::where('status',1)->sum('stock_number');
        return view('reports.branchesPrint',[
            'info'=>$info,
            'bank'=>$bank,
            'branch'=>$branch,
            'branches'=>$branches,
            'BankStocks'=>$BankStocks,
            'branchStocks'=>$branchStocks,
            'company'=>$company,
            's'=>$s,

        ]);
    }
}
