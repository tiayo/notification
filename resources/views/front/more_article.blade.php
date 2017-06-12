<script>
    $(document).ready(function(){
        $('#more_article').click(function(){
            var category = {{$category['category_id']}};
            var counter = document.getElementById('counter').innerHTML=parseInt(document.getElementById('counter').innerHTML)+1;
            $.ajax({
                type: "get",
                url: "/ajax/more_article/"+category+"/"+counter,
                dataType: "json",
                success: function (sqlJson) {
                    var html = '';
                    var path = '/{{config('site.article_path')}}';
                    for (i=0; i<2; i++) {
                        html = '';
                        html += "<li class=' __r_c_'><dl class='com_movies clearfix __r_c_'><dt><a href='"+path+sqlJson[i].links+"'  target='_blank'></a></dt><dd style=''><div class='com_ulr'><img width='64' height='64' class='img' src='"+sqlJson[i].avatar+"'><h3><a href='"+path+sqlJson[i].links+"' target='_blank'>"+sqlJson[i].title+"</a></h3><p class='mt12 px14'>作者："+sqlJson[i].real_name+"&emsp;"+sqlJson[i].created_at+"&emsp;阅读："+sqlJson[i].click+"</p><p class='pcont'><i></i>"+sqlJson[i].abstract+"<a href='"+path+sqlJson[i].links+"' target='_blank'>查看全文</a></p><div class='clearfix com_usercom'><div class='ele_replay'><a href='"+path+sqlJson[i].links+"#pinglun' target='_blank' ><div class='textarea'><textarea class='c_a5'>发表评论</textarea></div></div><i class='comnumi'></i></a></div></div></dd></dl></li>";
                        $("#dataListUl").append(html);//输出
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
    })
</script>