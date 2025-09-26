# API de Gerenciamento de Clientes

Uma API RESTful construída com Laravel para cadastro e gerenciamento de clientes, incluindo informações de endereço.

## Sobre o Projeto

Esta é uma API baseada em Laravel que permite registrar clientes com seus endereços associados e recuperar informações dos clientes. A API implementa validação adequada, transações de banco de dados e segue as melhores práticas do Laravel.

### Funcionalidades

- Cadastro de clientes com informações completas
- Gerenciamento de endereços (um endereço por cliente)
- Validação de unicidade do CNPJ
- Validação de entrada com mensagens de erro detalhadas
- Transações de banco de dados para integridade dos dados
- Endpoints RESTful com respostas JSON

## Instalação

### Pré-requisitos

- PHP >= 8.2
- Composer
- SQLite (ou outro banco de dados)
- Git

### Passos

1. Clone o repositório:
```bash
git clone <repository-url>
cd jhe-test
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o arquivo de ambiente:
```bash
cp .env.example .env
```

4. Gere a chave da aplicação:
```bash
php artisan key:generate
```

5. Execute as migrações do banco de dados:
```bash
php artisan migrate
```

## Como Executar

Inicie o servidor de desenvolvimento do Laravel:

```bash
php artisan serve
```

A API estará disponível em `http://127.0.0.1:8000`

## Endpoints da API

### Criar Cliente
**POST** `/api/clientes`

Cria um novo cliente com informações de endereço.

#### Corpo da Requisição:
```json
{
  "name": "João Silva",
  "email": "joao@email.com",
  "cnpj": "12.345.678/0001-90",
  "observation": "Cliente premium",
  "contract_value": 5000.50,
  "address": {
    "street": "Rua das Flores",
    "number": "123",
    "postal_code": "12345-678",
    "complement": "Apto 101",
    "neighborhood": "Centro",
    "city": "São Paulo"
  }
}
```

#### Resposta (201):
```json
{
  "success": true,
  "message": "Cliente criado com sucesso",
  "data": {
    "id": 1,
    "name": "João Silva",
    "email": "joao@email.com",
    "cnpj": "12.345.678/0001-90",
    "observation": "Cliente premium",
    "contract_value": "5000.50",
    "created_at": "2025-09-25T21:36:21.000000Z",
    "updated_at": "2025-09-25T21:36:21.000000Z",
    "address": {
      "id": 1,
      "street": "Rua das Flores",
      "number": "123",
      "postal_code": "12345-678",
      "complement": "Apto 101",
      "neighborhood": "Centro",
      "city": "São Paulo",
      "client_id": 1,
      "created_at": "2025-09-25T21:36:21.000000Z",
      "updated_at": "2025-09-25T21:36:21.000000Z"
    }
  }
}
```

### Buscar Todos os Clientes
**GET** `/api/clientes`

Recupera todos os clientes cadastrados com seus endereços.

#### Resposta (200):
```json
{
  "success": true,
  "message": "Clientes recuperados com sucesso",
  "data": [
    {
      "id": 1,
      "name": "João Silva",
      "email": "joao@email.com",
      "cnpj": "12.345.678/0001-90",
      "observation": "Cliente premium",
      "contract_value": "5000.50",
      "created_at": "2025-09-25T21:36:21.000000Z",
      "updated_at": "2025-09-25T21:36:21.000000Z",
      "address": {
        "id": 1,
        "street": "Rua das Flores",
        "number": "123",
        "postal_code": "12345-678",
        "complement": "Apto 101",
        "neighborhood": "Centro",
        "city": "São Paulo",
        "client_id": 1,
        "created_at": "2025-09-25T21:36:21.000000Z",
        "updated_at": "2025-09-25T21:36:21.000000Z"
      }
    }
  ]
}
```

## Requisitos dos Campos

### Campos do Cliente
- **name**: Obrigatório, string, máximo 255 caracteres
- **email**: Obrigatório, formato de email válido, máximo 255 caracteres
- **cnpj**: Obrigatório, string, único entre todos os clientes
- **observation**: Opcional, texto
- **contract_value**: Obrigatório, numérico, mínimo 0

### Campos do Endereço
- **street**: Obrigatório, string, máximo 255 caracteres
- **number**: Obrigatório, string, máximo 255 caracteres
- **postal_code**: Obrigatório, string, máximo 255 caracteres
- **complement**: Opcional, string, máximo 255 caracteres
- **neighborhood**: Obrigatório, string, máximo 255 caracteres
- **city**: Obrigatório, string, máximo 255 caracteres

## Respostas de Erro

### Erro de Validação (422):
```json
{
  "success": false,
  "message": "Erros de validação",
  "errors": {
    "cnpj": ["O cnpj já foi utilizado."]
  }
}
```

### Erro do Servidor (500):
```json
{
  "success": false,
  "message": "Erro ao criar cliente",
  "error": "Falha na conexão com o banco de dados"
}
```

## Exemplos de Teste

### Usando cURL

Criar um cliente:
```bash
curl -X POST http://127.0.0.1:8000/api/clientes \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Cliente Teste",
    "email": "teste@exemplo.com",
    "cnpj": "11.111.111/0001-11",
    "contract_value": 1000.00,
    "address": {
      "street": "Rua Teste",
      "number": "123",
      "postal_code": "12345-678",
      "neighborhood": "Bairro Teste",
      "city": "Cidade Teste"
    }
  }'
```

Buscar todos os clientes:
```bash
curl -X GET http://127.0.0.1:8000/api/clientes \
  -H "Accept: application/json"
```

## Estrutura do Banco de Dados

A API utiliza duas tabelas principais:

- **clients**: Armazena informações dos clientes
- **addresses**: Armazena informações de endereços com chave estrangeira para clientes

O relacionamento é um-para-um: cada cliente tem exatamente um endereço.

## Licença

Este projeto é um software de código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).