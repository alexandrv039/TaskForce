<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Taskforce</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="page-header">
    <nav class="main-nav">
        <a href='{{ route('home') }}' class="header-logo">
            <img class="logo-image" src="img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item list-item--active">
                    <a class="link link--nav" >Новое</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Мои задания</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Создать задание</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="user-block">
        <a href="#">
            <img class="user-photo" src="img/man-glasses.png" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name">Василий</p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="#" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <form class="form-inline" method="post" action="{{ route('logout') }}">
                            @csrf
                            <input type="submit" class="link" value="Выход из системы">
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</header>
<main class="main-content container">

        @yield('content')

</main>
<script src="js/landing.js"></script>
</body>
</html>
