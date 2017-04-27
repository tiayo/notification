<form method="post" action="test">
<input type="text" name="captcha" class="form-control" style="width: 300px;">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<a onclick="javascript:re_captcha();" ><img src="{{ URL('yanzheng/1') }}"  alt="验证码" title="刷新图片" id="c2c98f0de5a04167a9e427d883690ff6" border="0"></a>
<input type="submit" />
</form>
<script>  
  function re_captcha() {
    $url = "{{ URL('code') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src=$url;
  }
</script>