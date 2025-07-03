<?php

namespace App\Http\Controllers\Dashboard\Admin\Message;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminMessageController extends Controller
{
    private const DIR_VIEW = "dashboard.admin.message";

    public function index(){
        $messages = Message::orderBy("id", "desc")->paginate(config("pagination.count"));
        return view(SELF::DIR_VIEW . ".index" ,compact("messages"));
    }

    public function destroy(Message $message){
        $message->delete();
        alert()->success("Deleted", "deleted has been successfully");

        return back();
    }

    public function markAsRead($notification)
    {
        $notification = Auth::guard('admin')->user()->notifications->find($notification);
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    }
}
