<!DOCTYPE html>
<html>
    <body>
        <h1>{{ \App\Tools\CalendarTools::salutation($name, date('H')) }}</h1>
        <p>
            Estamos enviando esse e-mail pois seu acesso ao sistema está inativo.
        </p>
        <p>
            Para voltar a ter acesso ao sistema, clique <a href="{{ $linkToActiveUser }}" target="_blank">aqui</a>.
        </p>
    </body>
</html>