@extends('layouts.single')

@section('page_type', 'fixed accounts sign-in')

@section('title', '登录')

@section('link')
    @parent
@endsection

@section('content_body')
    <div class="page-body animated slideInDown">
        <div class="logo">
            <h3 align="center">{{config('site.title')}}</h3>
        </div>
        <div class="box">
            <div class="panel mb-none">
                <div class="panel-content bg-scale-0">
                    <form method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-with-icon" id="login_type_block">
                                {{--邮箱登录--}}
                                <input type="email" class="form-control show" id="email" name="email" placeholder="Email" required autofocus>
                                {{--用户名登录--}}
                                <input type="text" class="form-control hidden" id="name" name="name" placeholder="User Name" autofocus>
                                <i class="fa fa-envelope"></i>
                            </span>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <span class="input-with-icon">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <i class="fa fa-key"></i>
                                    </span>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom checkbox-primary">
                                @if ($errors->has('email'))
                                    <label for="remember-me">{{ $errors->first('email') }}</label>
                                    @elseif ($errors->has('password'))
                                    <label for="remember-me">{{ $errors->first('password') }}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block">
                        </div>
                        <div class="form-group text-center">
                            <a id="login_type" style="cursor: pointer">使用用户名登录</a>
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
            $('#login_type').click(function () {
                var show_id = $("#login_type_block [class='form-control show']").attr('id');
                var hidden_id = $("#login_type_block [class='form-control hidden']").attr('id');

                if ($('#login_type_block i').prop('class') === 'fa fa-envelope') {
                    $('#login_type_block i').prop('class', 'fa fa-user')
                } else {
                    $('#login_type_block i').prop('class', 'fa fa-envelope')
                }

                $('#'+show_id).prop('required', false);
                $('#'+show_id).removeClass('show');
                $('#'+show_id).addClass('hidden');

                $('#'+hidden_id).prop('required', true);
                $('#'+hidden_id).removeClass('hidden');
                $('#'+hidden_id).addClass('show');
            })
        })
    </script>
@endsection