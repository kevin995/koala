@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>评分人</th>
                    @foreach(config('app.votes') as $item)
                        <th>{{ $item['description'] }}</th>
                    @endforeach
                    <th>日期</th>
                </tr>
                </thead>
                <tbody>
                @foreach($scores as $score)
                    <tr>
                        <td>{{ $score->scorerInfo->name }}</td>
                        @foreach(json_decode($score->score)->scores as $s)
                            <td>{{ $s }}</td>
                        @endforeach
                        <td>{{ $score->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection