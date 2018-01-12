@extends('layouts.app')

@section('content')
    @php
        $labelTypes = [
            'default',
            'primary',
            'danger',
        ];

    @endphp
    <div class="container">
        <div class="row">
            <h3>我的课程</h3>
            @if (count($courses) == 0)
                <b>暂无课程</b>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#课程#</th>
                        <th>地点</th>
                        <th>日期</th>
                        <th>状态</th>
                        <th>总分</th>
                        <th>已评分</th>
                        <th style="width:100px;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->location }}</td>
                            <td>{{ $course->date }}</td>
                            <td><span class="label label-{{ $labelTypes[$course->getState()['state']] }}">{{ $course->getState()['text'] }}</span></td>
                            <td>{{ $course->getTotal() }}</td>
                            <td><a href="#"><span class="badge">{{ $course->getRateNum() }}</span></a></td>
                            <td>
                                <button class="btn btn-primary" data-course-id="{{ $course->id }}" data-toggle="modal" data-target="#sentence">反馈列表</button>
                                {{--<a class="btn btn-primary" href="#">听众评分</a>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="sentence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">问题及建议</h4>
                </div>
                <div id="faq" class="modal-body">
                    <h5>问题</h5>
                    <ul id="questionList" class="list-group">
                    </ul>
                    <h5>建议</h5>
                    <ul id="suggestList" class="list-group">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">

        var userMap = {!! json_encode($users) !!};
        var questions = {!! json_encode($questions) !!};
        var suggests = {!! json_encode($suggests) !!};

        $('#sentence').on('show.bs.modal', function (e) {

            var course_id = $(e.relatedTarget).data('course-id');


            $('#questionList,#suggestList').empty();

            for(var i in questions[course_id]) {
                $('#questionList').append('<li class="list-group-item"><div class=\"media\"><div class=\"media-left\"></div><div class=\"media-body\"><h5 class="media-heading"><b>' + userMap[questions[course_id][i]['scorer']] + '</b></h5>' + questions[course_id][i]['question'] + '</div></div></li>');
            }
            for(var i in suggests[course_id]) {
                $('#suggestList').append('<li class="list-group-item"><div class=\"media\"><div class=\"media-left\"></div><div class=\"media-body\"><h5 class="media-heading"><b>' + userMap[questions[course_id][i]['scorer']] + '</b></h5>' + suggests[course_id][i]['suggest'] + '</div></div></li>');
            }
        })
    </script>
@endsection