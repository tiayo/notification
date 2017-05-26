
<!doctype html>
<html lang="en" class="fixed accounts lock-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{config('site.title')}}-离开模式</title>
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="stylesheet" type="text/css" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.bootcss.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
</head>

<body>


<div class="wrap">
    <div class="page-body">
        <div class="logo">
            <div class="avatar">
                <img alt="Jane Doe" src="/images/user-avatar.jpg" />
            </div>
        </div>
        <div class="box animated fadeInUp">
            <div class="panel">
                <div class="panel-content bg-scale-0">
                    <form method="post" action="/login" id="lock_unlock_form">
                        {{ csrf_field() }}
                        <h3 class="text-center mb-md">{{$username}}</h3>
                        <input type="hidden" name="email" value="{{$email}}">
                        <div class="form-group">
                                <span class="input-with-icon">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                        <i class="fa fa-key"></i>
                                    </span>
                        </div>
                        <div class="form-group">
                            <a id="lock_unlock" class="btn btn-primary btn-block ">Unlock</a>
                        </div>
                        <div class="form-group text-center">
                            <a href="/login">我不是{{$username}}?</a>
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
<script>
    $(document).ready(function () {
        $('#lock_unlock').click(function () {
            $('#lock_unlock_form').submit();
        })
    })
</script>
</body>
</html>
