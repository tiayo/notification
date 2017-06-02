@extends('layouts.app')

@section('title', '我的任务')

@section('link')
    @parent
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
    <style>
        .bgc{
            width: 100%;
            height: 100%;
            float: left;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1;
        }
        .float{
            min-width: 35%;
            float: left;
            background:#fff;
            position: fixed;
            padding: 1em;
            top:0;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin:15% 0 0 25%;
            z-index: 2;
        }
        @media screen and (max-width: 800px) {
            .float{
                min-width: 35%;
                float: left;
                background:#fff;
                position: fixed;
                padding: 1em;
                top:0;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin:15% 0 0 5%;
                z-index: 2;
            }
        }
        .style-content {
            text-align: center;
            height: 100%;
        }
        .float p span{
            width: 96%;
            margin: 0 2% 0 2%;
            float: left;
        }
    </style>
@endsection

@section('breadcrumbs')
    <li navValue="nav_3"><i class="fa fa-home" aria-hidden="true"></i><a href="/">管理操作</a></li>
    <li navValue="nav_3_3"><a href="#">生成页面</a></li>
@endsection

@section('content_body')
    <div class="bgc hidden"></div>
    <div class="float hidden">
        <h4 class="text-center">正在生成中</h4>
        <div class="bs-example m-callback">
            <div class="style-content">
                <img src="/images/timg.gif">
            </div>
            <p><span class="label label-warning" id="m-callback-update">您需要耐心等待一会,请不要刷新页面,否则生成进程会中断哦！</span></p>
        </div>
    </div>
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
                                    <select id="category_select" class="form-control select2-hidden-accessible" required>
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
            //按钮点击触发生成事件
            $('button').click(function () {
                //展示进度条
                $('.bgc').removeClass('hidden');
                $('.float').removeClass('hidden');

                //获取方法
                option_type = $(this).attr('type');

                //生成文章时带上category参数
                if (option_type === 'article') {
                    category_select = $('#category_select').val();
                } else {
                    category_select = null;
                }

                //发送请求
                axios.post('/admin/generate/'+option_type, {
                    _token: '{{csrf_token()}}',
                    category:category_select
                })
                    .then(function (response) {

                        $('#result_alert').removeClass('hidden');
                        $('#result_alert_div').html('<div class="alert alert-success fade in"> <a href="#" class="close" data-dismiss="alert">×</a> <p>生成完毕！</p> </div>');

                        //关闭进度条
                        $('.bgc').addClass('hidden');
                        $('.float').addClass('hidden');
                        $('body').animate({ scrollTop: 0 }, 500);
                    })

                    .catch(function (error) {
                        $('#result_alert').removeClass('hidden');
                        $('#result_alert_div').html('<div class="alert alert-danger fade in"> <a href="#" class="close" data-dismiss="alert">×</a> <p>生成失败！</p> </div>');

                        //关闭进度条
                        $('.bgc').addClass('hidden');
                        $('.float').addClass('hidden');
                        $('body').animate({ scrollTop: 0 }, 500);
                    });
            });
        });
    </script>
@endsection