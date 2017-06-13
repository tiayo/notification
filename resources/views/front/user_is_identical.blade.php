<script>
    $(document).ready(function () {
        axios.get('/ajax/user_is_identical/{{$article['user_id']}}')
            .then(function (response) {
                console.log(response);
                if (response.data != '') {
                    user_is_identical(response.data);
                }
            })
            .catch(function (error) {
                if (response.data != '') {
                    user_is_identical(response.data);
                }
            });
    });

    function user_is_identical(message_url) {
        $('#relatedInfos-writer dd').append('<p>发消息：<a href="'+message_url+'" target="_blank">给他留言</a></p>');
    }
</script>