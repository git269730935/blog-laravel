<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\IndexController;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.php';

class LoginController extends CommonController
{
    public function login()
    {
        $_SESSION['msg'] = null;
        if ($input = Input::all()) {
            if (strtoupper($input['code']) != strtoupper($_SESSION['code'])) {
                $_SESSION['msg'] = '验证码错误！';
                return view('admin.login');
            }
            $user = User::first();
            if ($input['user_name'] != $user->user_name || md5($input['user_pass']) != $user->user_pass) {
                $_SESSION['msg'] = '用户名或密码不正确！';
                return view('admin.login');
            }
            session(['user'=>$user]);
            return redirect('admin');
        } else {
            return view('admin.login');
        }
    }

    public function code()
    {
        $code = new \Code(80,30,4);
        $_SESSION['code'] = $code->getcode();
        $code->outimg();
    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }
}
