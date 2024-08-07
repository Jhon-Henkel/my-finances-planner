<p align="center">
    <img src="./public/favicon.png" width="200" alt="application icon">
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
- Montar container:
    ```bash
    cp .env.example .env && cp resources/frontend-v2/.env.example resources/frontend-v2/.env
    cp docker-compose.dev.yml docker-compose.yml
    docker compose up -d
    ```

- Acessar o container:
    ```bash
    make backend-bash
    ```

- Setup backend (dentro do container):
    ```bash
    composer update
    php artisan key:generate  
    php artisan setup:develop
    ```
- Setup frontend (fora do container):
    ```bash
    make setup-frontend
    ```
- Hot reload frontend (fora do container):
    ```bash
    make frontend
    ```
## Acessos
- PHPMyAdmin:
    - [http://localhost:8080](http://localhost:8080)
    - Usuário: root
    - Senha: 123

## Licença
My finances planner é um software open-sourced licenciado em [MIT license](https://opensource.org/licenses/MIT).
