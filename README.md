# API Spec

## Register

Request :
- Method : POST
- Endpoint : `/api/register`
- Header :
    - Content-Type: application/json
    - Accept: application/json
- Body :

```json 
{
    "name" : "string",
    "email" : "string",
    "password" : "string"
}
```

Response :

```json 
{
    "code" : "integer",
    "message" : "string",
    "data" : {
        "id" : "integer,unique",
        "name" : "string",
        "email" : "string",
        "password" : "string",
        "createdAt" : "timestamp",
        "updatedAt" : "timestamp"
    }
}
```

## Login

Request :
- Method : POST
- Endpoint : `/api/login`
- Header :
    - Content-Type: application/json
    - Accept: application/json
- Body :

```json 
{
    "email" : "string",
    "password" : "string"
}
```

Response :

```json 
{
    "code" : "integer",
    "message" : "string",
    "data" : {
        "id" : "integer,unique",
        "name" : "string",
        "email" : "string",
        "password" : "string",
        "createdAt" : "timestamp",
        "updatedAt" : "timestamp"
    },
    "token" : "string"
}
```

## Authentication

All API below must use this authentication

Request :
- Header :
    - Bearer Token : "your token"

## Create Order

Request :
- Method : POST
- Endpoint : `/api/order`
- Header :
    - Content-Type: application/json
    - Accept: application/json
- Body :

```json 
{
    "quantity" : "integer",
}
```

Response :

```json 
{
    "code" : "integer",
    "message" : "string",
    "data" : {
         "id" : "integer, unique",
         "user_id" : "integer",
         "ticket_id" : "integer",
         "quantity" : "integer",
         "total_price" : "integer",
         "createdAt" : "timestamp",
         "updatedAt" : "timestamp"
     }
}
```

## Get Order

Request :
- Method : GET
- Endpoint : `/api/order/{order_id}`
- Header :
    - Accept: application/json

Response :

```json 
{
    "code" : "integer",
    "message" : "string",
    "data" : {
         "id" : "integer, unique",
         "user_id" : "integer",
         "ticket_id" : "integer",
         "quantity" : "integer",
         "total_price" : "integer",
         "createdAt" : "timestamp",
         "updatedAt" : "timestamp"
     }
}
```

## List Orders

Request :
- Method : GET
- Endpoint : `/api/order`
- Header :
    - Accept: application/json

Response :

```json 
{
    "code" : "integer",
    "message" : "string",
    "data" : [
        {
             "id" : "integer, unique",
             "user_id" : "integer",
             "ticket_id" : "integer",
             "quantity" : "integer",
             "total_price" : "integer",
             "createdAt" : "timestamp",
             "updatedAt" : "timestamp"
        },
        {
             "id" : "integer, unique",
             "user_id" : "integer",
             "ticket_id" : "integer",
             "quantity" : "integer",
             "total_price" : "integer",
             "createdAt" : "timestamp",
             "updatedAt" : "timestamp"
        }
    ]
}
```