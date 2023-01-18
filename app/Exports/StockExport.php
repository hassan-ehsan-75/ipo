<?php

namespace App\Exports;

use App\Personalization;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockExport implements FromArray,WithHeadings
{
    /**
     * StockExport constructor.
     */
    public $bank;
    public function __construct($bank)
    {
        $this->bank=$bank;
    }


    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'الرقم التسلسلي',
            'رقم الاكتتاب',
            'اسم المكتتب الثلاثي',
            'الرقم الوطني للمكتتب',
            'تاريخ الميلاد',
            'نوع الوثيقه',
            'تاريخ اصدارالوثيقه الرسمية',
            'مكان اصدارالوثيقه الرسمية',
            'اسم المكتتب',
            'اسم الاب',
            'اسم الام',
            'الكنية',
            'الجنس',
            'الجنسية',
            'المدينة',
            'العنوان',
            'الهاتف',
            'الهاتف المحمول',
            'البريد الالكتروني',
            'عدد الاسهم المكتتب بها',
            'قيمة الاسهم المكتتب بها',
            'الاسهم الممنوحة بدون تخصيص',
            'عدد الاسهم الاضافيه',
            'عدد الأسهم المخصصة على أساس تناسبي ',
            'إجمالي عدد الأسهم المخصصة بعد التقريب حسب المعادلة المقترحة',
            'القيمة المالية للأسهم النهائية المكتتب بها بعد التخصيص (حصة البنك الوطني)',
            'القيمة المالية للأسهم الفائضة (الرديات للمكتتبين)',
            'نوع المكتتب',
            'البنك المكتتب به',
            'الفرع',
        ];
    }


    /**
     * @return array
     */
    public function array(): array
    {

        $data=[];
        if($this->bank!=0){
            $stocks=Personalization::whereHas('stock',function ($query){
                $query->where('bank_id',$this->bank);
            })->get();
        }else{
            $stocks=Personalization::all();
        }
        foreach ($stocks as $persion){
            array_push($data,[
               $persion->id,
               $persion->stock_id,
                $persion->stock->full_name.' '.$persion->stock->father.' '.$persion->stock->last_name,
                $persion->stock->p_number,
                $persion->stock->birthday,
                $persion->stock->id_type=='اخرى' ? $persion->stock->id_other:$persion->stock->id_type,
                $persion->stock->id_date,
                $persion->stock->id_from,
                substr($persion->stock->full_name,strpos(' ',$persion->stock->full_name)),
                $persion->stock->father,
                $persion->stock->mother,
                $persion->stock->last_name,
                $persion->stock->gender,
                $persion->stock->nation,
                $persion->stock->city,
                $persion->stock->address,
                $persion->stock->phone,
                $persion->stock->mobile,
                $persion->stock->email,
                $persion->stock_number,
                $persion->total,
                $persion->min_stocks,
                $persion->additional_stocks,
                $persion->percentage_stocks,
                $persion->total_round,
                $persion->total_round*100,
                ($persion->stocks_number-$persion->total_round)*100,
                'طبيعي',
                $persion->stock->bank->ar_name,
                $persion->stock->user->branch->name,




            ]);
        }
        return $data;
    }


}
