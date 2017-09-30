@extends('layouts.app')

@section('title', $judge::isStoreOrUpdate($type).'文章')

@section('link')
    @parent
    <link rel="stylesheet" href="/vendor/animate.css/animate.css">
    <link rel="stylesheet" href="/vendor/data-table/media/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/stylesheets/css/style.css">
    {{--编辑器--}}
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="https://cdn.bootcss.com/flatpickr/2.5.6/flatpickr.js"></script>
    <script type="text/javascript" charset="gbk" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
@endsection

@section('breadcrumbs')
    <li navValue="nav_4"><i class="fa fa-home" aria-hidden="true"></i><a href="/">我的文章</a></li>
    <li navValue="nav_4_2"><a href="#">{{$judge::isStoreOrUpdate($type)}}文章</a></li>
@endsection

@section('content_body')
    <div class="row animated fadeInUp">
        <div class="col-sm-12">
            <h4 class="section-subtitle"><b>{{$judge::isStoreOrUpdate($type)}}文章</b></h4>
            <div class="panel panel-default">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="messagebox-validation" action="{{$uri}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{--输出错误信息--}}
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <label class="error" style="color: #fff">{{ $error }}</label>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="category_id" class="control-label">选择分类<span class="required">*</span></label>
                                    <select id="category_id" name="category_id" class="form-control select2-hidden-accessible" required>
                                        @if (!empty($old_input['category_id']))
                                           <option value="{{ $old_input['category_id'] }}">{{ \App\Category::find($old_input['category_id'])['name'] }}</option>
                                        @endif
                                        @foreach($categories as $category)
                                           <option value="{{ $category['category_id'] }}">{{ $category['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title" class=" control-label">主题<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{$old_input['title']}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="start_time" class=" control-label">封面图片<span class="required">*</span></label>
                                    <input type="text" id="article_picture_input" class="form-control"  value="{{$old_input['picture'] or ''}}" placeholder="上传封面图片...">
                                    <input type="file" id="article_picture_file" style="margin-top: 1em;">
                                </div>
                                <div class="form-group">
                                    <label for="attribute" class="control-label">类型<span class="required">*</span></label>
                                    <select id="attribute" name="attribute" class="form-control select2-hidden-accessible" required>
                                        @if (!empty($old_input['attribute']))
                                            <option value="{{$old_input['attribute']}}">{{$judge::articleStatus($old_input['attribute'])}}</option>
                                        @endif
                                            <option value="1">{{$judge::articleStatus(1)}}</option>
                                            <option value="2">{{$judge::articleStatus(2)}}</option>
                                    </select>
                                </div>
                                @if ($type == 'update')
                                    <div class="form-group">
                                        <label for="category" class="control-label">栏目<span class="required">*</span></label>
                                        <select name="category" class="form-control select2-hidden-accessible" required>
                                            @if (!empty($current['name']))
                                                <option value="{{$current['category_id']}}">{{$current['name']}}(当前栏目)</option>
                                            @endif
                                                {!! app('\App\Services\CategoryService')->categoryHtml('<option value="<<category_id>>"><<title>></option>"><<title>></a></li>', 'article') !!}
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="start_time" class=" control-label">摘要<span class="required">*</span></label>
                                    <textarea class="form-control" name="abstract" placeholder="输入文章摘要..." >{{$old_input['abstract']}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="content" class=" control-label">详细内容<span class="required">*</span></label>
                                    <script id="editor" type="text/plain" name="body">
                                        {!! isset($old_input['body']) ? $old_input['body'] : '' !!}
                                    </script>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script src="/vendor/nano-scroller/nano-scroller.js"></script>
    <script src="/javascripts/template-script.min.js"></script>
    <script src="/javascripts/template-init.min.js"></script>
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function () {
            //input框change事件
            $('#article_picture_input').on('change', function () {
                $('#article_picture_input').attr('name', 'picture');
                $('#article_picture_file').attr('name', '');
            });

            //file框change时间
            $('#article_picture_file').on('change', function () {
                $('#article_picture_input').val($(this).val()).attr('name', '');
                $(this).attr('name', 'picture');
            })

            //开启编辑器
            UE.getEditor('editor')
        });
    </script>
@endsection