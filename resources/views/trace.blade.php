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
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#课程#</th>
                    <th>主讲人</th>
                    <th>日期</th>
                    <th>状态</th>
                    <th>总分</th>
                    <th>已评分</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->speakerInfo->name }}</td>
                            <td>{{ $course->date }}</td>
                            <td><span class="label label-{{ $labelTypes[$course->getState()['state']] }}">{{ $course->getState()['text'] }}</span></td>
                            <td>{{ $course->getTotal() }}</td>
                            <td>
                                <a class="active btn-sm btn-warning" href="{{ Auth::user()->isAdmin() ? URL::route('score_list', ['courseId' => $course->id]) : '#'}}">
                                    <span class="badge">{{ $course->getRateNum() }}</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection