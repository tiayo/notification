@extends('layouts.app')

@section('title', '我的任务')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li value="nav_1"><i class="fa fa-home" aria-hidden="true"></i><a href="/">控制台</a></li>
    <li value="nav_1_1"><a href="/admin/task/page/">我的任务</a></li>
@endsection

@section('content_body')
            <div class="row animated fadeInRight">
                <div class="col-sm-12">
                    <h4 class="section-subtitle"><b>我的任务</b></h4>
                    <div class="panel">
                        <div class="panel-content">
                            <div class="table-responsive">
                                <div id="basic-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="basic-table" class="data-table table table-striped nowrap table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="basic-table_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th>任务编号<i class="sort"><img src="/images/px.gif" /></i></th>
                                                        <th>任务标题</th>
                                                        @if ($admin)
                                                            <th>用户</th>
                                                        @endif
                                                        <th>分类</th>
                                                        <th>下次提醒时间</th>
                                                        <th>提醒计划</th>
                                                        <th>接收邮箱</th>
                                                        <th>接收手机</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($list_task as $row)
                                                    <tr role="row" class="odd">
                                                        <td>{{$row['task_id']}}</td>
                                                        <td>{{$row['title']}}</td>
                                                        @if ($admin)
                                                            <td>{{$row['user_id']}}</td>
                                                        @endif
                                                        <td>{{$row['name']}}</td>
                                                        <td>{{$row['start_time']}} {{$row['end_time'] or ''}}</td>
                                                        <td>{{$plan::plan($row['plan'])}}</td>
                                                        <td>{{$row['email']}}</td>
                                                        <td>{{$row['phone']}}</td>
                                                        <td>
                                                            <a href="/admin/task/update/{{$row['category_id']}}/{{$row['task_id']}}" class="tablelink">修改</a>
                                                            <a href="/admin/task/delete/{{$row['task_id']}}" class="tablelink"> 删除</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="dataTables_info">共{{$count}}条记录  当前显示第{{$page}}页</div>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="dataTables_paginate paging_simple_numbers">
                                                <ul class="pagination">
                                                    <li class="paginate_button previous"><a href="{{($page-1) < 1 ? 1 : ($page-1)}}">上一页</a></li>
                                                    @for ($i=1;$i<=$max_page;$i++)
                                                    <li class="paginate_button active"><a href="{{$i}}">{{$i}}</a></li>
                                                    @endfor
                                                    <li class="paginate_button next">
                                                        <a href="{{($page+1) > $max_page ? $max_page : $page+1}}">Next</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('script')
    @parent
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    <script src="/vendor/data-table/media/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/data-table/media/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var value = $('.breadcrumbs li');
            console.log(value.length);
        })
    </script>
@endsection