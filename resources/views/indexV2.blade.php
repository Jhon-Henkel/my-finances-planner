@php
    use App\Tools\Request\RequestTools;

    $buildFile = __DIR__ . '/../../../public/build-ionic/index.html';
    $buildExists = file_exists($buildFile)
@endphp

@if(RequestTools::isApplicationInDevelopMode() && ! $buildExists)
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="utf-8"/>
        <title>Ionic App</title>

        <base href="/"/>

        <meta name="color-scheme" content="light dark"/>
        <meta
            name="viewport"
            content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <meta name="format-detection" content="telephone=no"/>
        <meta name="msapplication-tap-highlight" content="no"/>

        <link rel="shortcut icon" type="image/png" href="../frontend-v2/public/favicon.png"/>

        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-title" content="Ionic App"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    </head>

    <body>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="ionic-app"></div>
    <script type="module" src="http://localhost:8100/src/main.ts"></script>
    </body>

    </html>
@else
    {!! file_get_contents(public_path('build-ionic/index.html')) !!}
@endif