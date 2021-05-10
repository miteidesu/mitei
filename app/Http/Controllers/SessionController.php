<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_md;
use uminate\Support\Facades\Session;

class SessionController extends Controller
{
    #セッションを追加する
    public function up($id,$name,$mail,Request $request) 
    {
        #ユーザー名とメールアドレスを追加
        $request->session()->put('uid', $id);
        $request->session()->put('name', $name);
        $request->session()->put('mail', $mail);
        return 0;
    }

    public function sescheck(Request $req)
    {
        $md = new User_md;
        #ユーザーIDを取得
        $uid = $req->session()->exists('uid');

        $sql = $md->where('uid',$uid)->first();
        #セッションにユーザーidがあるか確認する
        if(isset($uid)) {
            if($sql != NULL){
                return 0;
            }
        }else{
            return 1;
        }
    }

    public function logout(Request $request)
    {
        $id = $request->session->get('name');
        if(is_null($id)){
            return redirect('/login');
        }
        setcookie($id);
        return 0;
    }

    #セッションからメールアドレスを取得してセッションを削除する
    public function delete()
    {
        $ret = Session::get('mail');
        Session::flush();
        return $ret;
    }

    #デバッグ用
    public function debug()
    {
        $id = Session::get('id');
        $name = Session::get('name');
        $ret = array('idd'=>$id,'name'=>$name);
        return $ret;
    }


}
