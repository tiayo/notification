@extends('layouts.app')
删除@extends('layouts.app')

@section('title', '我的订单')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_2"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的订单</a></li>
    <li navValue="nav_2_2"><a href="/admin/task/page/">全部订单</a></li>
@endsection

@section('content_body')
            <div class="row animated fadeInDown">
                <div class="col-sm-12">
                    <h4 class="section-subtitle"><b>全部订单</b></h4>
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
                                                        @if ($is_admin)
                                                            <th>用户ID</th>
                                                        @endif
                                                        <th>订单号</th>
                                                        <th>订单名称</th>
                                                        <th>金额</th>
                                                        <th>交易状态</th>
                                                        <th>订单状态</th>
                                                        <th>创建时间</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($list_order as $row)
                                                    <tr>
                                                        <td>{{$row['order_id']}}</td>
                                                        @if ($is_admin)
                                                            <td>{{$row['user_id']}}</td>
                                                        @endif
                                                        <td>{{$row['order_number']}}</td>
                                                        <td>{{$row['title']}}</td>
                                                        <td>{{$row['total_amount']}}</td>
                                                        <td>
                    <span class="@if ($row['payment_status'] != 1) color-danger @else color-success @endif">
                       {{$status::paymentStatus($row['payment_status'])}} ({{$row['payment_type'] or 'no'}})
                    </span>
                                                        </td>
                                                        <td>
                    <span class="@if ($row['order_status'] != 1) color-danger @else color-success @endif">
                        {{$status::orderStatus($row['order_status'])}}
                    </span>
                                                        </td>
                                                        <td>{{$row['created_at']}}</td>
                                                        <td>
                                                            <a href="/admin/order/view/{{$row['order_id']}}" class="tablelink">查看</a>
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