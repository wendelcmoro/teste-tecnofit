# teste-tecnofit

Teste Tecnofit


# Conteúdos

1. [Requisitos](#Requisitos)<br>
2. [Execução Padrão do projeto](#Execução-Padrão-do-projeto)<br>
   2.1 [Instalando Dependências e configurando variáveis de ambiente](##Instalando-Dependências-e-configurando-variáveis-de-ambiente)<br>
   2.2 [Iniciando o projeto](##Iniciando-o-projeto)<br>
   2.3 [Rotas](##Rotas)<br>

## 1 Requisitos

- PHP 8
- Composer  2.7.7

# 2. Execução Padrão do projeto

## 2.1 Instalando Dependências e configurando variáveis de ambiente

Para começarmos, precisamos instalar as dependências com o **composer**:

```console
composer i
```

Após isso, precisamos configurar as variáveis de ambiente copiando o arquivo de exemplo:

```console
cp .env.example .env
```

Em seguida, precisamos configurar as variáveis de acesso ao banco de dados conforme a seguir:

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=teste-tecnofit
- DB_USERNAME=root
- DB_PASSWORD=root

As variáveis aqui definidas foram utilizadas como exemplo, então ao configurar o seu ambiente local você pode utilizar as configurações acima ou de sua escolha.

## 2.2 Iniciando o projeto

O projeto foi construído com o uso do **Swagger**, opcionalmente podemos gerar nossa documentação para acesso:

```console
php artisan l5-swagger:generate
```

Por fim, vamos executar o projeto localmente a partir do comando à seguir:

```console
php artisan serve
```

Agora nosso projeto é acessável da através da url:  
 - http://localhost:8000 
 
 Opcionalmente você pode acessar a página com a documentação do swagger da API do projeto com:  
 - http://localhost:8000/api/documentation

## 2.3 Rotas

Ao executar projeto, as seguintes rotas da **API** estarão disponíveis:

-

Mais detalhes das rotas podem ser encontradas na documentação do swagger.