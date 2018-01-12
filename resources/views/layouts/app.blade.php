<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    @php
                        $menus = [
                            [
                                'name' => '课程信息',
                                'route' => route('home')
                            ],
                            [
                                'name' => '课程评分',
                                'route' => route('score')
                            ],
                            [
                                'name' => '我的课程',
                                'route' => route('my_courses'),
                            ],
                            [
                                'name' => '课程排行',
                                'route' => route('trace'),
                            ]
                        ];

                        if (!Auth::guest()) {
                            $user = Auth::user();

                            $unScoredCount = \App\Models\Course::all()->where('isclose', '=', 1)
                                ->where('speaker', '!=', $user->id)->count()
                                - \App\Models\Score::all()->where('scorer', '=', $user->id)->count();

                            if ($unScoredCount) {
                                $menus[1]['name'] = $menus[1]['name'] . '<span class="badge progress-bar-danger">' . $unScoredCount . '</span>';
                            }
                        }

                    @endphp

                    <ul class="nav navbar-nav">
                        @if (!Auth::guest())
                            @for($i = 0; $i < count($menus); $i++)
                                <li class="{{ isset($active) ? $active == $i ? 'active' : '' : ''}}"><a href="{{ $menus[$i]['route'] }}">{!! $menus[$i]['name'] !!}</a></li>
                            @endfor
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">登录</a></li>
                            <li><a href="{{ route('register') }}">注册</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (Auth::user()->isAdmin())
                                        <li><a href="{{ URL::to('courses/create') }}">新增课程</a></li>
                                        <li><a href="{{ URL::to('users') }}">用户列表</a></li>

                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                            退出
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/locales/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    @yield('js')
</body>
</html>
