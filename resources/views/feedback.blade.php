@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">反馈</div>
                <div class="panel-body">
                    {{ Form::open(['url' => 'feedbacks']) }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name" class="col-md-1 control-label">课程</label>
                                <div class="col-md-9">
                                    <select id="course_id" class="form-horizontal form-control" name="course_id">
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proposer" class="col-sm-3 control-label">提问人</label>
                                <div class="col-sm-9">
                                    <select id="proposer" class="form-horizontal form-control" name="proposer">
                                        @foreach($user as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="col-sm-1 control-label">问题</label>
                                <textarea class="form-control" name="question" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-default pull-right">提交</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="row">
            <h3>反馈列表</h3>
            @if (count($feedback) == 0)
                <b>暂无反馈</b>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#课程#</th>
                        <th>地点</th>
                        <th>日期</th>
                        <th>状态</th>
                        <th>总分</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->location }}</td>
                            <td>{{ $course->date }}</td>
                            <td><span class="label label-{{ $labelTypes[$course->getState()['state']] }}">{{ $course->getState()['text'] }}</span></td>
                            <td>{{ $course->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection