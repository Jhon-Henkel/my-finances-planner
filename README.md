<p align="center"><img src="./public/favicon.png" width="200" alt="Laravel Logo"></p>


[![Tests](https://github.com/Jhon-Henkel/my-finances-planner/actions/workflows/main_branch_pipeline.yml/badge.svg)](https://github.com/Jhon-Henkel/my-finances-planner/actions/workflows/main_branch_pipeline.yml)
[![PHP-Coverage](https://codecov.io/gh/Jhon-Henkel/my-finances-planner/branch/main/graph/badge.svg?token=ZWK28PWTZF)](https://codecov.io/gh/Jhon-Henkel/my-finances-planner)
## Sobre My Finances Planner

Com a necessidade de algo mais completo e personalizado para controle financeiro, resolvi desenvolver essa aplicação. Atualmente esse projeto está em fase de testes(Beta).

## Licença

My finances planner é um software open-sourced licenciado em [MIT license](https://opensource.org/licenses/MIT).

## Como iniciar o projeto
- Criar o .env com base no .env.example e configurar as variáveis de ambiente
- Rodar 'chown www-data:www-data -R storage/logs/' e 'chown www-data:www-data -R storage/framework'
- Rodar o 'composer update' e o npm install
- Rodar o comando 'composer run migration:make'
- Voltar no .env e configurar a variável VITE_PUSHER_APP_KEY com o mfp-token que foi criado na tabela de configurações
- Criar um usuário para acesso na tabela 'user' a senha deve ser criptografada com o bcrypt
- Caso vá utilizar em ambiente de desenvolvimento, rodar o comando 'npm run dev'
- Caso vá utilizar em ambiente de produção, rodar o comando 'npm run build' para gerar os arquivos de produção