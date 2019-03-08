@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/config')}}">网站配置项管理</a> &raquo; 修改网站配置项
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            <?php
                if (isset($_SESSION['errors'])) {
                    echo '<div class="mark">
                                <p>'.$_SESSION['errors'].'</p>
                           </div>';
                }
            ?>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加网站配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部网站配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config/'.$field->conf_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value="{{$field->conf_title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name" value="{{$field->conf_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="field_type" value="text" onclick="onTr()" @if($field->field_type == 'text') checked @endif>text &nbsp;&nbsp;&nbsp;
                            <input type="radio" name="field_type" value="textarea" onclick="onTr()" @if($field->field_type == 'textarea') checked @endif>textarea &nbsp;&nbsp;&nbsp;
                            <input type="radio" name="field_type" value="radio" onclick="onTr()" @if($field->field_type == 'radio') checked @endif>radio &nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr class="field_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" class="sm" name="field_value" value="{{$field->field_value}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>类型为"radio"才需要配置，1|开启,0|关闭</span>
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea cols="30" rows="10" name="conf_tips">{{$field->conf_tips}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="{{$field->conf_order}}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</body>
<script>
    onTr();
    function onTr() {
        var type = $('input[name=field_type]:checked').val();
        if (type == 'radio') {
            $('.field_value').show();
        } else {
            $('.field_value').hide();
        }
    }
</script>
@endsection