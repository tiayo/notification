@extends('layouts.app')

@section('title', '发送留言')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_5"><i class="fa fa-home" aria-hidden="true"></i><a href="/">会员中心</a></li>
    <li navValue="nav_5_3"><a href="#">发送留言</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>发送留言</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="{{route('message_send', ['target_id' => $target['user_id']])}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{--输出错误信息--}}
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <label class="error" style="color: #fff">{{ $error }}</label>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="title" class=" control-label">发送给<span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{$target['real_name']}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="content" class=" control-label">消息内容<span class="required">*</span></label>
                                    <textarea class="form-control" name="content" placeholder="输入消息内容..." required></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">发送</button>
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
        $(document).ready(function () {
            //input框change事件
            $('#article_picture_input').on('change', function () {
                $('#article_picture_input').attr('name', 'picture');
                $('#article_picture_file').attr('name', '');
            });

            //file框change时间
            $('#article_picture_file').on('change', function () {
                $('#article_picture_input').val($(this).val()).attr('name', '');
                $(this).attr('name', 'picture');
            })
        });
    </script>
@endsection