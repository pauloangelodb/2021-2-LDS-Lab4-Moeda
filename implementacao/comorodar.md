# Texto auxiliar

## Precisa ter instalado na maquina:

* php 8 > 
* composer
* nodejs

## Como instalar

Enter no projeto cd moeda-app
rode os seguintes comandos:

*composer install
*npm install

## Criando o banco
Necessário antes configurar o env e criar o schema do banco de dados

dentro da pasta moeda-app:

php artisan migrate

php artisan db:seed

para rodar: 

php -S localhost:8000 -t public

rodar o front end:

npm run dev

entre em localhost:8000 
e logue com joao@teste.com senha teste123