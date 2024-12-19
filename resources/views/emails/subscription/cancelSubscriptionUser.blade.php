<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelamento de Assinatura</title>
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
            background-color: #FF0000;
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
        <h1>Cancelamento de Assinatura</h1>
        O usuário <strong>{{ $name }}</strong> com o e-mail <strong>{{ $email }}</strong> cancelou a assinatura.
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} Finanças na Mão. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>
