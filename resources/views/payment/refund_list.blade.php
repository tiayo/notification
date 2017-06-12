@extends('layouts.app')

@section('title', '退款列表')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_3"><i class="fa fa-home" aria-hidden="true"></i><a href="/">管理操作</a></li>
    <li navValue="nav_3_2"><a href="/admin/task/page/">全部管理退款</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInRight">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>全部退款申请</b></h4>
            <div class="panel">
                <div class="panel-content">
                    <div class="table-responsive">
                        <div id="basic-table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="basic-table" class="data-table table table-striped nowrap table-hover dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="basic-table_info" style="width: 100%;">
                                        <thead>
                                        <tr role="row">
                                            <th>编号<i class="sort"><img src="/images/px.gif" /></i></th>
                                            <th>订单号</th>
                                            <th>订单号</th>
                                            <th>订单名称</th>
                                            <th>退款金额</th>
                                            <th>订单状态</th>
                                            <th>创建时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list_refund as $row)
                                            <tr role="row" class="odd">
                                                <td>{{$row['refund_id']}}</td>
                                                @if ($is_admin)
                                                    <td>{{$row['order_id']}}</td>
                                                @endif
                                                <td>{{$row['order_number']}}</td>
                                                <td>{{$row['order_title']}}</td>
                                                <td>{{$row['refund_amount']}}</td>
                                                <td>{{$status::refundStatus($row['refund_status'])}}</td>
                                                <td>{{$row['created_at']}}</td>
                                                <td>
                                                    <a href="/admin/refund/view/{{$row['refund_id']}}" class="tablelink">查看</a>
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