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
    <link rel="apple-touch-icon" sizes="180x180" href="/public/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon-16x16.png">
    <link rel="manifest" href="/public/site.webmanifest">
    <link rel="mask-icon" href="/public/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="initial-scale=1, viewport-fit=cover, width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
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