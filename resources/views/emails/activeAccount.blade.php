<!DOCTYPE html>
<html>
<body>
<h1>{{ \App\Tools\Calendar\CalendarTools::salutation($name, date('H')) }}</h1>
<p>
    Estamos enviando esse e-mail pois recebemos uma solicitação de cadastro no Finanças na Mão ;)
</p>
<p>
    Boas noticias, a espera acabou! Seu cadastro foi realizado com sucesso, só falta ativar a conta.
</p>
<p>
    Para ativar sua conta e ter acesso ao sistema, é muito simples, basta clicar
    <a href="{{ config('app.url') }}/v2/ativar/{{ $hash }}" target="_blank">aqui</a>.
</p>
</body>
</html>
