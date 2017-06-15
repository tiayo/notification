@extends('layouts.app')

@section('title', '收银台-退款批复')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
@endsection

@section('breadcrumbs')
    <li navValue="nav_3"><i class="fa fa-home" aria-hidden="true"></i><a href="">管理操作</a></li>
    <li navValue="nav_3_2"><a href="">管理退款</a></li>
    <li><a href="">退款批复</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInRight">
        <div class="col-md-12">
            <h4 class="section-subtitle"><b>{{config('site.title')}}收银台</b></h4>
            <div class="panel">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form class="form-horizontal form-stripe" id='refund_form' method='post'>
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
                                <h6 class="mb-xlg text-center"><b>退款批复-(您正在<i class="color-danger"> "{{$action_value}}" </i>退款)</b></h6>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="refund_id" value="{{$refund_id}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">退款编号</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$refund_number}}" readonly/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">回复</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name='reply'></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-primary btn-block" id="submit_form" type="button">提交 退款 申请</button>
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
    <script>
        $(document).ready(function () {
            $('#submit_form').click(function () {
                if ('{{$action}}' == 'agree') {
                    $('#refund_form').attr('action', '/admin/refund/action/agree');
                    $('#refund_form').submit();
                } else if ('{{$action}}' == 'refuse') {
                    $('#refund_form').attr('action', '/admin/refund/action/refuse');
                    $('#refund_form').submit();
                }
            })
        })
    </script>
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
@endsection