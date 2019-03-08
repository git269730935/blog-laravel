<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //get.admin/navs    全部自定义导航列表
    public function index(){
        $data = Navs::orderBy('nav_order', 'asc')->get();
        return view('admin.navs.index', compact('data'));
    }

    //get.admin/navs/create     添加自定义导航
    public function create()
    {
        $data = [];
        return view('admin.navs.add', compact('data'));
    }

    //post.admin/navs
    public function store()
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token');
        $rules = [
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];
        $massage = [
            'nav_name.required'=>'导航名称为必填项！',
            'nav_url.required'=>'导航为必填项！',
        ];
        $validator = Validator::make($input, $rules,$massage);
        if ($validator->passes()) {
            $res = Navs::create($input);
            if ($res) {
                return redirect('admin/navs');
            } else {
                $_SESSION['errors'] = '数据添加错误！';
                return back();
            }
        } else {
            $_SESSION['errors'] = $validator->errors()->first();
            return back();
        }
    }

    //get.admin/navs/{navs}/edit    编辑自定义导航
    public function edit($nav_id)
    {
        $field = Navs::find($nav_id);
        return view('admin.navs.edit', compact('field'));
    }

    //put.admin/navs/{navs}     更新自定义导航
    public function update($nav_id)
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token', '_method');
        $res = Navs::where('nav_id', $nav_id)->update($input);
        if ($res) {
            return redirect('admin/navs');
        } else {
            $_SESSION['errors'] = '数据更新失败！';
            return back();
        }
    }

    //delete.admin/navs/{navs}      删除单个自定义导航
    public function destroy($nav_id)
    {
        $res = Navs::where('nav_id', $nav_id)->delete($nav_id);
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'导航删除成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'导航删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    public function changeOrder()
    {
        $input = Input::all();
        $navs = Navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $res = $navs->update();
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'自定义导航更新成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'自定义导航更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //get.admin/navs/{navs}     显示单个自定义导航
    public function show()
    {

    }
}
