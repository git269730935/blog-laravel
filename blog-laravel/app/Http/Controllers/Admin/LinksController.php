<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //get.admin/links    全部友情链接列表
    public function index(){
        $data = Links::orderBy('link_order', 'asc')->get();
        return view('admin.links.index', compact('data'));
    }

    //get.admin/links/create     添加友情链接
    public function create()
    {
        $data = [];
        return view('admin.links.add', compact('data'));
    }

    //post.admin/links
    public function store()
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
            'link_url'=>'required',
        ];
        $massage = [
            'link_name.required'=>'链接名称为必填项！',
            'link_url.required'=>'链接为必填项！',
        ];
        $validator = Validator::make($input, $rules,$massage);
        if ($validator->passes()) {
            $res = Links::create($input);
            if ($res) {
                return redirect('admin/links');
            } else {
                $_SESSION['errors'] = '数据添加错误！';
                return back();
            }
        } else {
            $_SESSION['errors'] = $validator->errors()->first();
            return back();
        }
    }

    //get.admin/links/{links}/edit    编辑友情链接
    public function edit($link_id)
    {
        $field = Links::find($link_id);
        return view('admin.links.edit', compact('field'));
    }

    //put.admin/links/{links}     更新友情链接
    public function update($link_id)
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token', '_method');
        $res = Links::where('link_id', $link_id)->update($input);
        if ($res) {
            return redirect('admin/links');
        } else {
            $_SESSION['errors'] = '数据更新失败！';
            return back();
        }
    }

    //delete.admin/links/{links}      删除单个友情链接
    public function destroy($link_id)
    {
        $res = Links::where('link_id', $link_id)->delete($link_id);
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'链接删除成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'链接删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    public function changeOrder()
    {
        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $res = $links->update();
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'友情链接更新成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'友情链接更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //get.admin/links/{links}     显示单个友情链接
    public function show()
    {

    }
}
