<?php

namespace App\Http\Controllers\Dashboard\Admin\Account;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Auth;

class AdminAccountController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.account.index');
    }
}
