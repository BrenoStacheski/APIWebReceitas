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

- Copie o arquivo `.env.example` e o renomeie para `.env`
- Crie um banco MYSQL com o nome `apiweb` e adicione como variável de ambiente no arquivo `.env`
- Na pasta raíz da sua aplicação execute o comando: `composer install`
- Em seguida inicie um servidor de desenvolvimento local através do comando: `php artisan serve`
- Vá até o Postman e inicie uma nova guia com o protocolo desejado

# Rotas 

## Login / Register

POST:
- localhost/api/register (Para cadastrar um novo usuário e ter acesso às funcionalidades da aplicação) 
- Body:
```
{
    "name": "Breno Stacheski",
    "email": "brenostc@teste5.com",
    "password": "123456"
}
```

- localhost/api/login (Para autenticar usuário existente no banco de dados e receber acesso aos métodos)
- Body:
```
{
    "email": "brenostc@teste5.com",
    "password": "123456"
}
```

## Ingredientes

POST:
- localhost/api/ingredient (Se quiser cadastrar um novo ingrediente)
- Body:
```
{
    "name": "SAL"
}
```


GET:
- Tipo: string
- localhost/api/ingredient/id (Para buscar um ingrediente armazenado no banco de dados)
- localhost/api/ingredients (Para buscar todos os ingredientes armazenados no banco de dados)

DELETE:
- Tipo: integer
- localhost/api/ingredient/id (Para excluir um ingrediente do banco de dados)

## Receitas

POST:
- localhost/api/recipe (Para cadastrar uma nova receita no banco)
- Body:

```
{
    "name": "BOLO DE FUBÁ",
    "preparation_mode": "BATA A MASSA POR 6 MINUTOS E LEVE ATÉ O FORNO PRÉ-AQUECIDO POR 35 MINUTOS EM FOGO MÉDIO (180C)",
    "time": "5",
    "ingredients": [
        "AÇUCAR",
        "OVO",
        "OLEO",
        "FARINHA",
        "MANTEIGA"
    ]
}
```

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

Localizado na raíz do projeto pelo arquivo `APIWeb.postman_collection.json`

# Autor: [Breno Stacheski](https://github.com/BrenoStacheski)

