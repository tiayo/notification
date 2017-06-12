@extends('layouts.app')

@section('title', '我的资料')

@section('link')
    @parent
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_5"><i class="fa fa-home" aria-hidden="true"></i><a href="/">会员中心</a></li>
    <li navValue="nav_5_1"><a href="/admin/task/page/">我的资料</a></li>
@endsection

@section('content_body')
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div>
                        <div class="profile-photo">
                            <img alt="Jane Doe" src="{{$profile['avatar'] or '/images/user.jpg'}}" />
                        </div>
                        <div class="user-header-info">
                            <h2 class="user-name">{{$profile['real_name']}}</h2>
                            <h5 class="user-position">{{$user['name']}}</h5>
                            <div class="user-social-media">
                                <h6>（{{$status::userCertified($profile['certified'])}}）</h6>
                            </div>
                        </div>
                    </div>
                    <div class="panel bg-scale-0 b-primary bt-sm mt-xl">
                        <div class="panel-content">
                            <div style="width: 100%; float:left;">
                                <h4 style="float: left"><b>我的资料</b></h4>
                                <h6 style="float: right"><a href="/admin/member/me/update">修改</a></h6>
                            </div>
                            <ul class="user-contact-info ph-sm">
                                <li><b><i class="color-primary mr-sm fa fa-envelope"></i></b>{{$user['email']}}</li>
                                <li><b><i class="color-primary mr-sm fa fa-phone"></i></b> {{$profile['phone']}}</li>
                                <li><b><i class="color-primary mr-sm fa fa-globe"></i></b> {{$profile['address1']}}</li>
                                <li><b><i class="color-primary mr-sm fa fa-home"></i></b> {{$profile['address2']}}</li>
                                <li><b><i class="color-primary mr-sm fa fa-info-circle"></i></b> {{$profile['age']}}岁</li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel  b-primary bt-sm ">
                        <div class="panel-content">
                            <div class="widget-list list-sm list-left-element ">
                                <ul>
                                    <li>
                                        <a href="{{route('task_page', ['page' => 1])}}">
                                            <div class="left-element"><i class="fa fa-check color-success"></i></div>
                                            <div class="text">
                                                <span class="title">{{$task_count}} 条任务</span>
                                                <span class="subtitle">正在执行</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('article_page', ['page' => 1])}}">
                                            <div class="left-element"><i class="fa fa-clock-o color-warning"></i></div>
                                            <div class="text">
                                                <span class="title">{{$article_count}} 篇文章</span>
                                                <span class="subtitle">正在展现</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('message_received_page_simple') }}">
                                            <div class="left-element"><i class="fa fa-envelope color-primary"></i></div>
                                            <div class="text">
                                                <span class="title">Leave a Menssage</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-8">
                    <div class="timeline animated fadeInUp">
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
                        @foreach ($tasks as $task)
                            <div class="timeline-box">
                                <div class="timeline-icon bg-primary">
                                    <i class="fa fa-cubes"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="tl-title">{{$task['title']}}</h4>
                                    <p style="line-height: 2rem; margin: 0;">
                                        {{$task['name']}}<br>
                                        下次提醒时间:{{$task['start_time']}} {{$task['end_time'] or ''}}<br>
                                        <a href="/admin/task/update/{{$task['task_id']}}">
                                            <button type="button" class="btn btn-success">
                                                计划：{{$status::plan($task['plan'])}}
                                            </button>
                                        </a>
                                    </p>
                                </div>
                                <div class="timeline-footer">
                                    <span>{{$order['updated_at']}}</span>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($articles as $article)
                            <div class="timeline-box">
                                <div class="timeline-icon bg-primary">
                                    <i class="fa fa-files-o"></i>
                                </div>
                                <div class="timeline-content">
                                    <h4 class="tl-title">{{$article['title']}}</h4>
                                    <p style="line-height: 2rem; margin: 0;">
                                        {{$article['name']}}<br>
                                        {{$article['abstract']}}<br>
                                        <a href="/admin/task/update/{{$task['task_id']}}">
                                            <button type="button" class="btn btn-success">
                                                类型：{{$status::articleStatus($article['attribute'])}}
                                            </button>
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
@endsection