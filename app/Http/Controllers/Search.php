<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ilast_md;

class Search extends Controller
{
	public function ilast(Request $request)
	{
		#モデルをインスタンス化
		$md = new Ilast_md;
		#セッションをインスタンス化
		$ses = new SessionController;
		#セッションを確認
        $sesret = $ses->sescheck($request);
		if($sesret != 0) {
            return redirect('/login');
        }

		$word = $request->q;

		$sql = $md->where('tag',$word)->get('path','title');
		return view('search',compact('sql'));
	}

}
