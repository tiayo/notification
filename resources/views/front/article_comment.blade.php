<div class="pinglun" id="pinglun">
    <form action="/comment/add/{{$article_id}}" id="comment_form"  method="post" style="display:block;">
        {{ csrf_field() }}
        <div class="pingluntext"><textarea id="comment_textarea" type="text" name="content" required></textarea></div>
        <div class="pingluninput">
            <input type="text" id="comment_captcha" name="captcha" placeholder="请输入验证码" required>
            <img id="comment_captcha_image" src="{{$builder->inline()}}" />
        </div>
        <div class="pinglunsubmit">
            @if (Auth::check())
                <input type="submit">
                @else
                <p style="float: right"><a href="/login">登录</a>后才可以评论！</p>
            @endif
        </div>
    </form>
    <p style="width: 100%;float: left;font-size: 15px">
        <span id="comment_info">

        </span>
    </p>
</div>
<div id="shuchu">
    @foreach ($all_comment as $comment)
        <li><p>{!! $comment['content'] !!}</p><strong>评论时间：{{$comment['updated_at']}}</strong><span>{{$comment['real_name']}}</span></li>
    @endforeach
</div>

<script>
    $(document).ready(function () {
        //提交评论
        $('#comment_form').submit(function () {
            axios.post('/comment/add/{{$article_id}}', {
                _token: '{{Csrf_token()}}',
                content: $('#comment_textarea').val(),
                captcha: $('#comment_captcha').val()
            })
                .then(function (response) {
                    console.log(response);
                    comment_axios();
                })
                .catch(function (error) {
                    console.log(error.response);
                    $('#comment_info').html('<strong style="color: red; float: left;margin: 1em 0;">'+error.response.data+'</strong>');
                });
            return false;
        });

        //刷新验证码
        $('#comment_captcha_image').click(function () {
            axios.get('/captcha/view')
                .then(function (response) {
                    $('#comment_captcha_image').attr('src', ''+response.data+'');
                })
                .catch(function (error) {
                    console.log('验证码获取失败！');
                })
        })
    });
</script>