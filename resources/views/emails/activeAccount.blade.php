<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ativação de Conta</title>
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
        <h1>Bem-vindo à Plataforma!</h1>
        <p>Olá {{ $name }},</p>
        <p>Obrigado por se registrar na nossa plataforma. Para ativar sua conta e começar a usar nossos serviços, por favor clique no botão abaixo:</p>
        <a href="{{ config('app.url') }}/v2/ativar/{{ $hash }}" class="button" target="_blank">Ativar Conta</a>
        <p>Se você não se registrou na nossa plataforma, por favor ignore este e-mail.</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Finanças na Mão. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>
