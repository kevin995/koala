@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>未评分</h3>
            @if (count($unscored_courses) == 0)
                <b>暂无可评课程</b>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#课程#</th>
                        <th>主讲人</th>
                        <th>评分</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($unscored_courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->speakerInfo->name }}</td>
                            <td width="150px;">
                                {{ Form::open(array('url' => 'scores', 'class' => 'form-inline')) }}
                                <input hidden name="course_id" value="{{ $course->id }}">
                                <select name="score" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-default">确定</button>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="row">
            <h3>已评分</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#课程#</th>
                    <th>主讲人</th>
                    <th>分数</th>
                    <th>听分数</th>
                </tr>
                </thead>
                <tbody>
                @foreach($scored_courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->speakerInfo->name }}</td>
                        <td>{{ $course->score }}</td>
                        <td>{{ $course->lscore }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection