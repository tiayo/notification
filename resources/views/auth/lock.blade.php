@extends('layouts.single')

@section('title', '登录')

@section('link')
    @parent
@endsection

@section('content_body')
    <div class="page-body">
        <div class="logo">
            <div class="avatar">
                <img alt="Jane Doe" src="{{ $avatar }}" />
            </div>
        </div>
        <div class="box animated fadeInUp">
            <div class="panel">
                <div class="panel-content bg-scale-0">
                    <form method="post" action="/login" id="lock_unlock_form">
                        {{ csrf_field() }}
                        <h3 class="text-center mb-md">{{ $username }}</h3>
                        <input type="hidden" name="email" value="{{ $email }}">
                        <div class="form-group">
                            <span class="input-with-icon">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" title="{{config('site.title')}}-离开模式" data-container="body" data-toggle="popover" data-placement="right" data-content="请输入密码！">
                                    <i class="fa fa-key"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom checkbox-primary">
                                @if (!empty( $errors ))
                                    <label for="remember-me" class="color-danger">{{ $errors }}</label>
                                @endif
                            </div>
                            <a id="lock_unlock" class="btn btn-primary btn-block ">Unlock</a>
                        </div>
                        <div class="form-group text-center">
                            <a href="/login">我不是{{ $username }}?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            //定义常量
            dom = $('#password');

            //点击网页任何地方隐藏提示
            $('html').click(function () {
                $("[data-toggle='popover']").popover('hide');
            });

            //点击提交事件
            $('#lock_unlock').click(function () {
                if (!password_val()) {
                    return false;
                }
                $('#lock_unlock_form').submit();
            });
        });

        //判断password为空事件
        function password_val() {
            if (dom.val() === '') {
                $("[data-toggle='popover']").popover('show');
                return false;
            } else {
                $("[data-toggle='popover']").popover('hide');
                return true;
            }
        }
    </script>
@endsection

