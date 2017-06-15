@extends('layouts.single')

@section('page_type', 'fixed accounts forgot-password')

@section('title', '重置密码')

@section('link')
    @parent
@endsection

@section('content_body')
    <div class="wrap">
        <div class="page-body  animated slideInDown">
            <div class="logo">
                <h3 class="color-light text-center">{{config('site.title')}}-重置密码</h3>
            </div>
            <div class="box">
                <div class="panel mb-none">
                    <div class="panel-content bg-scale-0">
                        <form method="POST" action="{{ route('password.email')}}">
                            {{ csrf_field() }}
                            <h3>忘记了您的密码?</h3> 输入您的邮箱，我们将发送一份邮件给您，您根据邮件操作即可重制密码！
                            <div class="form-group mt-md{{ $errors->has('email') ? ' has-error' : '' }}">
                                <span class="input-with-icon">
                                    {{--成功提醒--}}
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email" placeholder="Email">
                                     <i class="fa fa-envelope"></i>
                                </span>
                                {{--失败提醒--}}
                                @if ($errors->has('email'))
                                    <span class="help-block color-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block ">发送</button>
                            </div>
                            <div class="form-group text-center">
                                您记得密码?, <a href="/login">登录!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
