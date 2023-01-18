<?php

namespace App\Http\Controllers;

use App\Form;
use App\Helpers\UploadFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FormsController extends Controller{
    public function index(){

        if(request('search'))
        {
            $attr = request()->validate(['search'=>'max:255']);
            $forms = Form::where('name','like','%'.$attr['search'].'%')->paginate(10);
        }else
            $forms = Form::paginate(10);

        return view('forms.forms',['forms'=>$forms]);
    }
    public function show($id){
        $form = Form::find($id);
        return view('forms.show',['form'=>$form]);
    }
    public function create(){
        return view('forms.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'file'=>'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt'
        ]);
        $form = Form::create($request->except(['file']));
        if($request->hasFile('file'))
            $form->file = $request->file('file')->store('public/form');
        $form->save();
        return back()->with(['success'=>'تمت الاضافة بنجاح']);
    }
    public function edit($id){
        $form = Form::find($id);
        return view('forms.edit',['form'=>$form]);

    }
    public function update($id,Request $request){
        $form = Form::find($id);
        $this->validate($request,[
            'name'=>'required|max:255',
            'file'=>'nullable|max:10000|mimes:jpeg,jpg,png,pdf,doc,docx,svg,webp,txt'
        ]);
        $form->update($request->except(['file']));
        if($request->hasFile('file'))
        {
            File::delete(public_path($form->avatar));
            $form->file = $request->file('file')->store('public/form');
        }
        $form->save();
        return back()->with(['success'=>'تم التعديل بنجاح']);
    }
    public function destroy($id){
        $form = Form::find($id);
        File::delete(public_path($form->avatar));
        $form->delete();
        return redirect('/forms');
    }
}