@extends('layouts.article')
@section('title', '版本更新日志')
@section('description', '随享校园社区是基于祥景CMS架构的一套分享php学习之路的网站,大量常用的代码和常遇到的问题不断更新中.')

@section('link')
    <link href="/index.css" rel="stylesheet" />
    <link href="/article.css" rel="stylesheet"/>
    <style type="text/css">
        .newsl{
            width: 100%;
            border-right:none;
        }
        .section{
            width: 90%;
            float: left;
            margin-bottom: 1em;
        }
        .section p{
            margin-top: 0.5em;
            line-height: 25px;
            text-indent: 2em;
        }
        .section h2{
            font-size: 18px;
        }
        .section span{
            width: 100%;
            float: left;
            font-weight: 800;
        }
    </style>
@endsection

@section('header')
    @parent
@endsection

@section('content_body')
<div class="newshead " style="background-color:; background-image:url();">

    <div class="newsheader ">

        <div class="" id="M14_B_CMSNews_Common_HeadTG"></div>

        <div class="newsheadtit">

            <h2>更新日志</h2>

        </div>

        <p class="mt15 ml25 newstime ">更新时间：2017-06-13

        </p>

    </div>

</div>

<div class="newsinnerhrtit" id="newsPageTitle" style="display:none;"></div>

<div class="newscont clearfix"><div class="clearfix newsconter2">

        <div class="newsl">

            <div class="neirongkaishi" id="neirongkaishi">
                <div class="section">
                    <h2>V5.1版本</h2>
                    <h4>时间：2017.07.13</h4>
                    <p>
                        <span>修改一些逻辑及新增功能模块</span>
                        <span>1、新增我的账本功能</span>
                        <span>2、修改权限验证逻辑，权限验证更简洁</span>
                        <span>3、修复其他一些已知问题</span>
                    </p>
                </div>
            </div>

            <div class="neirongkaishi" id="neirongkaishi">
                <div class="section">
                    <h2>V5.0版本</h2>
                    <h4>时间：2017.06.13</h4>
                    <p>
                        <p>使用Laravel框架重新开发，将进行长期维护更新。5.0版本有功能：</p>
                        <p>1、文章内容管理模块</p>
                        <p>2、定时任务管理模块</p>
                        <p>3、支付模块</p>
                        <p>4、评论模块</p>
                        <p>5、消息模块</p>
                        <p>V5.0版本力求代码优雅、简洁、高效;前台页面支持全静态化，利于搜索引擎抓取;全站均采用响应式布局，手机、PC一个页面全搞定。</p>
                        <p>使用当前最流行的框架之一，拥有丰富的扩展性，您可以在V5.0的基础上继续开发，已达到您的最终需求。</p>
                    </p>
                </div>

                <div class="section">
                    <h2>V3.0版本</h2>
                    <h4>时间：2017.01.05</h4>
                    <p>1、新增生成静态页面模块</p>
                    <p>2、优化代码，重构部分代码。</p>
                </div>

                <div class="section">
                    <h2>V2.0版本</h2>
                    <h4>时间：2016-11-20</h4>
                    <p>使用Think-PHP框架对代码进行重构，安全性及可维护性显著提升。</p>
                </div>

                <div class="section">
                    <h2>V1.0版本</h2>
                    <h4>时间：2016-09-10</h4>
                    <p>实现CMS基本功能模块。</p>
                </div>

                <!-- content -->

            </div>
            　　
        </div>

    </div>

</div>

<div id="shuchu"></div>

<div class="fanhui_index">

    <p><a href="/">返回首页</a></p>

</div>
@endsection

@section('footer')
    @parent
@endsection

@section('script')
    @parent
@endsection