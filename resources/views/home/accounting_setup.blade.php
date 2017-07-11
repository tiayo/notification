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
    <li navValue="nav_6_1"><a href="#">设置记帐本</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>设置记帐本</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="{{ $uri }}" method="post">
                                {{ csrf_field() }}
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
                                    <label for="budget" class=" control-label">周期预算<span class="required">*</span></label>
                                    <input type="number" class="form-control" id="budget" name="budget" value="{{$old_input['budget']}}" required>
                                </div>
                                <div class="form-group">
                                        <label for="type" class="control-label">类型<span class="required">*</span></label>
                                        <select name="type" id="type" class="form-control select2-hidden-accessible" required>
                                            @if (isset($old_input['type']))
                                                <option value="{{$old_input['type']}}">{{$controller::accountingSetupType($old_input['type'])}}</option>
                                            @endif
                                                <option value="1">月度</option>
                                                <option value="2">年度</option>
                                                <option value="3">单天</option>
                                                <option value="0">自定义</option>
                                        </select>
                                </div>
                                <div class="form-group @if($old_input['type'] == 0) show @else hidden @endif" id="cycle_div">
                                    <label for="cycle" class=" control-label">周期<span class="required">*</span></label>
                                    <input type="number" class="form-control" id="cycle" name="" value="{{$old_input['cycle'] or ''}}" required>
                                    <p>(当类型设置为自定义时有效,从保存时间开始计算)</p>
                                </div>
                                <input type="hidden" name="status" value="{{ $status }}">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            flatpickr("#time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        };

        $(document).ready(function () {
            $('#type').change(function () {
                if ($(this).val() == 0) {
                    $('#cycle_div').removeClass('hidden');
                    $('#cycle').attr('name', 'cycle');
                } else {
                    $('#cycle_div').addClass('hidden');
                    $('#cycle').attr('name', '');
                }
            })
        })
    </script>
@endsection