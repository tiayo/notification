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
    <li navValue="nav_4"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的文章</a></li>
    <li navValue="nav_4_3"><a href="#">生成文章</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>生成文章</b></h4>

                    <div class="row hidden" id="result_alert">
                        <div class="col-md-12" id="result_alert_div"></div>
                    </div>

            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="form-signin-heading">生成首页</h4>
                                <hr>
                                <button id="generate_button" type="index" class="btn btn-darker-1 btn-block">点击开始</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="form-signin-heading">生成栏目</h4>
                                <hr>
                                <button id="generate_button" type="category" class="btn btn-darker-1 btn-block">点击开始</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="form-signin-heading">生成文章</h4>
                                <hr>
                                    <select name="category" class="form-control select2-hidden-accessible" required>
                                        <option value="0">全部</option>
                                        {!! app('\App\Service\CategoryService')->categoryHtml('<option value="<<category_id>>"><<title>></option>"><<title>></a></li>', 'article') !!}
                                    </select><br>
                                    <button id="generate_button" type="article" class="btn btn-darker-1 btn-block">点击开始</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="form-signin-heading">生成目录</h4>
                                <hr>
                                <button id="generate_button" type="retrieval" class="btn btn-darker-1 btn-block">点击开始</button>
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
    <script>
        $(document).ready(function () {
            $('#generate_button').click(function () {
                option_type = $('#generate_button').attr('type');
                axios.post('/admin/generate/'+option_type, {
                    _token: '{{csrf_token()}}'
                })
                    .then(function (response) {
                        $('#result_alert').removeClass('hidden');
                        $('#result_alert_div').html('<div class="alert alert-success fade in"> <a href="#" class="close" data-dismiss="alert">×</a> <p>生成完毕！</p> </div>');
                    })
                    .catch(function (error) {
                        $('#result_alert').removeClass('hidden');
                        $('#result_alert_div').html('<div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert">×</a> <p>生成失败！</p> </div>');
                    });
            });
        })
    </script>
@endsection