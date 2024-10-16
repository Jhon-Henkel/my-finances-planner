<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo(a) ao Plano Pro!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }
        .content {
            margin: 20px 0;
            text-align: center;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            color: #666666;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            color: #999999;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Finanças na Mão</h2>
    </div>
    <div class="content">
        <h1>Bem-vindo(a) ao Plano Pro!</h1>
        <p>Olá {{ $name }},</p>
        <p>Obrigado por escolher o Plano Pro! Estamos muito felizes em tê-lo(a) conosco. Aproveite todos os benefícios exclusivos do nosso plano Pro.</p>
        <a href="https://financasnamao.com.br/v2/login" class="button" target="_blank">Acessar Plataforma</a>
        <p>Caso ainda não reconheça como plano Pro ao fazer login, aguarde, pode levar até 24 horas para instituição de pagamento nos notificar.</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Finanças na Mão. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>
