<!DOCTYPE html  "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>随享任务系统</title>
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/jquery-1.11.3.min.js"></script>
    <script src="/cloud.js" type="text/javascript"></script>

    <script language="javascript">
        $(function(){
            $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            $(window).resize(function(){
                $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            })
        });
    </script>
</head>

<body style="background-color:#1c77ac; background-image:url(/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



<div id="mainBody">
    <div id="cloud1" class="cloud"></div>
    <div id="cloud2" class="cloud"></div>
</div>


<div class="logintop">
    <span>随享任务系统</span>
    <ul>
        <li><a href="/">回首页</a></li>
        <li><a href="#">帮助</a></li>
        <li><a href="#">关于</a></li>
    </ul>
</div>

<div class="loginbody">

    <span class="systemlogo"></span>

    <div class="loginbox">

        <ul>
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-6">

                        <li><input id="email" type="email" class="loginuser" name="email" value="{{ old('email') }}" placeholder="输入帐号" required autofocus></li>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col-md-6">

                        <li><input id="password" type="password" class="loginpwd" name="password" placeholder="输入密码" required></li>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <li><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</li>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <li>
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a class="btn-link" href="{{ route('password.request') }}">忘记密码</a>
                        </li>
                    </div>
                </div>
            </form>
        </ul>


    </div>

</div>



<div class="loginbm">版权所有：郑祥景</div>


</body>

</html>
