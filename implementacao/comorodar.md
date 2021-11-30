# Texto auxiliar

## Precisa ter instalado na maquina:
* php 7.4.26  
* composer 
* nodejs v14.17.6
# Como instalar
## FrontEnd
cd moeda/frontend
rode os seguintes comandos:

npm install
npm run dev
acessar localhost:3000
## BackEnd
cd moeda/backend
composer install
php -S localhost:8000 -t public
## Criando o banco
Necessário antes configurar o env e criar o schema do banco de dados

dentro da pasta moeda/backend:

php artisan migrate

php artisan db:seed

## Rodar depois de configurado
para rodar:

cd moeda/backend

php -S localhost:8000 -t public

rodar o front end:

cd moeda/frontend
npm run dev

entre em localhost:3000 e logue com joao@teste.com senha teste123