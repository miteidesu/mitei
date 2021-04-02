<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_md;

class User extends Controller
{
    public function signup()
    {
        #Userモデルをインスタンス化
        $md = new User_md;

        #ユーザー名とパスワードをPOSTメソッドで取得
        $name = $_POST['name'];
        $passwd = $_POST['passwd'];
        $mail = $_POST['mail'];

        password_hash($passwd,PASSWORD_DEFAULT);
        
            $md->fill(['name'=>$name,'password'=>$passwd,'mail'=>$mail]);
            $insert = $md->save();
            
                session();

        return view('signup_true',compact('insert'));
    }

}
