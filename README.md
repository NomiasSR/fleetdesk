# fleetdesk

Requisitos do sistema
----------------------
Mysql 5.7.31 ou superior;
Node 12.16.3;
npm 6.14.4 ou superior;
Composer 2.0.8 ou superior;


Configurações do banco de dados
-------------------------------
Instalar o mysql, criar usuário 'root' com senha 'root';
Cerificar se está rodando na porta 3306;
Criar schema com o nome 'fleetdesk', CHARSET 'utf8' e Collation 'utf8_general_ci';


Configurações da aplicação
-----------------------------
Criar diretório fleetdesk na raiz do sistema;
Faça clone do projeto fleetdesk:
	git clone https://github.com/NomiasSR/fleetdesk.git
Entre no diretório 'backend';
Execute os comandos na ordem para criar o banco de dados e demais 
configurações do backend:
	composer install;
	cp .env.example .env
	php artisan key:generate --ansi;
	php artisan jwt:secret;
	php artisan cache:clear;
	php artisan config:clear;
	composer dump-autoload;
	php artisan migrate:fresh;
	php artisan db:seed --class=UserSeeder;
	php artisan db:seed --class=StatusSeeder;
	php artisan db:seed --class=TasksSeeder;
	
Vá para o diretório 'frontend';
Execute o comando npm install;

Para subir o servidor php com o Laravel, use o comando: php artisan serve
Para subir o servidor node, use o comando: npm run serve	
	
	
As seguintes rotas estão disponíveis para teste via API:	
	
	Rotas de acesso para login, logout, token
	--------------------------------------------
	POST localhost:8000/api/register -	name, email, password, password_confirmation
	POST localhost:8000/api/login - email, password
	POST localhost:8000/api/refresh - Authorization Bearer Token
	POST localhost:8000/api/logout - Authorization Bearer Token


	Rotas de acesso do módulo de STATUS
	--------------------------------------------
	- Logar na api para obter um JWT token;
	- Passar o token como parametro de pesquisa (Authorization Bearer Token);
	GET localhost:8000/api/status
	GET localhost:8000/api/status?id=2
	GET localhost:8000/api/status?descricao=aberto
	
	DELETE localhost:8000/api/status/id	
	POST localhost:8000/api/status - form-data: descricao, observacao
	PUT localhost:8000/api/status - x-www-form-urlencoded: descricao, observacao
	
	
	Rotas de acesso do módulo de TAREFAS (TASKS)
	--------------------------------------------
	- Logar na api para obter um JWT token;
	- Passar o token como parametro de pesquisa (Authorization Bearer Token);
	GET localhost:8000/api/tasks
	GET localhost:8000/api/tasks?id=2
	GET localhost:8000/api/tasks?descricao=aberto
	GET localhost:8000/api/tasks?id_status=3 (status da tarefa - ABERTO, FECHADO, ETC)
	
	DELETE localhost:8000/api/tasks/id	
	POST localhost:8000/api/tasks - form-data: descricao, observacao
	PUT localhost:8000/api/tasks - x-www-form-urlencoded: descricao, observacao, id_status
  
  
