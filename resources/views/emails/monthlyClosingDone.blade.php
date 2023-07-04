<!DOCTYPE html>
<html>
    <body>
        <h1>{{ \App\Tools\CalendarTools::salutation($name, date('H')) }}</h1>
        <p>
            Existe um novo registro de fechamento de mês.
        </p>
        <p>
            Você pode visualizar clicando <a href="{{ $link }}" target="_blank">aqui</a>.
        </p>
    </body>
</html>