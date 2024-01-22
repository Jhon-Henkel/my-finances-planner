@php
    use App\Tools\Request\RequestTools;
@endphp
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Finances Planner</title>
    <link rel="shortcut icon" href="/public/favicon.png" type="image/x-icon"/>
</head>
<body>
    @if(RequestTools::isApplicationInDemoMode() && ! RequestTools::isApplicationInDevelopMode())
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-TFXE4NPB8W"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-TFXE4NPB8W');
        </script>
    @elseif(RequestTools::isApplicationInBetaMode())
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XTZ8R45NX1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-XTZ8R45NX1');
        </script>
    @endif
    <div class="container" id="app"></div>
    @vite('resources/js/app.js')
</body>
</html>