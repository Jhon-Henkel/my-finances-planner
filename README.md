<p align="center"><img src="./public/favicon.png" width="200" alt="Laravel Logo"></p>

<div style="text-align: center;">

[![main-branch-pipeline](https://github.com/Jhon-Henkel/my-finances-planner/actions/workflows/main_branch_pipeline.yml/badge.svg)](https://github.com/Jhon-Henkel/my-finances-planner/actions?query=branch%3Amain++&target=_blank)
[![status page](https://cronitor.io/badges/7TNGwI/production/Kx5Z8Ty_r1i5MPDI_w5JPm66d7Y.svg)](https://my-finances-planner-demo.cronitorstatus.com/?target=_blank)

</div>

|                                                                                                 Teste Backend                                                                                                  |                                                                                                 Testes Frontend                                                                                                 |
|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?flag=backend&token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner?target=_blank) | [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?flag=frontend&token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner?target=_blank) |


## Sobre My Finances Planner

Com a necessidade de algo mais completo e personalizado para controle financeiro, resolvi desenvolver essa aplicação. Atualmente esse projeto está em fase de testes(Beta).

## Licença

My finances planner é um software open-sourced licenciado em [MIT license](https://opensource.org/licenses/MIT).

## Como iniciar o projeto
- Criar o .env com base no .env.example e configurar as variáveis de ambiente
- Rodar o ***composer update && npm install***
- Gerar a **APP_KEY** com o comando ***php artisan key:generate***
- Gerar o **PUSHER_APP_KEY** com o comando ***php artisan key:mfp-key***
- Rodar ***chown www-data:www-data -R storage/logs/ && chown www-data:www-data -R storage/framework*** (somente se for rodar em docker localmente)
- Rodar o comando ***php artisan migrate*** para criar as tabelas e registros iniciais
- Rodar o comando ***php artisan create:user*** para criar um usuário demo, o login e senha será exibido no terminal
- Caso vá utilizar em ambiente de desenvolvimento, rodar o comando ***npm run dev*** para ter o hot reload
- Caso vá utilizar em ambiente de produção, rodar o comando ***npm run build*** para fazer a build os arquivos
- Acessar o projeto pela [url](http://localhost/login)

## Monitoramentos
- Erros: Para monitoramento de erros estou utilizando o [honeybadger](https://app.honeybadger.io/), para configurar basta popular 
a variável **HONEYBADGER_API_KEY** com a chave de acesso da sua conta.
- Cron: Para monitoramento de cron estou utilizando o [cronitor](https://cronitor.io/), para configura, basta popular
a variável **CRONITOR_API_KEY** com a chave de acesso da sua conta.
- Status do site: O monitoramento de status do site pode ser visto [aqui](https://my-finances-planner-demo.cronitorstatus.com/).