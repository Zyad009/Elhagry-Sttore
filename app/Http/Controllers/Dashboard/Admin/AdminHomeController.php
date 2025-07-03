<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    // public function index(){
    //     return view("admin.pages.home.index");
    // }

    public function index(){
        return view('dashboard.admin.index');
    }
}
