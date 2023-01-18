<?php

namespace App\Http\Requests;

use App\Company;
use App\Rules\StockBranchRole;
use App\Rules\StockMaxRole;
use App\Rules\StockMinRole;
use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company=Company::first();
        if ($company==null){
            abort(404);
        }
        request()->request->add(['company'=>$company]);
        request()->request->add(['company_id'=>$company->id]);
        $this->request->add(['company_id'=>$company->id]);
        return [

                'full_name' => 'required|max:45|min:2',
                'last_name'=>'required|max:45|min:2',
                'p_number' => 'required|max:45|min:8',
                'identity_img' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp',
                'family_img' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp',
	            'procuration_img' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp',
            	'civil_img' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp',
                'mobile' => 'required|max:45|min:10',
                'phone' => 'nullable|max:45|min:4',
                'email' => 'nullable|email|max:255|min:7',
                'fax' => 'nullable|max:45',
                'address' => 'required|max:2000',
                'mother' => 'required|max:255|min:2',
                'father' => 'required|max:255|min:2',
                'birthday' => 'required|max:255|min:4',
                'gender' => 'required|max:255',
                'nation' => 'required|max:255|min:2',
                'record_number' => 'nullable|max:45',
                'record_img' => 'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp',
                'stock_number' => ['required','max:45',new StockMinRole($company->min_stock),new StockMaxRole($company->stocks),new StockBranchRole($company->id)],
                'total' => 'required|max:45',
                'id_date' => 'required|max:45|min:4',
                'id_from' => 'required|max:45|min:2',
                'id_type'=>'required|max:45',
                'city'=>'required|max:45|min:2',
        ];
    }
}
