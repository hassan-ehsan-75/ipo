<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConditionController extends Controller{
    public function index(){
        return view('conditions.conditions');
    }
    public function create(){
        return view('conditions.create');
    }
    public function edit($id){
        return view('conditions.update');
    }
}