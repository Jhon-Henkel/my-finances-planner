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
        <title>Develop Mode - Finanças na Mão</title>

        <base href="/"/>

        <meta name="color-scheme" content="light dark"/>
        <meta
            name="viewport"
            content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
        />
        <meta name="format-detection" content="telephone=no"/>
        <meta name="msapplication-tap-highlight" content="no"/>

        <link
            rel="shortcut icon"
            type="image/png"
            href="https://mfpimages.blob.core.windows.net/my-finances-planner-public/favicon.png"
        />
        <script type="text/javascript">
            (function() {
                function $MPC_load() {
                    window.$MPC_loaded !== true && (function() {
                        const s = document.createElement("script");
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = document.location.protocol + "//secure.mlstatic.com/mptools/render.js";
                        const x = document.getElementsByTagName('script')[0];
                        x.parentNode.insertBefore(s, x);
                        window.$MPC_loaded = true;
                    })();
                }
                window.$MPC_loaded !== true
                    ? (
                        window.attachEvent
                            ? window.attachEvent('onload', $MPC_load)
                            : window.addEventListener('load', $MPC_load, false)
                    ) : null;
            })();
        </script>
    </head>

    <body>
        <noscript>You need to enable JavaScript to run this app.</noscript>
        <script>console.log('Running in develop mode, index file is indexV2.blade.php');</script>
        <div id="ionic-app"></div>
        <script type="module" src="http://localhost:5173/src/main.ts"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>

    </html>
@else
    {!! file_get_contents(public_path('build-ionic/index.html')) !!}
@endif
