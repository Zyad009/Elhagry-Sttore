<?php

namespace App\Http\Controllers\Dashboard\Admin\Shepping\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSheppingController extends Controller
{
    public function index(){
        return view("admin.pages.shepping.index");
    }
}
