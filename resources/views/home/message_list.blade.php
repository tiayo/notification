@extends('layouts.app')

@section('title', '我的消息')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_5"><i class="fa fa-home" aria-hidden="true"></i><a href="/">会员中心</a></li>
    <li navValue="nav_5_3"><a href="/admin/task/page/">我的消息</a></li>
@endsection

@section('content_body')
            <div class="row animated fadeInRight">
                <div class="col-sm-12">
                    <h4 class="section-subtitle"><b>我的消息</b></h4>
                    <div class="panel">
                        <div class="panel-content">
                            <div class="table-responsive">
                                <div id="basic-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="basic-table" class="data-table table table-striped nowrap table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="basic-table_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th>消息ID<i class="sort"><img src="/images/px.gif" /></i></th>
                                                        <th>消息内容</th>
                                                        <th>发送者</th>
                                                        <th>接收者</th>
                                                        <th>发送时间</th>
                                                        <th>消息状态</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($list_message as $row)
                                                    <tr role="row" class="odd @if ($row['status'] == 2) color-danger @endif">
                                                        <td>{{$row['message_id']}}</td>
                                                        <td>{{$row['content']}}</td>
                                                        <td>{{$message::find($row['message_id'])->profile['real_name']}}</td>
                                                        <td>{{$message::find($row['target_id'])->profile['real_name']}}</td>
                                                        <td>{{$row['created_at']}}</td>
                                                        <td>{{$judge::commentStatus($row['status'])}}</td>
                                                        <td>
                                                            @if ($admin)
                                                                @if ($row['status'] == 1)
                                                                    <a href="/admin/member/message/mask/{{$row['message_id']}}" class="tablelink">屏蔽</a>
                                                                @elseif ($row['status'] == 2)
                                                                    <a href="/admin/member/message/mask/{{$row['message_id']}}" class="tablelink">取消屏蔽</a>
                                                                @endif
                                                            @endif
                                                            <a href="/admin/member/comment/delete/{{$row['message_id']}}" class="tablelink" onclick="if(confirm('删除后不可恢复，确定要删除吗？') === false)return false;"> 删除</a>
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
                                                    <li class="paginate_button" id="paginate_button_{{$i}}"><a href="{{$i}}">{{$i}}</a></li>
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
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    <script src="/vendor/data-table/media/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/data-table/media/js/dataTables.bootstrap.min.js"></script>
@endsection