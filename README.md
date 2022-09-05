<h1 align="center">API - Receitas</h1>

<p align="center">O objetivo dessa API é criar uma aplicação capaz de criar, editar, atualizar e deletar receitas inseridas no banco de dados, similar à um site de receitas.</p>

<h4 align="center"> 
	API atualmente em desenvolvimento...
</h4>

## Features

- [x] Registro e login de usuários com token de segurança
- [x] Cadastro de receita
- [x] Cadastro de ingredientes
- [x] Listagem de ingredientes
- [x] Listagem de receitas
- [x] Exclusão de receitas/ingredientes

## Pré-requisitos

Antes de começar você vai precisar ter instalado em sua máquina as seguintes ferramentas:
- Composer - versão 2+
- PHP - versão 7.4+
- Laravel - versão 8+
- MYSQL - versão 5.8+
- Um editor de códigos (VSCode) ou IDE (PHPStorm)
- Plataforma para testar API's (Postman)

Ou utilize um ambiente de desenvolvimento que contenha maior parte das ferramentas utilizadas:
- Laragon
- XAMPP
- WAMP 

## Como rodar a aplicação

- Na pasta raíz da sua aplicação execute o comando: composer install
- Em seguida inicie um servidor de desenvolvimento de testes local através da ferramenta do Laravel (Artisan) com o comando: php artisan serve
- Vá até o Postman e inicie uma nova guia com o protocolo desejado:

# Rotas 

## Login / Register

POST:
- localhost/api/register (Para cadastrar um novo usuário e ter acesso às funcionalidades da aplicação) 
* Dados requeridos: name, email, password

- localhost/api/login (Para autenticar usuário existente no banco de dados e receber acesso aos métodos)

## Ingredientes

POST:
- Tipo: string
- localhost/api/ingredient (Se quiser cadastrar um novo ingrediente)


GET:
- Tipo: string
- localhost/api/ingredient/id (Para buscar um ingrediente armazenado no banco de dados)
- localhost/api/ingredients (Para buscar todos os ingredientes armazenados no banco de dados)

DELETE:
- Tipo: integer
- localhost/api/ingredient/id (Para excluir um ingrediente do banco de dados)

## Receitas

POST:
- Tipo: string
- localhost/api/recipe (Para cadastrar uma nova receita no banco)

GET:
- Tipo: integer
- localhost/api/recipes (Para buscar todas as receitas cadastradas no banco de dados)
- localhost/api/recipe/id (Para buscar uma receita cadastrada no banco de dados)
- localhost/api/recipes/list (Para listar as receitas cadastradas no banco através do input de ingredientes fornecido)

PUT:
- Tipo: integer
- localhost/api/recipe/id (Para editar uma receita existente)

DELETE:
- Tipo: integer
- localhost/api/recipe/id (Para excluir uma receita do banco de dados)

# Ou: Utilize minha collection no Postman

Localizado na raíz do projeto App\Vendor
- APIWeb.postman_collection.json

# Autor: [Breno Stacheski](https://github.com/BrenoStacheski)

