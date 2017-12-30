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