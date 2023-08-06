# Configurando o projeto
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