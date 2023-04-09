@php
    use App\Tools\CalendarTools;
    use Illuminate\Support\Facades\Auth;
@endphp
    <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Finances Planner</title>
    <link rel="shortcut icon" href="public/favicon.png" type="image/x-icon"/>
    {{-- todo importar as libs via npm --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/sb-1.4.1/sp-2.1.2/datatables.min.css"
          rel="stylesheet"/>
    @vite('resources/css/app.css')
</head>
<body>
    @if (Auth::check())
        <script>
            localStorage.setItem('salutation', '{{ CalendarTools::salutation(Auth::user()->name, date('H')) }}')
        </script>
        <div class="container" id="app">
        </div>
    @else
        <div class="container">
            @yield('content')
        </div>
    @endif
    @vite('resources/js/app.js')
    <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/r-2.4.1/sb-1.4.1/sp-2.1.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>
</html>