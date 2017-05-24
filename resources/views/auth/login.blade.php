<!doctype html>
<html lang="en" class="fixed accounts sign-in">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{config('site.title')}}</title>
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
</head>

<body>



<div class="wrap">
    <div class="page-body animated slideInDown">
        <div class="logo">
            <h3 align="center">{{config('site.title')}}</h3>
        </div>
        <div class="box">
            <div class="panel mb-none">
                <div class="panel-content bg-scale-0">
                    <form method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group mt-md">
                            <span class="input-with-icon">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        <div class="form-group">
                                <span class="input-with-icon">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        <i class="fa fa-key"></i>
                                    </span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox" id="remember-me" value="option1" checked>
                                @if ($errors->has('email'))
                                    <label for="remember-me">{{ $errors->first('email') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block">
                        </div>
                        <div class="form-group text-center">
                            <a href="/pages_forgot-password.html">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
<script src="/vendor/nano-scroller/nano-scroller.js"></script>
<script src="/javascripts/template-script.min.js"></script>
<script src="/javascripts/template-init.min.js"></script>
</body>

</html>