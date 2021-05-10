<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ilast_md;

class Post extends Controller
{
    public function ilast(Request $request)
    {
        $md = new Ilast_md;

        $id = time() + rand(1000,9999);
        $file = $request->file('file');

        $file->storeAs('',$id);

        return view('true');
    }
}
