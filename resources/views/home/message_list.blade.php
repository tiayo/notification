@extends('layouts.app')

@section('title', $type)

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_5"><i class="fa fa-home" aria-hidden="true"></i><a href="/">会员中心</a></li>
    <li navValue="nav_5_3"><a href="/admin/task/page/">{{$type}}</a></li>
@endsection

@section('content_body')
            <div class="row animated fadeInLeft">
                <div class="col-sm-12">
                    @if ($type == '收到的消息')
                        <h4 class="section-subtitle"><b>{{$type}}</b></h4>
                        <p class="section-text">
                            <a href="{{route('message_send_page', ['page' => 1])}}">
                                <b>查看发出的信息</b>
                            </a>
                        </p>
                        @else
                        <h4 class="section-subtitle"><b>{{$type}}</b></h4>
                        <p class="section-text">
                            <a href="{{route('message_received_page', ['page' => 1])}}">
                                <b>查看收到的消息</b>
                            </a>
                        </p>
                    @endif

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
                                                    <tr role="row" class="odd @if ($row['status'] == 1) color-danger @endif ">
                                                        <td>{{$row['message_id']}}</td>
                                                        <td>{{$row['content']}}</td>
                                                        <td>{{$message::find($row['message_id'])->userProfile['real_name']}}</td>
                                                        <td>{{$message::where('target_id', $row['target_id'])->first()->targetProfile['real_name']}}</td>
                                                        <td>{{$row['created_at']}}</td>
                                                        <td>{{$judge::messageStatus($row['status'])}}</td>
                                                        <td>
                                                            @if ($row['user_id'] != Auth::id())
                                                                @if ($row['status'] == 1)
                                                                    <a href="/admin/member/message/read/{{$row['target_id']}}/2" class="tablelink">标记为已读</a>
                                                                @elseif ($row['status'] == 2)
                                                                    <a href="/admin/member/message/read/{{$row['target_id']}}/1" class="tablelink">标记为未读</a>
                                                                @endif
                                                                    <a href="/admin/member/message/send/{{$row['user_id']}}" class="tablelink">回复</a>
                                                            @endif
                                                            <a href="/admin/member/message/delete/{{$row['message_id']}}" class="tablelink" onclick="if(confirm('删除后不可恢复，确定要删除吗？') === false)return false;">删除消息</a>
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