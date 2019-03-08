<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get.admin/config    全部配置项列表
    public function index(){
        $data = Config::orderBy('conf_order', 'asc')->get();
        foreach ($data as $k=>$v) {
            switch ($v->field_type) {
                case 'text':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea name="conf_content[]" class="lg">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach ($arr as $m) {
                        $r = explode('|',$m);
                        $c = $v->conf_content == $r[0] ? ' checked ' : '';
                        $str .= '<input type="radio" name="conf_content[]"'.$c.' value="'.$r[0].'">'.$r[1].'&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index', compact('data'));
    }

    //get.admin/config/create     添加配置项
    public function create()
    {
        $data = [];
        return view('admin.config.add', compact('data'));
    }

    //post.admin/config
    public function store()
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token');
        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];
        $massage = [
            'conf_name.required'=>'配置项名称为必填项！',
            'conf_title.required'=>'配置项标题为必填项！',
        ];
        $validator = Validator::make($input, $rules,$massage);
        if ($validator->passes()) {
            $res = Config::create($input);
            if ($res) {
                $this->putFile();
                return redirect('admin/config');
            } else {
                $_SESSION['errors'] = '数据添加错误！';
                return back();
            }
        } else {
            $_SESSION['errors'] = $validator->errors()->first();
            return back();
        }
    }

    //get.admin/config/{config}/edit    编辑配置项
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit', compact('field'));
    }

    //put.admin/config/{config}     更新配置项
    public function update($conf_id)
    {
        $_SESSION['errors'] = null;
        $input = Input::except('_token', '_method');
        $res = Config::where('conf_id', $conf_id)->update($input);
        if ($res) {
            $this->putFile();
            return redirect('admin/config');
        } else {
            $_SESSION['errors'] = '数据更新失败！';
            return back();
        }
    }

    //delete.admin/config/{config}      删除单个配置项
    public function destroy($conf_id)
    {
        $res = Config::where('conf_id', $conf_id)->delete($conf_id);
        if ($res) {
            $this->putFile();
            $data = [
                'status'=>0,
                'msg'=>'配置项删除成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'配置项删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    public function changeOrder()
    {
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $res = $config->update();
        if ($res) {
            $data = [
                'status'=>0,
                'msg'=>'配置项更新成功！'
            ];
        } else {
            $data = [
                'status'=>1,
                'msg'=>'配置项更新失败，请稍后重试！'
            ];
        }
        return $data;
    }

    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v) {
            Config::where('conf_id', $v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back();
    }

    public function putFile()
    {
        echo \Illuminate\Support\Facades\Config::get('web.web_titile');
        $config = Config::pluck('conf_content', 'conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path, $str);
    }

    //get.admin/config/{config}     显示单个配置项
    public function show()
    {

    }
}
