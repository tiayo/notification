@extends('layouts.app')

@section('title', '添加消费记录')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
    <link href="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.css" rel="stylesheet">
    {{--编辑器--}}
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
@endsection

@section('breadcrumbs')
    <li navValue="nav_6"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的记帐本</a></li>
    <li navValue="nav_6_4"><a href="#">账单</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>账单</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="message-container alert alert-danger @if(count($errors) > 0) show @endif">
                                <ul>
                                    {{--输出错误信息--}}
                                    @if (count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <li>
                                                <label class="error">{{ $error }}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="title" class=" control-label">周期剩余金额</label>
                                <input class="form-control" value="{{ $remaining_budget }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="type" class="control-label">周期剩余天数</label>
                                <input class="form-control" value="{{ $remaining_day }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="money" class=" control-label">周期剩余天数每日配额<span class="required">*</span></label>
                                <input class="form-control" value="{{ $average_money }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="start_time" class=" control-label">平均消费金额<span class="required">*</span></label>
                                <input class="form-control" value="{{ $consumption_average_money }}" readonly>
                            </div>
                            <div class="form-group">

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
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
@endsection