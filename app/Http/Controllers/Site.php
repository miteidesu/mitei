<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\SessionController;


class Site extends Controller
{
    public function index(Request $req){
        $ses = new SessionController;
        $sesret = $ses->sescheck($req);
        if($sesret != 0) {
            return redirect('/login');
        }
        return view('index',compact('sesret'));
    }

    public function debug()
    {
        $ses = new SessionController;
        $sesde = $ses->debug();
        var_dump($sesde);
    }
}
