<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    public function pass()
    {
        $_SESSION['errors'] = null;
        if ($input = Input::all()) {
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            $massage = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'新密码与确认密码不一致！',
            ];
            $validator = Validator::make($input, $rules,$massage);

            if ($validator->passes()) {
                $user = User::first();
                if ($input['password_o'] != Crypt::decrypt($user->user_pass)) {
                    $_SESSION['errors'] = '原密码错误！';
                    return view('admin.pass');
                }
                $user->user_pass = Crypt::encrypt($input['password']);
                $user->update();
                return redirect('admin/info');
            } else {
                $_SESSION['errors'] = $validator->errors()->first();
                return view('admin.pass');
            }
        } else {
            return view('admin.pass');
        }
    }
}
