<script>
    $(document).ready(function () {

        //消息框显示
        $('tbody tr').click(function () {
            message_id_parent = $(this).attr('id');
            var message_id_num = $(this).attr('num');
            $('.message-bgc').removeClass('hidden');
            $('.message-float').removeClass('hidden');
            $('#message-float-content').html($('#message-id-content'+message_id_num).html());
            $('#message-float-send-user').html('来自:'+$('#message-id-send-user').html());

            //设置文章为已读
            already_read();
        });

        //回复按钮
        $('#message-float-reply').click(function () {
            window.location.href = $('#message-id-reply').attr('href');
        });

        //设置文章未读
        $('#message-float-no').click(function () {
            $('.message-bgc').addClass('hidden');
            $('.message-float').addClass('hidden');
            no_read();
        });

        //消息框关闭1
        $('.message-bgc').click(function () {
            $('.message-bgc').addClass('hidden');
            $('.message-float').addClass('hidden');
            @if ($type == '收到的消息')
            $('#'+message_id_parent).removeClass('color-danger');
            $('#message-id-status').html('已读');
            @endif
        });
        //消息框关闭2
        $('#message-float-close').click(function () {
            $('.message-bgc').addClass('hidden');
            $('.message-float').addClass('hidden');
            @if ($type == '收到的消息')
            $('#'+message_id_parent).removeClass('color-danger');
            $('#message-id-status').html('已读');
            @endif
        });

        //设置文章为已读
        function already_read() {
            axios.get($('#message-id-statusurl').attr('url')+'2');
        }

        //设置文章为未读
        function no_read() {
            $('#'+message_id_parent).addClass('color-danger');
            $('#message-id-status').html('未读');

            axios.get($('#message-id-statusurl').attr('url')+'1')
        }
    })
</script>