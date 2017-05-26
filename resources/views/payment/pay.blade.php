@extends('layouts.app')

@section('title', '收银台-订单详情')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_2"><i class="fa fa-home" aria-hidden="true"></i><a href="">我的订单</a></li>
    <li navValue="nav_2_1"><a href="">全部订单</a></li>
    <li><a href="">订单详情</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInRight">
        <div class="col-md-12">
            <h4 class="section-subtitle"><b>{{config('site.title')}}收银台</b></h4>
            <div class="panel">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal form-stripe" method="post" id='pay_form' target="_blank">
                                {{ csrf_field() }}
                                <h6 class="mb-xlg text-center"><b>订单详情(如果有问题，请联系客服)</b></h6>
                                <div class="form-group">
                                    <label for="WIDout_trade_no" class="col-sm-2 control-label">商户订单号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="WIDout_trade_no" value="{{$order['order_number']}}" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="WIDsubject" class="col-sm-2 control-label">订单名称</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="WIDsubject" name="WIDsubject" value="{{$order['title']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email3" class="col-sm-2 control-label">付款金额(RMB)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="WIDtotal_amount" name="WIDtotal_amount" value="{{$order['total_amount']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="WIDbody" class="col-sm-2 control-label">商品描述</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="WIDbody" name="WIDbody" value="{{$order['content']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">订单状态</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$judge::orderStatus($order['order_status'])}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">付款类型</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$judge::paymentType($order['payment_type'])}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">付款状态</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$judge::paymentStatus($order['payment_status'])}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">交易号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$order['trade_no'] or '未获取'}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">下单用户</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$order['name']}}" readonly />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">创建时间</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$order['created_at']}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">更新时间</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$order['updated_at']}}" readonly/>
                                    </div>
                                </div>
                                {{--退款信息开始--}}
                                @if (!empty($refund))
                                    <h6 class="mb-xlg text-center color-warning"><b>退款信息(订单有退款时才会显示)</b></h6>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">退款金额</label>
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
                                        <label for="" class="col-sm-2 control-label">商家回复</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="{{$refund['reply']}}" readonly/>
                                        </div>
                                    </div>
                                @endif
                                {{--退款信息结束--}}
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        @if ($order['payment_status'] != 1)
                                        <button type="button" id="alipay" class="btn btn-primary btn-block">支付宝 支付</button>
                                        <button type="button" id="wxpay" class="btn btn-primary btn-block">微信 支付</button>
                                        @endif

                                        @if ($order['payment_status'] != 0)
                                                @if (empty($refund) || $refund['refund_status'] == 2)
                                                    <button class="btn btn-primary btn-block" type="button"
                                                            onclick="location.href='/admin/order/refund/{{$order['order_id']}}'">
                                                        退 款(申请)
                                                    </button>
                                                 @endif
                                        @endif
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
            $('#alipay').click(function () {
                $('#pay_form').attr('action', '/admin/alipay/pay');
                $('#pay_form').submit();
            });

            $('#wxpay').click(function () {
                $('#pay_form').attr('action', '/admin/wxpay/pay');
                $('#pay_form').submit();
            });
        });
    </script>
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
@endsection