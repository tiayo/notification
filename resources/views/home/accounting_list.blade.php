@extends('layouts.app')

@section('title', '我的任务')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_6"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的记帐本</a></li>
    <li navValue="nav_6_3"><a href="/admin/task/page/">全部消费记录</a></li>
@endsection

@section('content_body')
            <div class="row animated fadeInRight">
                <div class="col-sm-12">
                    <h4 class="section-subtitle"><b>全部消费记录</b></h4>
                    <div class="panel">
                        <div class="panel-content">
                            <div class="table-responsive">
                                <div id="basic-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="basic-table" class="data-table table table-striped nowrap table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="basic-table_info" style="width: 100%;">
                                                <thead>
                                                    <tr role="row">
                                                        <th>记录编号<i class="sort"><img src="/images/px.gif" /></i></th>
                                                        <th>消费内容</th>
                                                        <th>消费类型</th>
                                                        <th>消费时间</th>
                                                        <th>消费金额</th>
                                                        <th>消费地点</th>
                                                        <th>状态</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($lists as $list)
                                                    <tr role="row" class="odd">
                                                        <td>{{ $list['accounting_id'] }}</td>
                                                        <td>{{  $list['title'] }}</td>
                                                        <td>{{ $controller::accountingType($list['type'] )}}</td>
                                                        <td>{{ $list['time']}} {{$row['end_time'] or '' }}</td>
                                                        <td>{{ $list['money'] }}元</td>
                                                        <td>{{ $list['location'] }}</td>
                                                        <td>

                                                            @if ($list['status'] == 0)
                                                                <button class="btn btn-sm btn-warning" onclick="location='{{ Route('accounting_status', ['id' => $list['accounting_id']]) }}'">非周期消费</button>
                                                                @else
                                                                <button class="btn btn-sm btn-success" onclick="location='{{ Route('accounting_status', ['id' => $list['accounting_id']]) }}'">周期消费</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info" onclick="location='{{ Route('accounting_update', ['id' => $list['accounting_id'], 'type' => 'update']) }}'"> 修改</button>
                                                            <button class="btn btn-danger" onclick="if(confirm('删除后不可恢复，确定要删除吗？') === false)return false;location='{{ Route('accounting_destroy', ['id' => $list['accounting_id']]) }}'"> 删除</button>
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