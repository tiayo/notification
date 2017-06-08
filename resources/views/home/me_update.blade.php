@extends('layouts.app')

@section('title', '更新资料')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
    <link rel="stylesheet" href="/stylesheets/css/address.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_5"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的任务</a></li>
    <li navValue="nav_5_1"><a href="#">更新资料</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>更新资料</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="{{route('me_update')}}" method="post" enctype="multipart/form-data">
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
                                    <label for="start_time" class="control-label">头像<span class="required">*</span></label>
                                    <input type="text" id="article_picture_input" class="form-control"  value="{{$profile['avatar']}}" placeholder="上传封面图片...">
                                    <input type="file" id="article_picture_file" style="margin-top: 1em;">
                                </div>
                                <div class="form-group">
                                    <label for="real_name" class=" control-label">姓名<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="real_name" value="{{$profile['real_name']}}">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class=" control-label">手机号码<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{$profile['phone']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="age" class=" control-label">年龄<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="age" value="{{$profile['age']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="address" class=" control-label">地址<span class="required">*</span></label>
                                    <div id="sjld" class="address">
                                        <div class="m_zlxg" id="shenfen">
                                            <p title="">{{$address[2] or '选择省份'}}</p>
                                            <div class="m_zlxg2">
                                                <ul></ul>
                                            </div>
                                        </div>

                                        <div class="m_zlxg" id="chengshi">
                                            <p title="">{{$address[3] or '选择城市'}}</p>
                                            <div class="m_zlxg2">
                                                <ul></ul>
                                            </div>
                                        </div>

                                        <div class="m_zlxg" id="quyu">
                                            <p title="">{{$address[4] or '选择区域'}}</p>
                                            <div class="m_zlxg2">
                                                <ul></ul>
                                            </div>

                                        </div>
                                        <input id="sfdq_num" name="address1[]" type="hidden" value="{{$address[0] or ''}}" />
                                        <input id="csdq_num" name="address1[]" type="hidden" value="{{$address[1] or ''}}" />
                                        <input id="sfdq_tj" name="address1[]" type="hidden" value="" />
                                        <input id="csdq_tj" name="address1[]" type="hidden" value="" />
                                        <input id="qydq_tj" name="address1[]" type="hidden" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address2" class=" control-label">详细地址<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="address2" value="{{$profile['address2']}}" required>
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
    <script>
        $(document).ready(function () {
            //input框change事件
            $('#article_picture_input').on('change', function () {
                $('#article_picture_input').attr('name', 'avatar');
                $('#article_picture_file').attr('name', '');
            });

            //file框change时间
            $('#article_picture_file').on('change', function () {
                $('#article_picture_input').val($(this).val()).attr('name', '');
                $(this).attr('name', 'avatar');
            })
        });
    </script>
    {{--三级联动--}}
    <script type="text/javascript" src="/javascripts/address.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#sjld").sjld("#shenfen","#chengshi","#quyu");
        });
    </script>

@endsection