<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Поиск</title>
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head><!--/head-->
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">GreenIce Finder</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      @guest
      @else
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <form class="form-inline my-2 my-lg-0" action="{{route('get.index')}}" method="get">
                    <input class="form-control mr-sm-2" value="{{ session('search') }}"name="search" type="search" placeholder="Введите имя" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
                </form>
            </li>
            <li class="nav-item active">
                <form class="form-inline my-2 my-lg-0" action="{{route('get.clear')}}" method="get">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Очистить Поиск</button>
                </form>
            </li>
        </ul>
      @endguest
      @guest
      @else
        <a href="{{ route('get.show') }}">
            <button class="btn btn-outline-info my-2 my-sm-0 my-2 my-lg-0" >Избраные</button>
        </a>
      @endguest
      <!-- Authentication Links -->
                    
                    <ul class="navbar-nav ">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <div>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"class="btn btn-outline-info my-2 my-sm-0 my-2 my-lg-0" >Выйти</button>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
  </div>
</nav>
<hr>
<div class="container">
    @guest
    @else
        Пользователь: {{ Auth::user()->email }}
    @endguest

    @if(session('success'))
        <div class="alert alert-info" role="alert"> 
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert"> 
            {{ session('error') }}
        </div>
    @endif
    @yield('content') 
</div>    