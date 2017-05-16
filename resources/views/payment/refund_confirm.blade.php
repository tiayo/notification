<!DOCTYPE html>
<html>
<head>
    <title>{{config('site.title')}}收银台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/pay_confirm.css">
    <script type="text/javascript" src="/jquery.js"></script>
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
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<header class="am-header">
    <h1>{{config('site.title')}}-{{$action_value}}退款</h1>
</header>
<div id="main">
    <form id='refund_form' method='post'>
        {{ csrf_field() }}
        <input type="hidden" name="confirm_type" value="{{$action}}">
        <div id="body" style="clear:left">
            <dl class="content">
                <dt></dt>
                <dd>
                    {{--输出错误信息--}}
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <span style="line-height: 28px; color:red;">注意：{{ $error }}</span>
                        @endforeach
                    @endif
                </dd>

                <hr class="one_line">
                <dt>退款ID：</dt>
                <dd>
                    <input name="refund_id" value="{{$refund_id}}" readonly/>
                </dd>
                <hr class="one_line">
                <dt>回复：</dt>
                <textarea name='reply' rows="3" style="width:60%; border: none;"></textarea>
                </dd>
                <hr class="one_line">
                <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" id="submit_form" type="button" style="text-align:center;">{{$action_value}}退款 提交</button>
                        </span>
                    <span class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。</span>
                </dd>
            </dl>
        </div>
    </form>
    <div id="foot">
        <ul class="foot-ul">
            <li>
                {{config('site.title')}}版权所有 2011-{{date("Y")}} TIAYO.COM
            </li>
        </ul>
    </div>
</div>
</body>
</html>