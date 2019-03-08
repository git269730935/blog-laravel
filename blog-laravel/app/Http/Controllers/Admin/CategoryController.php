<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    //get.admin/category    全部分类列表
    public function index()
    {
        $categorys = (new Category)->tree();
        return view('admin.category.index')->with('data', $categorys);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $res = $cate->update();
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'分类排序更新成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'分类排序更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //get.admin/category/create     添加分类
    public function create()
    {
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.add', compact('data'));
    }

    //post.admin/category
    public function store()
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token');
        $rules = [
            'cate_name'=>'required',
        ];
        $massage = [
            'cate_name.required'=>'分类名称为必填项！',
        ];
        $validator = Validator::make($input, $rules,$massage);
        if ($validator->passes()) {
            $res = Category::create($input);
            if ($res) {
                return redirect('admin/category');
            } else {
                $_SESSION['errors'] = '数据添加错误！';
                return back();
            }
        } else {
            $_SESSION['errors'] = $validator->errors()->first();
            return back();
        }
    }

    //get.admin/category/{category}/edit    编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.edit', compact('field','data'));
    }

    //delete.admin/category/{category}      删除单个分类
    public function destroy($cate_id)
    {
        $res = Category::where('cate_id', $cate_id)->delete($cate_id);
        Category::where('cate_pid', $cate_id)->update(['cate_pid'=>0]);
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'分类删除成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'分类删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //put.admin/category/{category}     更新分类
    public function update($cate_id)
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token', '_method');
        $res = Category::where('cate_id', $cate_id)->update($input);
        if ($res) {
            return redirect('admin/category');
        } else {
            $_SESSION['errors'] = '数据更新失败！';
            return back();
        }
    }

    //get.admin/category/{category}     显示单个分类
    public function show()
    {

    }
}
