@inject('task','App\Service\TaskService')
@inject('message','App\Service\MessageService')

<div class="page-header" xmlns="http://www.w3.org/1999/html">
    <div class="leftside-header">
        <div class="logo">
            <a href="/admin" class="on-click">
                <img alt="logo" src="/images/logo.png" />
            </a>
        </div>
        <div id="menu-toggle" class="visible-xs toggle-left-sidebar" data-toggle-class="left-sidebar-open" data-target="html">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <div class="rightside-header">
        <div class="header-middle"></div>
        <div class="header-section" id="search-headerbox">
            <input type="text" name="search_slidebar" id="search_slidebar" class="color-light hidden" placeholder="搜索操作列表...">
            <i class="fa fa-search search" id="search-icon" aria-hidden="true"></i>
            <div class="header-separator"></div>
        </div>
        <div class="header-section hidden-xs" id="notice-headerbox">
            <div class="notice" id="checklist-notice">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                <div class="dropdown-box basic">
                    <div class="drop-header">
                        <h3><i class="fa fa-check-square-o" aria-hidden="true"></i>我的任务</h3>
                    </div>
                    <div class="drop-content">
                        <div class="widget-list list-to-do">
                            <ul>
                                @foreach ($task->show(1, 5) as $task)
                                    <li>
                                        <div class="checkbox-custom checkbox-primary">
                                            <input type="checkbox" id="check-s1" value="option1">
                                            <label for="check-s1">
                                                <a href="{{route('task_update', [$task['task_id']])}}">
                                                    {{$task['title']}}
                                                </a>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="drop-footer">
                        <a href="{{route('task_page', ['page' => 1])}}">查看所有任务</a>
                    </div>
                </div>
            </div>
            <div class="notice" id="messages-notice">
                <i class="fa fa-comments-o" aria-hidden="true"></i>
                @if ($message->meNoRead() >= 1)
                    <span><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                @endif
                <div class="dropdown-box basic">
                    <div class="drop-header ">
                        <h3><i class="fa fa-comments-o" aria-hidden="true"></i>消息</h3>
                        <span class="number">{{$message->count('target_id')}}</span>
                    </div>
                    <div class="drop-content">
                        <div class="widget-list list-left-element">
                            <ul>
                                @foreach ($message->received(1, 5) as $message)
                                <li>
                                    <a href="{{route('message_received_page', ['page' => 1])}}">
                                        <div class="left-element"><img alt="{{$message['real_name']}}" src="{{$message['avatar']}}" /></div>
                                        <div class="text">
                                            <span class="title">{{$message['real_name']}}</span>
                                            <span class="subtitle">{{$message['content']}}</span>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="drop-footer">
                        <a>查看所有消息</a>
                    </div>
                </div>
            </div>
            <div class="notice" id="alerts-notice">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                <span>4</span>
                <div class="dropdown-box basic">
                    <div class="drop-header">
                        <h3><i class="fa fa-bell-o" aria-hidden="true"></i> Notifications</h3>
                        <span class="number">4</span>
                    </div>
                    <div class="drop-content">
                        <div class="widget-list list-left-element list-sm">
                            <ul>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-warning color-warning"></i></div>
                                        <div class="text">
                                            <span class="title">8 Bugs</span>
                                            <span class="subtitle">reported today</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-flag color-danger"></i></div>
                                        <div class="text">
                                            <span class="title">Error</span>
                                            <span class="subtitle">sevidor C down</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-cog color-dark"></i></div>
                                        <div class="text">
                                            <span class="title">New Configuration</span>
                                            <span class="subtitle"></span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-tasks color-success"></i></div>
                                        <div class="text">
                                            <span class="title">14 Task</span>
                                            <span class="subtitle">completed</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="left-element"><i class="fa fa-envelope color-primary"></i></div>
                                        <div class="text">
                                            <span class="title">21 Menssage</span>
                                            <span class="subtitle"> (see more)</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="drop-footer">
                        <a>See all notifications</a>
                    </div>
                </div>
            </div>
            <div class="header-separator"></div>
        </div>
        <div class="header-section" id="user-headerbox">
            <div class="user-header-wrap">
                <div class="user-photo">
                    <img src="{{ app('App\Repositories\ProfileRepositories')->findWhereArray('user_id', Auth::id())['avatar'] or '/ images/user.jpg'}}"/>
                </div>
                <div class="user-info">
                    <span class="user-name">{{ app('App\User')->find(Auth::id())->toArray()['name'] }}</span>
                    <span class="user-profile">{{ app('App\Repositories\ProfileRepositories')->findWhereArray('user_id', Auth::id())['real_name'] or '客官'}}</span>
                </div>
                <i class="fa fa-plus icon-open" aria-hidden="true"></i>
                <i class="fa fa-minus icon-close" aria-hidden="true"></i>
            </div>
            <div class="user-options dropdown-box">
                <div class="drop-content basic">
                    <ul>
                        <li id="login_lock"> <a href="/lock"><i class="fa fa-lock" aria-hidden="true"></i>锁定屏幕</a></li>
                        <li id="member_profile"> <a href="/admin/member/me/view"><i class="fa fa-lock" aria-hidden="true"></i>我的资料</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="header-separator"></div>
        <div class="header-section">
            <form method="post" action="/logout" id="logout_form">
                {{ csrf_field() }}
                <i class="fa fa-sign-out log-out" id="logout" aria-hidden="true"></i>
            </form>
        </div>
    </div>
</div>