@extends('layouts.app')

@section('title', '收银台-退款审核')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_3"><i class="fa fa-home" aria-hidden="true"></i><a href="">管理操作</a></li>
    <li navValue="nav_3_1"><a href="">退款操作</a></li>
    <li><a href="">退款审核</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInRight">
        <div class="col-md-12">
            <h4 class="section-subtitle"><b>{{config('site.title')}}收银台</b></h4>
            <div class="panel">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal form-stripe" id='confirm_form' method="get">
                                {{ csrf_field() }}
                                <h6 class="mb-xlg text-center"><b>退款审核(同意或拒绝都需要批复)</b></h6>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款编号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="refund_number" value="{{$refund['refund_number']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">订单名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['order_title']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款金额(RMB)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['refund_amount']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款原因</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['refund_reason']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款状态</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$judge::refundStatus($refund['refund_status'])}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">付款类型</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$judge::paymentType($refund['payment_type'])}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">交易号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['trade_no'] or '未获取'}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">订单号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['order_number'] or '未获取'}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">用户</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['name']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">商家回复</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['reply'] or ''}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">更新时间</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['updated_at']}}" readonly/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-primary btn-block" id="refuse"  type="button">拒绝 退款</button>
                                        <button class="btn btn-primary btn-block" id="agree"  type="button">同意 退款</button>
                                        <button class="btn btn-primary btn-block" type="button" onclick="location.href='/admin/refund/page/1'">返回</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            $('#agree').click(function () {
                $('#confirm_form').attr('action', '/admin/refund/confirm/agree/');
                $('#confirm_form').submit();
            });

            $('#refuse').click(function () {
                $('#confirm_form').attr('action', '/admin/refund/confirm/refuse');
                $('#confirm_form').submit();
            });
        });
    </script>
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
@endsection