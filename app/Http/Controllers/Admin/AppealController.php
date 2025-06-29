<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appeal;

class AppealController extends Controller
{
    public function index()
    {
        $appeals = Appeal::with('user','ban')->paginate(10);
        return view('admin.appeals.index', compact('appeals'));
    }

    public function update(Request $r, Appeal $appeal)
    {
        $data = $r->validate(['status'=>'required|in:approved,rejected']);
        $appeal->update($data);
        return back()->with('success','Appeal '.$data['status'].' berhasil.');
    }
}

