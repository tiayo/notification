@extends('layouts.app')

@section('title', '赞助我们')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
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
    <li navValue="nav_2"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的订单</a></li>
    <li navValue="nav_2_1"><a href="/admin/task/page/">赞助我们</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>赞助我们</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="/admin/sponsor" method="post">
                                {{ csrf_field() }}
                                <div class="message-container alert alert-danger">
                                    <ul>
                                        {{--输出错误信息--}}
                                        @if (count($errors) > 0)
                                            @if (is_array($errors))
                                                @foreach ($errors->all() as $error)
                                                    <label class="error">{{ $error }}</label>
                                                @endforeach
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="money" class="control-label">金额<span class="required">*</span></label>
                                    <select name="money" id="money" class="form-control select2-hidden-accessible" required>
                                        @if (!empty($old_input['plan']))
                                            <option value="{{$old_input['plan']}}">{{$plan::plan($old_input['plan'])}}</option>
                                        @endif
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                        <option value="100">100）</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">提交</button>
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
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/javascripts/examples/forms/validation.js"></script>
    <script>
        window.onload = function () {
            flatpickr("#start_time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        }
    </script>
@endsection