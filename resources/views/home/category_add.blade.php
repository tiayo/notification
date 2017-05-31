@extends('layouts.app')

@section('title', '我的任务')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_1"><i class="fa fa-home" aria-hidden="true"></i><a href="/">控制台</a></li>
    <li navValue="nav_1_2"><a href="/admin/task/page/">添加任务</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>添加任务</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="{{$uri}}" method="post">
                                {{ csrf_field() }}
                                <div class="message-container alert alert-danger">
                                    <ul>
                                        {{--输出错误信息--}}
                                        @if (count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <label class="error">{{ $error }}</label>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="control-label">名称<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{$old_input['title']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="plan" class="control-label">类型<span class="required">*</span></label>
                                    <select name="parent_id" class="form-control select2-hidden-accessible" required>
                                        @if (!empty($parent_name['category_id']))
                                            <option value="{{$parent_name['category_id']}}">{{$parent_name['name']}}</option>
                                        @endif
                                        @foreach ($all_category as $value)
                                                @if ($value['parent_id'] == 0)
                                                    <option value="{{$value['category_id']}}">{{$value['name']}}</option>
                                                @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class=" control-label">别名<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="alias" value="{{$old_input['phone']}}" required>
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
@endsection