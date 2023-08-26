<h1>CRUD WEB criado para um projeto de faculdade</h1> <br/>
<h3>Requerimentos:</h3><hr/>

<p>Necessario instalar laragon/xampp ou php >= 8.1</p>
<p>Instalar docker e docker compose ou se estiver no windows o docker desktop</p>
<p>Editar o arquivo .env e ajustar a env URL</p>
<p>Editar o arquivo docker-compose.yml e ajustar os caminhos dos volumes conforme criado em sua maquina</p>

Rodar o comando ```docker compose -f docker-compose.yml up -d ``` para subir o banco de dados

<p>Criar o banco de dados com o nome ecommerce e criar o schema crudweb</p>

Rodar o comando ```composer install ``` para instalar as dependencias

Rodar o comnado ```php bin/doctrine.php orm:generate-proxies ``` para gerar os proxies das entidades

Rodar o comando ```php .\vendor\bin\doctrine-migrations m:migrate ``` para rodar as migrations
