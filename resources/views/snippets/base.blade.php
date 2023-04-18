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
    <link rel="shortcut icon" href="/public/favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"/>
</head>
<body>
    @if (Auth::check())
        <script>
            localStorage.setItem('salutation', '{{ CalendarTools::salutation(Auth::user()->name, date('H')) }}')
        </script>
        <div class="container" id="app"></div>
    @else
        <div class="container" id="login"></div>
    @endif
    @vite('resources/js/app.js')
</body>
</html>