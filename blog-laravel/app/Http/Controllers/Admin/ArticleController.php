<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends commonController
{
    //get.admin/article    全部文章列表
    public function index()
    {
        $data = Article::orderBy('art_id', 'desc')->paginate(10);
        return view('admin.article.index', compact('data'));
    }

    //get.admin/article/create     添加文章
    public function create()
    {
        $data = (new Category)->tree();;
        return view('admin.article.add', compact('data'));
    }

    //post.admin/article    //添加文章提交
    public function store() {
        $_SESSION['errors'] = null;
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];
        $massage = [
            'art_title.required'=>'文章标题为必填项！',
            'art_content.required'=>'文章内容为必填项！',
        ];

        $validator = Validator::make($input, $rules,$massage);
        if ($validator->passes()) {
            $res = Article::create($input);
            if ($res) {
                return redirect('admin/article');
            } else {
                $_SESSION['errors'] = '数据添加错误！';
                return back();
            }
        } else {
            $_SESSION['errors'] = $validator->errors()->first();
            return back();
        }
    }

    //get.admin/article/{article}/edit    编辑文章
    public function edit($art_id) {
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit', compact('data','field'));
    }

    //put.admin/article/{article}     更新文章
    public function update($art_id)
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token', '_method');
        $res = Article::where('art_id', $art_id)->update($input);
        if ($res) {
            return redirect('admin/article');
        } else {
            $_SESSION['errors'] = '数据更新失败！';
            return back();
        }
    }

    //delete.admin/article/{article}      删除单个文章
    public function destroy($art_id)
    {
        $res = Article::where('art_id', $art_id)->delete($art_id);
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'文章删除失败，请稍后重试！'
            ];
        }
        return $data;
    }
}
