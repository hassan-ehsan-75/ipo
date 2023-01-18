<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Http\Controllers\Controller;
use App\Imports\StockImport;
use App\Personalization;
use App\Personalizations;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use niklasravnsborg\LaravelPdf\Facades\Pdf;


class PersonalizationController extends Controller
{
    public function index($bank=0,$branch=0){
        if(\request()->search){
            $attr['search']=\request()->search;
            $stocks=Personalization::whereHas('stock',function ($query) use ($attr,$bank,$branch){
                $query->where('full_name', 'like', '%' . $attr['search'] . '%')
                    ->Orwhere('last_name', 'like', '%' . $attr['search'] . '%')
                    ->Orwhere('id', $attr['search']);
                if ($bank!=0){
                    $query=$query->where('bank_id',$bank);
                }
                if ($branch!=0){
                    $users = User::select('id')->where('branch_id', $branch)->pluck('id');
                    $query=$query->whereIn('user_id', $users);
                }
            })->orderBy('id', 'desc')->paginate(20);
        }else{
            $stocks=Personalization::whereHas('stock',function ($query) use ($bank,$branch){
                $query->with(['bank','user']);
                if ($bank!=0){
                    $query=$query->where('bank_id',$bank);
                }
                if ($branch!=0){
                    $users = User::select('id')->where('branch_id', $branch)->pluck('id');
                    $query=$query->whereIn('user_id', $users);
                }
            })->orderBy('id', 'desc')->paginate(20);;
        }
        return view('personalizations.index',compact(['stocks','bank','branch']));
    }
    public function returning($bank=0,$branch=0){
        if(\request()->search){
            $attr['search']=\request()->search;
            $stocks=Personalization::whereHas('stock',function ($query) use ($attr,$bank,$branch){
                $query->with(['bank','user'])->where('full_name', 'like', '%' . $attr['search'] . '%')
                    ->Orwhere('last_name', 'like', '%' . $attr['search'] . '%')
                    ->Orwhere('id', $attr['search']);
                if ($bank!=0){
                    $query=$query->where('bank_id',$bank);
                }
                if ($branch!=0){
                    $users = User::select('id')->where('branch_id', $branch)->pluck('id');
                    $query=$query->whereIn('user_id', $users);
                }
            })->orderBy('id', 'desc')->paginate(20);
        }else{
            $stocks=Personalization::whereHas('stock',function ($query) use ($bank,$branch){
                $query->with(['bank','user']);
                if ($bank!=0){
                    $query=$query->where('bank_id',$bank);
                }
                if ($branch!=0){
                    $users = User::select('id')->where('branch_id', $branch)->pluck('id');
                    $query=$query->whereIn('user_id', $users);
                }
            });
            if($branch!=0||$bank!=0){
               $stocks= $stocks->orderBy('id', 'desc')->get();
            }else{
                $stocks= $stocks->orderBy('id', 'desc')->paginate(20);
            }
        }
        return view('return.index',compact(['stocks','bank','branch']));
    }
    public function printReturn($id){
        $stock=Personalizations::with('stock')->where('stock_id',$id)->first();
        return view('personalizations.print',compact('stock'));
    }

    public function import(Request $request){
        $this->validate($request,[
            'file'=>'required|mimes:xls,xlsx'
        ]);
        Excel::import(new StockImport(),$request->file('file'));

        return redirect()->back()->with(['success'=>'تم الاسيراد بنجاح']);
    }
    public function export($id){
        return Excel::download(new StockExport($id), 'report.xlsx');
    }

    public function pdfExport($id){

        $stocks=Personalizations::with('stock')
            ->whereIn('stock_id',[101,194,379,515,1134,1905,2146,2971])
            ->orderBy('id','desc')->get();
//        return view('personalizations.pdf', ['stock' => $stocks->first()]);
        foreach ($stocks as $stock) {


            $pdf = PDF::loadView('personalizations.pdf', ['stock' => $stock], [], [
                'format' => 'A4',
                'font_path' => base_path('public/assets/fonts/'),
                'font_data' => [
                    'tunisia' => [
                        'R' => 'tunisia.ttf',    // optional: bold-italic font
                        'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                        'useKashida' => 75,
                    ]
                    // ...add as many as you want.
                ],
                'margin_left'           => 0,
                'margin_right'          => 0,
                'margin_top'            => 0,
                'margin_bottom'         => 0,
            ]);
          if(File::exists($stock->stock_id.'_'.$stock->stock->user->branch->name.'_'.$stock->stock->bank->ar_name.'.pdf')){
              File::delete($stock->stock_id.'_'.$stock->stock->user->branch->name.'_'.$stock->stock->bank->ar_name.'.pdf');
          }

        $pdf->stream($stock->stock_id.'_'.$stock->stock->user->branch->name.'_'.$stock->stock->bank->ar_name.'.pdf');
        }
        return 'done';
    }
    public function pdfExport2($id){

        $stocks=Personalization::with('stock')->
            whereIn('id',[91,
4456,
178,
4457,
357,
4458,
486,
4459,
1073,
4460,
1792,
4461,
2023,
4462,
2804,
4463,])->get();
//        return view('personalizations.pdf', ['stock' => $stocks->first()]);
        
        foreach ($stocks as $stock) {


            $pdf = PDF::loadView('personalizations.pdf', ['stock' => $stock], [], [
                'format' => 'A4',
                'font_path' => base_path('public/assets/fonts/'),
                'font_data' => [
                    'tunisia' => [
                        'R' => 'tunisia.ttf',    // optional: bold-italic font
                        'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                        'useKashida' => 75,
                    ]
                    // ...add as many as you want.
                ],
                'margin_left'           => 0,
                'margin_right'          => 0,
                'margin_top'            => 0,
                'margin_bottom'         => 0,
            ]);
           if(File::exists($stock->id.'_'.$stock->stock_id.'_'.$stock->stock->user->branch->name.'_'.$stock->stock->bank->ar_name.'.pdf')){
               File::delete($stock->id.'_'.$stock->stock_id.'_'.$stock->stock->user->branch->name.'_'.$stock->stock->bank->ar_name.'.pdf');
           }

        $pdf->save($stock->id.'_'.$stock->stock_id.'_'.$stock->stock->user->branch->name.'_'.$stock->stock->bank->ar_name.'.pdf');
        }
        return 'done';
    }
}

