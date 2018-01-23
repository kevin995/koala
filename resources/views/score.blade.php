@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row">
            <h3>未评分</h3>
            @if (count($unscored_courses) == 0)
                <b>暂无可评课程</b>
            @else
                @foreach($unscored_courses as $course)
                    @if (!$course->hasSign())
                        @continue
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><b>{{ $course->name }}</b> 主讲人:#{{ $course->speakerInfo->name }}#</h4>
                        </div>
                        <div class="panel-body">
                            <div class="bg-danger">
                                {{ Html::ul($errors->all()) }}
                            </div>
                            {{ Form::open(array('url' => 'scores', 'class' => 'form-inline')) }}
                                @php
                                    $start = 0;
                                @endphp
                                <input hidden name="course_id" value="{{ $course->id }}">
                                <ul class="list-group">
                                    @foreach(config('app.votes') as $item)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-lg-1"><b>{{ $item['label'] }}<span class="text-danger">*</span></b></div>
                                                <div class="col-lg-4">{{ $item['description'] }}</div>
                                                <div class="col-lg-2 col-lg-offset-2">
                                                    <select name="score_{{ $start++ }}" class="form-control">
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
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-1"><b>问题<span class="text-danger">*</span></b></div>
                                            <div class="col-lg-6">
                                                <textarea name="question" id="" cols="50" rows="5">{{ old('question') }}</textarea>
                                            </div>
                                            <div class="col-lg-4">对本主题的问题和思考, 300字以内.</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-1"><b>建议<span class="text-danger">*</span></b></div>
                                            <div class="col-lg-6">
                                                <textarea name="suggest" id="" cols="50" rows="5">{{ old('suggest') }}</textarea>
                                            </div>
                                            <div class="col-lg-4">对演讲人的建议, 300字以内</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-2 col-lg-offset-10">
                                                <button type="submit" class="btn btn-sm btn-primary">确定</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            {{ Form::close() }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="row">
            <h3>已评分</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#课程#</th>
                    <th>主讲人</th>
                    <th>A分数</th>
                    <th>B分数</th>
                    <th>C分数</th>
                    {{--<th>反馈分数</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($scored_courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->speakerInfo->name }}</td>
                        @foreach(json_decode($course->score)->scores as $score)
                            <td>{{ $score }}</td>
                        @endforeach
                        {{--<td>{{ $course->lscore }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection