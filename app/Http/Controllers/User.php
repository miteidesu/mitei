<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_md;
use App\Http\Controllers\SessionController;

class User extends Controller
{
    #新規登録
    public function signup() 
    {
        $User = new User;
        #Userモデルをインスタンス化
        $md = new User_md;
        #Sessionコントローラーをインスタンス化
        $ses = new SessionController;

        #ユーザー名とパスワードをPOSTメソッドで取得
        $name = $_POST['name'];     #ユーザー名
        $passwd = $_POST['passwd']; #パスワード
        $mail = $_POST['mail'];     #メールアドレス

        #パスワードをハッシュ化
        $hpasswd = password_hash($passwd,PASSWORD_DEFAULT);
            #ユーザー名からユーザーidを取得
            $uid = $User->id($name);
            #ユーザー名とパスワードをDBに保存
            $md->fill(['uid'=>$uid,'name'=>$name,'password'=>$hpasswd,'mail'=>$mail]);
            $md->save();

            #セッションにユーザーidと名前とメールアドレスを挿入
            $ses->up($uid,$name,$mail);
        #ビューに遷移する
        return redirect('/');
    }

    #ログイン
    public function login()
    {
        #Userモデルをインスタンス化
        $md = new User_md;
        #Sessionコントローラーをインスタンス化
        $ses = new SessionController;
        #メールアドレスとパスワードを取得
        $mail = $_POST['mail'];
        $passwd = $_POST['passwd'];
        #データベースからパスワードを取得
        $dbpasswd = $md->where('mail',$mail)->first('password');

        #パスワードが合ってればセッションに挿入してトップページに遷移する
        if(password_verify($passwd,$dbpasswd)) {
            $uid = id();
            $name = $md->where('mail',$mail)->first('name');
            $ses->put($uid,$name,$mail);
            return redirect('/');
        }else{
            #パスワードが間違っていればログインフォームに戻る
            return redirect('/login');
        }
    }

    public function logout(Request $request)
    {
        #Sessionコントローラーをインスタンス化
        $ses = new SessionController;
        #セッションクッキーを削除する
        $ses->logout($request);
        return redirect('/login');
    }

    public function delete()
    {
        #Userモデルをインスタンス化
        $md = new User_md;
        #Sessionコントローラーをインスタンス化
        $ses = new SessionController;
        #ここでセッションからメールアドレスを取得＆セッションを削除
        $mail = $ses->delete();
        #データベースのレコードを削除
        $del = $md->where('mail',$mail)->delete();

        return redirect('/signup');
    }

    public function id($name)
    {
        #ユーザーモデルをインスタンス化
        $md = new User_md;
        $i = 0;
        while(true) {
            #デフォルトのユーザーidをmd5で生成する
            $id = md5($name);
            $uid = substr($id,$i,$i+8);
            $ret = $md->where('uid',$uid)->first();
            if($ret == NULL){
                break;
            }
            $i++;
        }
        return $uid;
    }
}
