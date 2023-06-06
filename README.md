<p align="center"><img src="./public/favicon.png" width="200" alt="Laravel Logo"></p>


[![Tests](https://github.com/Jhon-Henkel/my-finances-planner/actions/workflows/main_branch_pipeline.yml/badge.svg)](https://github.com/Jhon-Henkel/my-finances-planner/actions/workflows/main_branch_pipeline.yml)
[![PHP-Coverage](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?token=ZWK28PWTZF)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner)
## Sobre My Finances Planner

Com a necessidade de algo mais completo e personalizado para controle financeiro, resolvi desenvolver essa aplicação. Atualmente esse projeto está em fase de testes(Beta).

## Licença

My finances planner é um software open-sourced licenciado em [MIT license](https://opensource.org/licenses/MIT).

## Como iniciar o projeto
- Criar o .env com base no .env.example e configurar as variáveis de ambiente
- Gerar a **APP_KEY** com o comando ***php artisan key:generate***
- Gerar o **PUSHER_APP_KEY** com o comando ***php artisan key:mfp-key***
- Rodar ***chown www-data:www-data -R storage/logs/*** e ***chown www-data:www-data -R storage/framework*** (somente se for rodar em docker localmente)
- Rodar o ***composer update*** e o ***npm install***
- Rodar o comando ***composer run migration:run*** ou ***php artisan migrate***
- Criar um usuário para acesso na tabela **user** a senha deve ser criptografada com o bcrypt
- Caso vá utilizar em ambiente de desenvolvimento, rodar o comando ***npm run dev***
- Caso vá utilizar em ambiente de produção, rodar o comando ***npm run build*** para gerar os arquivos de produção

## Monitoramentos
- Erros: Para monitoramento de erros estou utilizando o [honeybadger](https://app.honeybadger.io/), para configura-lo basta popular 
a variável **HONEYBADGER_API_KEY** com a chave de acesso da sua conta.
- Cron: Para monitoramento de cron estou utilizando o [cronitor](https://cronitor.io/), para configura-lo basta popular
a variável **CRONITOR_API_KEY** com a chave de acesso da sua conta.