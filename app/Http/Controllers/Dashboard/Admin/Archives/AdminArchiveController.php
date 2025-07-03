<?php

namespace App\Http\Controllers\Dashboard\Admin\Archives;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminArchiveController extends Controller
{
    public function index() 
    {
        return view("dashboard.admin.archives.index");
    }
}
