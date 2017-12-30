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
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>下一场 <span class="label label-primary">New</span></h4>
                </div>
                <div class="panel-body">
                    @if ($nextCourse)
                        <p>课程: <b>{{ $nextCourse->name }}</b><span class="label label-{{ $labelTypes[$nextCourse->getState()['state']] }}">{{ $nextCourse->getState()['text'] }}</span></p>
                        <p>主讲人: <b>{{ $nextCourse->speakerInfo->name }}</b></p>
                        <p>地点: <b>{{ $nextCourse->location }}</b></p>
                        <p>时间: <b>{{ $nextCourse->date }}</b></p>
                    @else
                        <b>暂无课程</b>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>课程列表</h3>
            <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#课程#</th>
                        <th>主讲人</th>
                        <th>地点</th>
                        <th>时间</th>
                        <th>状态</th>
                        @if (!Auth::guest() && Auth::user()->isAdmin())
                            <th>操作</th>
                        @endif

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->speakerInfo->name }}</td>
                            <td>{{ $course->location }}</td>
                            <td>{{ $course->date }}</td>
                            <td><span class="label label-{{ $labelTypes[$course->getState()['state']] }}">{{ $course->getState()['text'] }}</span></td>
                            @if (!Auth::guest() && Auth::user()->isAdmin())
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{ URL::to('courses/' . $course->id . '/edit') }}">编辑</a>
                                    {{--{{ Form::open(['url' => 'courses/' . $course->id, 'class' => 'pull-right']) }}--}}
                                    {{--{{ Form::hidden('_method', 'DELETE') }}--}}
                                    {{--{{ Form::submit('删除', ['class' => 'btn btn-sm btn-danger']) }}--}}
                                    {{--{{ Form::close() }}--}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
