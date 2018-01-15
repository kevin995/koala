@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="jumbotron">
                <h1>Hello, Knowledge!</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <ul class="list-group">
                    @foreach($rateTraces as $trace)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-9">{{ $trace->scorerInfo->name }} 评价了 #<b>{{ $trace->course->name }}</b>#</div>
                                <div class="col-md-3">{{ $trace->created_at }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="list-group">
                    <li class="list-group-item"><b>已注册</b> {{ $userTotal }}人</li>
                    <li class="list-group-item"><b>已开课</b> {{ $courseTotal }}节</li>
                    <li class="list-group-item">
                        <a href="#" class="thumbnail">
                            <img src="{{ asset('images/koala-animals.jpg') }}" alt="...">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
