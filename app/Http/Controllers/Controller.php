<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function redirectLogin()
    {
        if (auth()->user()->role == 0) {
            return redirect()->route('home');
        } elseif (auth()->user()->role == 1) {
            return redirect()->route('librarian.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }
}
