@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>用户列表</h3>
            @if (count($users) == 0)
                <b>暂无用户</b>
            @else
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>用户</th>
                        <th>邮箱</th>
                        <th>创建日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection