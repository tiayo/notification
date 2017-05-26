@extends('layouts.app')

@section('title', '收银台-退款申请')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_2"><i class="fa fa-home" aria-hidden="true"></i><a href="">我的订单</a></li>
    <li navValue="nav_2_1"><a href="">订单详情</a></li>
    <li><a href="">退款申请</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInRight">
        <div class="col-md-12">
            <h4 class="section-subtitle"><b>{{config('site.title')}}收银台</b></h4>
            <div class="panel">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal form-stripe" id='alipayment' action='/admin/order/refund/{{$order['order_id']}}' method='post'>
                                {{ csrf_field() }}
                                <h6 class="mb-xlg text-center"><b>申请退款 (输入退款理由更容易退款成功)</b></h6>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">商户订单号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="out_trade_no" value="{{$order['order_number']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">交易号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="trade_no" value="{{$order['trade_no']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款金额(RMB)</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="refund_amount" class="form-control" name="refund_amount" value="{{$refund['refund_amount'] or ''}}" placeholder="最多可以退{{$order['total_amount']}}元。"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="WIDbody" class="col-sm-2 control-label">退款原因</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund['refund_reason'] or ''}}" name="refund_reason" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款单号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="refund_number" value="{{$refund['refund_number'] or $refund_number}}" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-primary btn-block" id="submit_form" type="button">提交 退款 申请</button>
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
    <script>
        $(document).ready(function () {
            $('#submit_form').click(function () {
                refund_amount = $('#refund_amount').val();
                if (refund_amount === '' || refund_amount == 0) {
                    alert('退款金额不能为空');
                    return false;
                }

                if (!(/^(\+|-)?\d+$/.test(refund_amount))) {
                    if (refund_amount > 0) {
                        refund_amount = parseFloat(refund_amount);
                        if (refund_amount.toString().split(".")[1].length > 2) {
                            alert('退款金额格式错误，最多只能有两位小数。');
                            return false;
                        }
                    } else {
                        alert('退款金额必须大于0元!');
                        return false;
                    }
                }

                if (refund_amount > {{$order['total_amount']}}) {
                    alert('退款金额必须大于0元小于{{$order['total_amount']}}元');
                    return false;
                }

                $('#alipayment').submit();
            })
        })
    </script>
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
@endsection