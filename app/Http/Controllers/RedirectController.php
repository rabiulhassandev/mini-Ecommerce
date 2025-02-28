<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function homeToAdmin()
    {
        return \redirect()->route('admin.dashboard');
    }
}
