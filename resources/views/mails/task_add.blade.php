<!DOCTYPE html>
<html>
    <head>
        <title>{{$task['title']}}</title>
    </head>
    <body>
        <p>任务主题：{{$task['title']}}</p>
        <p>任务时间：{{$task['start_time']}} {{$task['end_time']}}</p>
        <p>计划：{{$plan::plan($task['plan'])}}</p>
        <p>手机：{{$task['phone']}}</p>
        <p>邮箱：{{$task['email']}}</p>
        <h3>提醒内容</h3>
        <div style="float:left;border: 1px solid #cccccc">
           {!! $task['content'] !!}
        </div>
    </body>
</html>
