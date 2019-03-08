<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends CommonController
{
    public function index()
    {
        //图文列表
        $data = Article::orderBy('art_time', 'desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order', 'asc')->get();

        return view('home.index', compact('data','links'));
    }

    public function cate($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(5);
        $submenu = Category::where('cate_pid', $cate_id)->get();
        Category::where('cate_id',$cate_id)->increment('cate_view');
        return view('home.list', compact('field','data', 'submenu'));
    }

    public function article($art_id)
    {
        $field = Article::Join('category', 'article.cate_id','=','category.cate_id')->where('art_id', $art_id)->first();
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id', 'desc')->take(6)->get();
        Article::where('art_id',$art_id)->increment('art_view');
        return view('home.new', compact('field','article', 'data'));
    }
}
