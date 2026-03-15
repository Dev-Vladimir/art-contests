<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contest;

class IndexController extends Controller
{
    public function contests(){
        $contests = Contest::where('is_active', true)->where('open', true)->select('id', 'title')->get();
        return view('guest.contest-index', compact('contests'));
    }

    public function news(){
        echo 'news page';
    }
}
