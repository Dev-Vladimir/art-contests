<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function contests(){
        echo 'contests page';
    }

    public function news(){
        echo 'news page';
    }
}
