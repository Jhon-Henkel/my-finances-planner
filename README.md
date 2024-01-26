<p align="center">
    <img src="./public/favicon.png" width="200" alt="application icon">
</p>

<p align="center">
    <a href="https://github.com/Jhon-Henkel/my-finances-planner/actions?query=branch%3Amain++"><img src="https://github.com/Jhon-Henkel/my-finances-planner/actions/workflows/main_branch_pipeline.yml/badge.svg" alt="pipeline badge"></a>
    <a href="https://my-finances-planner-demo.cronitorstatus.com/"><img src="https://cronitor.io/badges/7TNGwI/production/Kx5Z8Ty_r1i5MPDI_w5JPm66d7Y.svg" alt="cronitor badge"></a>
    <a href="https://github.com/Jhon-Henkel/my-finances-planner/blob/main/LICENSE"><img src="https://img.shields.io/github/license/Jhon-Henkel/my-finances-planner"></a>
</p>

<p align="center">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=docker,php,html,css,js,vue,bootstrap,mysql,laravel,vite" />
  </a>
</p>

## Coverage
|                                                                                             Backend                                                                                              |                                                                                             Frontend                                                                                              |                                                                                        Total                                                                                         |
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?flag=backend&token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner) | [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?flag=frontend&token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner) | [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/flag/backend/graph/badge.svg?token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner) |

## Sobre My Finances Planner
Com a necessidade de algo mais completo e personalizado para controle financeiro, resolvi desenvolver essa aplicação.

## Como iniciar o projeto

Forma mais rápida de iniciar o projeto:
- Criar o .env com base no .env.example e configurar as variáveis de ambiente
- Rodar o ***php artisan start:develop-project*** (rodar dentro do container)
- Seguir os passos informados no terminal após terminar a configuração

Caso precise configurar o projeto manualmente, leia o arquivo de [primeiros passos](https://github.com/Jhon-Henkel/my-finances-planner/blob/main/.docs/FIRST_STEPS.md).

Criei alguns comandos úteis, você pode conferir [aqui](https://github.com/Jhon-Henkel/my-finances-planner/blob/main/.docs/COMMANDS.md).
## Monitoramentos
- **Erros**: Para monitoramento de erros estou utilizando o [honeybadger](https://www.honeybadger.io/), para configurar basta popular 
a variável **HONEYBADGER_API_KEY** com a chave de acesso da sua conta.
- **Cron**: Para monitoramento de cron estou utilizando o [cronitor](https://cronitor.io/), para configura, basta popular
a variável **CRONITOR_API_KEY** com a chave de acesso da sua conta.
- **Up Time**: O monitoramento de up time do site pode ser visto [aqui](https://my-finances-planner-demo.cronitorstatus.com/).

## Licença
My finances planner é um software open-sourced licenciado em [MIT license](https://opensource.org/licenses/MIT).
