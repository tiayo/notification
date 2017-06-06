<script>
    //文章点击数
    $(document).ready(function () {
        axios.get('/ajax/get_click/{{$article['article_id']}}')
            .then(function (response) {
                $('#click').html(response.data);
            })
            .catch(function (response) {
                $('#click').html(0);
            });
    });

    //搜索
    $(document).ready(function () {
        $('#search_form').submit(function () {
            var driver = 'zh';
            var key = $('#search_form_key').val();
            var page = 1;
            window.location.href = '/search/article/' + driver + '/' + key + '/' + page;
            return false;
        })
    });

    //插入评论
    $(document).ready(function () {
        comment_axios();
    });

    //插入评论业务代码
    function comment_axios() {
        axios.get('/comment/view/{{$article['article_id']}}')
            .then(function (response) {
                $('#comment_block').html(response.data);
            })
            .catch(function (response) {
                $('#comment_block').html('');
            });
    }
</script>
