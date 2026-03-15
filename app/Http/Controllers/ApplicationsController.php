<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;

class ApplicationsController extends Controller
{
    public function register($id){
        $contest = Contest::findOrFail($id);
        dd($contest->contestForm()->get()->toArray());
    }

    public function storeRegister(Request $request){
        dd($request->all());
    }
}
