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
    <li navValue="nav_6_2"><a href="#">{{$type}}</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>{{ $type }}</b></h4>
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
                                    <label for="title" class=" control-label">消费内容<span class="required">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$old_input['title']}}" required>
                                </div>
                                <div class="form-group">
                                        <label for="type" class="control-label">分类<span class="required">*</span></label>
                                        <select name="type" id="type" class="form-control select2-hidden-accessible" required>
                                            @if (!empty($old_input['type']))
                                                <option value="{{$old_input['type']}}">{{$controller::accountingType($old_input['type'])}}</option>
                                            @endif
                                                <option value="1">饮食</option>
                                                <option value="2">购物</option>
                                                <option value="3">出行</option>
                                                <option value="4">住宿</option>
                                                <option value="5">娱乐</option>
                                                <option value="6">医疗</option>
                                                <option value="7">手机、宽带</option>
                                                <option value="0">其他</option>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="money" class=" control-label">消费金额<span class="required">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="money" name="money" value="{{$old_input['money']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="start_time" class=" control-label">消费时间<span class="required">*</span></label>
                                    <input type="hidden" name="time" value="date">
                                    <input type="text" class="form-control" id="time" name="time"  value="{{$old_input['time']}}" placeholder="Select Time.." required>
                                </div>
                                <div class="form-group">
                                    <label for="location" class=" control-label">消费地点</label>
                                    <input type="text" class="form-control" id="location" name="location" value="{{$old_input['location']}}">
                                    <p>（如果放空，系统将会自动获取你当前所在位置(市县级)作为消费地址。）</p>
                                </div>
                                <div class="form-group">
                                    <label for="remark" class=" control-label">备注</label>
                                    <textarea class="form-control" id="remark" name="remark">{{$old_input['remark']}}</textarea>
                                </div>
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
    <script>
        window.onload = function () {
            flatpickr("#time", {
                enableTime: true,
                altInput: true,
                altFormat: "Y-m-d H:i:S"
            });
        }
    </script>
@endsection