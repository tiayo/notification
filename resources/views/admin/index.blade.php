@extends('layouts.app')

@section('title', '控制台')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/toastr/toastr.min.css">
    <link rel="stylesheet" href="/vendor/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

            @section('breadcrumbs')
                <li navValue="nav_0"><i class="fa fa-home" aria-hidden="true"></i><a href="">控制台</a></li>
            @endsection

            @section('content_body')
            <div class="row animated fadeInUp">
                <div class="col-sm-12 col-lg-9">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="panel widgetbox wbox-2 bg-scale-0">
                                <a href="#">
                                    <div class="panel-content">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <span class="icon fa fa-globe color-darker-1"></span>
                                            </div>
                                            <div class="col-xs-8">
                                                <h4 class="subtitle color-darker-1">上次登录时间</h4>
                                                <h4 class="color-primary"> {{$next_login_time}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel widgetbox wbox-2 bg-lighter-2 color-light">
                                <a href="#">
                                    <div class="panel-content">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <span class="icon fa fa-user color-lighter"></span>
                                            </div>
                                            <div class="col-xs-8">
                                                <h4 class="subtitle color-lighter">欢迎您</h4>
                                                <h1 class="title color-w">{{$user_name}}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel widgetbox wbox-2 bg-darker-2 color-light">
                                <a href="{{ route('message_received_page_simple') }}">
                                    <div class="panel-content">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <span class="icon fa fa-envelope color-lighter"></span>
                                            </div>
                                            <div class="col-xs-8">
                                                <h4 class="subtitle color-lighter">未读信息</h4>
                                                <h1 class="title color-light">{{$message->meNoRead()}}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel widgetbox wbox-2 bg-darker-3 color-light">
                                <a href="#">
                                    <div class="panel-content">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <span class="icon fa fa-mail-reply color-lighter"></span>
                                            </div>
                                            <div class="col-xs-8">
                                                <h4 class="subtitle color-light">联系我们</h4>
                                                <h5 class="color-light">656861622@qq.com</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="panel widgetbox wbox-2 bg-darker-4 color-light">
                                <a href="{{ route('sponsor') }}">
                                    <div class="panel-content">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <span class="icon fa fa-money color-lighter"></span>
                                            </div>
                                            <div class="col-xs-8">
                                                <h4 class="subtitle color-light">赞助我们</h4>
                                                <h5 class="color-light">支付宝、微信支付</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <div class="tabs mt-none">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#home" data-toggle="tab">最新任务</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="home">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>主题</th>
                                                    <th>下次提醒时间</th>
                                                    <th>分类</th>
                                                    <th><i class="fa fa-cog" aria-hidden="true"></i>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($tasks as $task)
                                                    <tr>
                                                        <td>{{$task['title']}}</td>
                                                        <td>{{$task['start_time']}} {{$task['end_time'] or ''}}</td>
                                                        <td>{{$task['name']}}</td>
                                                        <td><a href="/admin/task/update/{{$task['category_id']}}/{{$task['task_id']}}" class="tablelink">修改</a></td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <div class="panel b-primary bt-md">
                                <div class="panel-content p-none">
                                    <div class="widget-list list-to-do">
                                        <h4 class="list-title">我的消息</h4>
                                        <button class="add-item btn btn-o btn-primary btn-xs">
                                            <a href="{{ route('message_received_page_simple') }}">查看</a>
                                        </button>
                                        <ul>
                                            @foreach ($message_list as $message)
                                            <li>
                                                <div class="checkbox-custom checkbox-primary">
                                                    <label for="check-h1">
                                                        {{$message['real_name'].':'.str_limit($message['content'], 80)}}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="timeline">
                        @foreach ($orders as $order)
                            <div class="timeline-box">
                                <div class="timeline-icon bg-primary">
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="tl-title">{{$order['title']}}</h4>
                                    <p style="line-height: 2rem; margin: 0;">
                                        {{$order['content']}}<br>
                                        订单号:{{$order['order_number']}}<br>
                                        <a href="/admin/order/view/{{$order['order_id']}}">
                                        @if ($order['payment_status'] == 0)
                                                <button type="button" class="btn btn-danger">
                                                    还未付款哦！
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success">
                                                    已经通过{{$status::paymentType($order['payment_type'])}}付款
                                                </button>
                                        @endif
                                        </a>
                                    </p>
                                </div>
                                <div class="timeline-footer">
                                    <span>{{$order['updated_at']}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endsection

@section('script')
    @parent
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    <script src="/vendor/toastr/toastr.min.js"></script>
    <script src="/vendor/chart-js/chart.min.js"></script>
    <script src="/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="/javascripts/examples/dashboard.js"></script>
@endsection