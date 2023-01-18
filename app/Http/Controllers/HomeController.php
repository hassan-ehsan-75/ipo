<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Controller;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
//        $companies = DB::table('companies')
//        ->select('companies.*',DB::raw('COUNT(stocks.id) as stock_count,SUM(companies.stocks) as total_stocks'))
//        ->join('stocks','stocks.company_id','=','companies.id')
//        ->groupBy(['stocks.id','companies.stocks','companies.id','companies.ar_name','companies.en_name','companies.code','companies.phone1','companies.phone2','companies.capital','companies.license','companies.address','companies.section','companies.foundation','companies.founders_list','companies.system','companies.ad','companies.version','companies.version_spend','companies.enner_system','companies.share_report','companies.min_stock','companies.start_date','companies.end_date','companies.created_at','companies.updated_at'])
//        ->get();
        $companies=Company::first();
    $companies['stock_count']=Stock::where('company_id',$companies->id)->where('status',1)->get()->count();
    $companies['total_stocks']=$companies->stocks;
        return view('Nhome',['companies'=>$companies]);
    }
}
