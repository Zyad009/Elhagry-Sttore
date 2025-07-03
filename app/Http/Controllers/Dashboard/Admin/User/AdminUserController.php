<?php

namespace App\Http\Controllers\Dashboard\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\SearchRequest;
use App\Models\User;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class AdminUserController extends Controller
{
    private const DIR_VIEW = "admin.pages.users";

    public function index()
    {
        $users = User::orderBy("id", "desc")->paginate(20);
        return view(SELF::DIR_VIEW . ".index", compact("users"));
    }

    public function search(SearchRequest $request)
    {
        $q = $request->validated();
        $search = $q["q"] ?? "";
        $users = User::where("phone", "LIKE", "%" . $search . "%")
        ->orWhere("name", "LIKE", "%" . $search . "%")
        ->paginate(20)
        ->withQueryString();

        if($users->isEmpty()){
            alert()->error("Error!" , "key words not found");
        }

        return view(SELF::DIR_VIEW . ".search", compact("users", "search"));
    }
}
