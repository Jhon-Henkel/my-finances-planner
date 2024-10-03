<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanças na Mão</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link
        rel="shortcut icon"
        type="image/png"
        href="https://mfpimages.blob.core.windows.net/my-finances-planner-public/favicon.png"
    />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Estilo do cabeçalho */
        .header {
            background-color: #333;
            padding: 20px 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            color: white;
            font-weight: 700;
        }

        .btn {
            color: white;
            background-color: #4A90E2;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #4A90E2;
            padding: 15px 30px;
            border-radius: 50px;
            color: white;
            font-size: 18px;
            text-decoration: none;
            display: inline-block;
        }

        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 100px 0;
            background-color: #f8f9fa;
        }

        .hero-content {
            max-width: 50%;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .hero-image img {
            width: 100%;
            max-width: 500px;
        }

        /* Estilo das seções de funcionalidades */
        .features {
            background-color: #ffffff;
            padding: 50px 0;
            text-align: center;
        }

        .features-list {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .feature {
            max-width: 30%;
        }

        .feature h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .feature p {
            font-size: 18px;
        }

        .pro-label {
            color: #4A90E2;
            font-weight: 700;
        }

        /* Seção de testemunhos */
        .testimonials {
            background-color: #f1f1f1;
            padding: 50px 0;
            text-align: center;
        }

        .testimonial-list {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .testimonial {
            max-width: 40%;
        }

        .testimonial p {
            font-size: 18px;
            font-style: italic;
            margin-bottom: 10px;
        }

        .testimonial span {
            font-size: 16px;
            color: #777;
        }

        /* Seção de Planos */
        .pricing {
            padding: 50px 0;
            background-color: #ffffff;
            text-align: center;
        }

        .pricing-table {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .pricing-card {
            max-width: 30%;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .pricing-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .pricing-card p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .pricing-card ul {
            list-style-type: none;
            margin-bottom: 20px;
        }

        .pricing-card ul li {
            font-size: 16px;
            margin: 10px 0;
        }

        .pricing-card.pro {
            background-color: #4A90E2;
            color: white;
        }

        .pricing-card.pro ul li {
            color: white;
        }

        .pricing-card.pro h3,
        .pricing-card.pro p {
            color: white;
        }

        /* Rodapé */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .footer p {
            margin: 0;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-content {
                max-width: 100%;
            }

            .hero-image img {
                max-width: 100%;
                margin-top: 20px;
            }

            .features-list,
            .testimonial-list,
            .pricing-table {
                flex-direction: column;
                align-items: center;
            }

            .feature,
            .testimonial,
            .pricing-card {
                max-width: 90%;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>

<!-- Cabeçalho com logotipo e call to action -->
<header class="header">
    <div class="container">
        <nav class="navbar">
            <div class="logo">
                Finanças na Mão
            </div>
            <a href="/v2/login" class="btn">
                Login
            </a>
        </nav>
    </div>
</header>

<!-- Seção Principal -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Controle Suas Finanças com Facilidade</h1>
            <p>
                Com o <strong>Finanças na Mão</strong>, gerencie suas entradas, saídas, cartões de crédito
                e muito mais. Organize seu futuro financeiro de forma simples, prática e sem as burocracias
                dos aplicativos atuais.
            </p>
            <a href="/v2/registrar-se" class="btn-primary">
                Comece Gratuitamente
            </a>
        </div>
        <div class="hero-image">
            <img src="https://mfpimages.blob.core.windows.net/my-finances-planner-public/landing_page_image_1.png"
                 alt="Mockup do Planner de Finanças">
        </div>
    </div>
</section>

<!-- Seção de Funcionalidades -->
<section class="features">
    <div class="container">
        <h2>Principais Funcionalidades</h2>
        <div class="features-list">
            <div class="feature">
                <h3>Cadastro de Movimentações</h3>
                <p>Registre entradas, saídas e transferências facilmente, sem burocracia, tudo em um só lugar.</p>
            </div>
            <div class="feature">
                <h3>Planejamento Futuro</h3>
                <p>Crie planos de gastos e receitas para os próximos meses e mantenha suas finanças organizadas.</p>
            </div>
            <div class="feature">
                <h3>Saúde Financeira <span class="pro-label">Pro</span></h3>
                <p>Veja um resumo detalhado das suas finanças, agrupando suas entradas e saídas por nome.</p>
            </div>
        </div>
    </div>
</section>

<!-- Seção de Depoimentos -->
{{--<section class="testimonials">--}}
{{--    <div class="container">--}}
{{--        <h2>Depoimentos</h2>--}}
{{--        <div class="testimonial-list">--}}
{{--            <div class="testimonial">--}}
{{--                <p>--}}
{{--                    "Esse planner mudou a forma como organizo minhas finanças. É fácil de usar e tem tudo o que--}}
{{--                    preciso!"--}}
{{--                </p>--}}
{{--                <span>- Joana Silva</span>--}}
{{--            </div>--}}
{{--            <div class="testimonial">--}}
{{--                <p>"Com o plano Pro, finalmente tenho controle total sobre meu dinheiro. Vale cada centavo!"</p>--}}
{{--                <span>- Carlos Souza</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

<!-- Seção de Planos -->
<section id="planos" class="pricing">
    <div class="container">
        <h2>Conheça os Planos</h2>
        <div class="pricing-table">
            <!-- Plano Free -->
            <div class="pricing-card">
                <h3>Plano Free</h3>
                <p>Grátis para sempre</p>
                <ul>
                    <li>Cadastro/uso de 1 carteira</li>
                    <li>Cadastro/uso de 1 cartão de crédito</li>
                    <li>Planejamento de gastos e receitas</li>
                    <li>
                        <del>Acesso à Saúde Financeira</del>
                    </li>
                </ul>
            </div>
            <!-- Plano Pro -->
            <div class="pricing-card pro">
                <h3>Plano Pro</h3>
                <p>R$ 9,90/mês</p>
                <ul>
                    <li>Todas as funcionalidades</li>
                    <li>Carteiras ilimitadas</li>
                    <li>Cartões de crédito ilimitados</li>
                    <li>Planejamento de gastos e receitas</li>
                    <li>Acesso total à Saúde Financeira</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Rodapé -->
<footer class="footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Finanças na Mão. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>
