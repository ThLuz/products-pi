# Products API (Laravel)

API REST desenvolvida em **Laravel** para consumir uma API externa de produtos, armazenar os dados localmente e disponibilizar endpoints com filtros, regras de negócio e controle de consistência.

---

# Tecnologias utilizadas

* PHP
* Laravel
* MySQL
* HTTP Client (Laravel)
* API Resources
* FormRequest
* DTO Pattern
* Service Layer

---

# Funcionalidades

* Importação de produtos de API externa
* Armazenamento local dos produtos
* Atualização automática caso o produto já exista
* Endpoint idempotente
* Filtros combináveis
* Paginação
* Ordenação
* Estatísticas
* Soft Delete
* Controle de integridade de dados

---

# API externa utilizada

```
https://fakestoreapi.com/products
```

---

# Estrutura da aplicação

A aplicação utiliza separação de responsabilidades seguindo boas práticas do Laravel.

```
app
 ├── DTO
 │    └── ProductDTO.php
 │
 ├── Http
 │    ├── Controllers
 │    │     ├── ProductController.php
 │    │     ├── ImportProductsController.php
 │    │     └── StatisticsController.php
 │    │
 │    ├── Requests
 │    │     └── UpdateProductRequest.php
 │    │
 │    └── Resources
 │          └── ProductResource.php
 │
 ├── Models
 │     └── Product.php
 │
 └── Services
       ├── ProductService.php
       └── ProductImportService.php
```

---

# Instalação do projeto

### 1 - Clonar repositório

```
git clone https://github.com/ThLuz/products-api
```

Entrar na pasta do projeto:

```
cd products-api
```

---

### 2 - Instalar dependências

```
composer install
```

---

### 3 - Criar arquivo de ambiente

```
cp .env.example .env
```

---

### 4 - Gerar chave da aplicação

```
php artisan key:generate
```

---

### 5 - Configurar banco de dados

Editar o arquivo `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=products_api
DB_USERNAME=root
DB_PASSWORD=
```

Criar o banco:

```
products_api
```

---

### 6 - Rodar migrations

```
php artisan migrate
```

Isso criará a tabela `products`.

---

# Estrutura da tabela

Tabela: `products`

Campos:

| Campo        | Tipo             |
| ------------ | ---------------- |
| id           | bigint           |
| external_id  | integer (unique) |
| title        | string           |
| price        | decimal          |
| description  | text             |
| category     | string           |
| image        | string           |
| rating_rate  | decimal          |
| rating_count | integer          |
| update_log   | json nullable    |
| created_at   | timestamp        |
| updated_at   | timestamp        |
| deleted_at   | timestamp        |

---

# Rodar aplicação

```
php artisan serve
```

Servidor ficará disponível em:

```
http://localhost:8000
```

---

# Endpoints da API

Base URL

```
http://localhost:8000/api
```

---

# 1 - Importar produtos da API externa

Endpoint

```
POST /api/products/import
```

Descrição:

* Consome a API externa
* Salva produtos localmente
* Atualiza caso já existam
* Não duplica `external_id`
* Endpoint idempotente

Resposta exemplo:

```json
{
  "imported": 20,
  "updated": 0,
  "skipped": 0
}
```

---

# 2 - Listar produtos

Endpoint

```
GET /api/products
```

Filtros opcionais

| Parâmetro  | Descrição                               |
| ---------- | --------------------------------------- |
| price_min  | preço mínimo                            |
| price_max  | preço máximo                            |
| category   | categoria                               |
| search     | busca parcial no título                 |
| rating_min | rating mínimo                           |
| sort       | ordenar por price, title ou rating_rate |
| per_page   | tamanho da página (máx 100)             |

Exemplo:

```
GET /api/products?price_min=50&rating_min=4
```

---

# 3 - Detalhe de produto

Endpoint

```
GET /api/products/{id}
```

Retorna:

* dados do produto
* campo calculado `price_with_tax` (10%)

Resposta exemplo

```json
{
  "id": 1,
  "title": "Product name",
  "price": 100,
  "price_with_tax": 110,
  "category": "electronics",
  "rating_rate": 4.5
}
```

---

# 4 - Atualização parcial

Endpoint

```
PATCH /api/products/{id}
```

Campos permitidos:

* title
* price
* category

Exemplo RAW JSON

```json
{
  "title": "New product name",
  "price": 200
}
```

A alteração será registrada no campo:

```
update_log
```

---

# 5 - Remover produto

Endpoint

```
DELETE /api/products/{id}
```

Regras:

* Soft delete
* Não permite remover produto com rating maior que **4.5**
* Registra motivo da remoção

RAW JSON

```json
{
  "reason": "product discontinued"
}
```

---

# 6 - Estatísticas

Endpoint

```
GET /api/statistics
```

Retorna:

* total_products
* average_price
* highest_price
* lowest_price
* categories_count

Exemplo:

```json
{
  "total_products": 20,
  "average_price": 162.04,
  "highest_price": 999.99,
  "lowest_price": 7.95,
  "categories_count": [
    {
      "category": "electronics",
      "total": 6
    }
  ]
}
```

---

# Robustez implementada

* tratamento de falha da API externa
* retry automático nas requisições HTTP
* logs de erro de integração
* endpoint de importação idempotente
* controle de duplicidade por `external_id`

---

# Requisitos técnicos atendidos

* FormRequest
* DTO
* Migration
* Model
* API Resources
* Service Layer
* Soft Delete
* Logs de alteração
* Índices para consultas
* Filtros combinados
* Paginação

---

# Autor
Thiago Luz - 
Projeto desenvolvido como teste técnico backend em Laravel.
