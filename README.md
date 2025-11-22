# Projeto Estacionamento

Este projeto foi feito para controlar a entrada e saída de veículos e calcular o valor a pagar de acordo com o tempo que o veículo ficou no estacionamento.  
Também existe um relatório simples mostrando o total de cada tipo de veículo e o faturamento.

## Requisitos

- PHP 8 ou superior
- SQLite (já incluso no PHP em geral)
- Composer

## Como instalar

1. Baixe ou clone o projeto.
2. Abra a pasta do projeto no terminal.
3. Rode o comando:

composer install

bash
Copiar código

Isso vai instalar o autoload do Composer.

## Criar o banco de dados

O banco é um arquivo SQLite.  
Para criar ele, basta rodar o arquivo SQL que está na pasta `Infra/Database`.

No terminal:

sqlite3 parking.db < Infra/Database/migrate.sql

perl
Copiar código

Ou você pode só abrir o SQLite e colar o conteúdo do arquivo `migrate.sql`.

O arquivo `parking.db` precisa ficar na pasta `Infra/Database` (igual no código).

## Como executar o projeto

Basta iniciar um servidor PHP dentro da pasta do projeto:

php -S localhost:8080

yaml
Copiar código

Depois abra o navegador:

http://localhost:8080/index.php

markdown
Copiar código

## Como usar

### Entrada de veículo
- Informar a placa
- Escolher o tipo
- Clicar em "Registrar Entrada"

### Saída de veículo
- Informar a placa
- Clicar em "Registrar Saída"
- O sistema mostra o valor a pagar

### Relatório
- Clique em “Ver relatório”
- Será exibida uma tabela com:
  - tipo do veículo
  - quantidade
  - faturamento total

## Estrutura básica

- `index.php` → tela principal e rotas simples
- `Application/` → controllers e services
- `Domain/` → entidades, enums e repositórios
- `Infra/` → banco de dados e pasta http
- `vendor/` → gerado pelo Composer

## Observações

O projeto usa apenas PHP puro, sem framework.  
Todo o cálculo e regras estão nos arquivos da pasta `Application` e `Domain`.