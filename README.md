<p align="center">
    <img src="./public/favicon.png" width="200" alt="application icon">
</p>

<p align="center">
    <a href="https://my-finances-planner-demo.cronitorstatus.com/"><img src="https://cronitor.io/badges/7TNGwI/production/Kx5Z8Ty_r1i5MPDI_w5JPm66d7Y.svg" alt="cronitor badge"></a>
    <a href="https://github.com/Jhon-Henkel/my-finances-planner/blob/main/LICENSE"><img src="https://img.shields.io/github/license/Jhon-Henkel/my-finances-planner"></a>
</p>

<p align="center">
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=docker,php,html,css,ts,vue,mysql,laravel,vite" />
  </a>
</p>

## Coverage
|                                                                                             Backend                                                                                              |                                                                                             Frontend                                                                                              |                                                                                        Total                                                                                         |
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
| [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?flag=backend&token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner) | [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?flag=frontend&token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner) | [![codecov](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/flag/backend/graph/badge.svg?token=ZWK28PWTZF&precision=2)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner) |

## Sobre My Finances Planner
Com a necessidade de algo mais completo e personalizado para controle financeiro, resolvi desenvolver essa aplicação.

## Como iniciar o projeto

- Rodar os comandos abaixo no container:
    ```bash
    composer update
    cp .env.example .env && cp resources/frontend-v2/.env.example resources/frontend-v2/.env
    php artisan setup:develop
    ```
- Rodar os comandos abaixo fora do container:
    ```bash
    make setup-frontend
    make frontend
    ```

## Licença
My finances planner é um software open-sourced licenciado em [MIT license](https://opensource.org/licenses/MIT).
