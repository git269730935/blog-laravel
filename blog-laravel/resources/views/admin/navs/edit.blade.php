@extends('layouts.admin')
@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/navs')}}">自定义导航管理</a> &raquo; 编辑自定义导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            <?php
            if (isset($_SESSION['msg'])) {
                echo '<div class="mark">
                            <p>'.$_SESSION['errors'].'</p>
                       </div>';
            }
            ?>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs/'.$field->nav_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>导航名称：</th>
                    <td>
                        <input type="text" name="nav_name" value="{{$field->nav_name}}">
                        <input type="text" class="sm" name="nav_alias" value="{{$field->nav_alias}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>Url：</th>
                    <td>
                        <input type="text" class="lg" name="nav_url" value="{{$field->nav_url}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>必填</span>
                    </td>
                </tr>
                <tr>
                    <th>排序：</th>
                    <td>
                        <input type="text" class="sm" name="nav_order" value="{{$field->nav_order}}">
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
@endsection