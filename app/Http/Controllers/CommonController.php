<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{

    /**
     *
     * User Status check and block user show this page
     *
     */
    public function userBlock()
    {
        if (\auth()->user()->status->id == 1) {
            return view('pages.admin.user-block.pending');
        } elseif (\auth()->user()->status->id == 3) {
            return view('pages.admin.user-block.suspend');
        }
        return redirect()->route('admin.dashboard');
    }
}
