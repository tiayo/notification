<div class="pinglun" id="pinglun">
    <form action="/comment/add/{{$article_id}}" id="pinglunform1"  method="post" style="display:block;">
        {{ csrf_field() }}
        <div class="pingluntext"><textarea id="textarea" type="text" name="content"></textarea></div>
        <div class="pingluninput"><input type="text" name="captcha" placeholder="请输入验证码"><img src="<?php echo $builder->inline(); ?>" /> </div>
        <div class="pinglunsubmit"><input type="submit"></div>
    </form>
    <p style="width: 100%;float: left;font-size: 15px;color: red;margin: 1em 0;">
        @if ($errors->has(0))
            <span>
                <strong>请输入合法的内容和验证码！</strong>
            </span>
        @endif
        <span>
            <strong>{{$request->session()->pull('other_error')}}</strong>
        </span>
    </p>
</div>
<div id="shuchu">
    @foreach ($all_comment as $comment)
        <li><p>{!! $comment['content'] !!}</p><strong>评论时间：{{$comment['updated_at']}}</strong><span>{{$comment['real_name']}}</span></li>
    @endforeach
</div>