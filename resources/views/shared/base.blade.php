@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Finances Planner</title>
        <link rel="shortcut icon" href="public/favicon.png" type="image/x-icon"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="resources/css/app.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
                crossorigin="anonymous"></script>
    </head>
    <body>
{{--    @if (Auth::check())--}}
{{--        <li><a href="#">Olá, {{Auth::user()->name}}</a></li>--}}
{{--    @endif--}}
        <div class="container">
            @if (Auth::check())
                <nav>
                    <ul class="nav justify-content-end">
                        <li class="nav-item">
                            {{-- todo criar rotaa e telaa para configurações --}}
                            <a class="nav-link active" aria-current="page" href="#">
                                <i class="fa-solid fa-gear"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('logout')}}">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
            @yield('content')
        </div>
    </body>
</html>