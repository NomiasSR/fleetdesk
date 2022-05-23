# fleetdesk

Requisitos do sistema<br>
--------------------------------------------<br>
Mysql 5.7.31 ou superior;<br>
Node 12.16.3;<br>
npm 6.14.4 ou superior;<br>
Composer 2.0.8 ou superior;<br>
<br>
Configurações do banco de dados<br>
--------------------------------------------<br>
Instalar o mysql, criar usuário 'root' com senha 'root';<br>
Cerificar se está rodando na porta 3306;<br>
Criar schema com o nome 'fleetdesk', CHARSET 'utf8' e Collation 'utf8_general_ci';<br>
<br>
Configurações da aplicação<br>
--------------------------------------------<br>
Criar diretório fleetdesk na raiz do sistema;<br>
Faça clone do projeto fleetdesk:<br>
	git clone https://github.com/NomiasSR/fleetdesk.git<br>
<br>
Etapas backend<br>
--------------------------------------------<br>
Entre no diretório 'backend';<br>
Execute os comandos na ordem para criar o banco de dados e demais configurações do backend:<br>
composer install;<br>
cp .env.example .env<br>
php artisan key:generate --ansi;<br>
php artisan jwt:secret;<br>
php artisan cache:clear;<br>
php artisan config:clear;<br>
composer dump-autoload;<br>
php artisan migrate:fresh;<br>
php artisan db:seed --class=UserSeeder;<br>
php artisan db:seed --class=StatusSeeder;<br>
php artisan db:seed --class=TasksSeeder;<br>
<br>
Etapas frontend<br>
--------------------------------------------<br>
Vá para o diretório 'frontend';<br>
Execute o comando npm install;<br>
<br>
SUBINDO SERVIDORES<br>
--------------------------------------------<br>
Para subir o servidor php com o Laravel, execute na linha de comando (prompt): php artisan serve<br>
Para subir o servidor node, execute na linha comando (prompt): npm run serve<br>
<br>	
API de acesso<br>
--------------------------------------------<br>
As seguintes rotas estão disponíveis para teste via API:<br>
<br>	
Rotas de acesso para login, logout, token<br>
--------------------------<br>
POST localhost:8000/api/register - form-data: name, email, password, password_confirmation<br>
POST localhost:8000/api/login - form-data: email, password<br>
POST localhost:8000/api/refresh - Authorization Bearer Token<br>
POST localhost:8000/api/logout - Authorization Bearer Token<br>
<br>
Rotas de acesso do módulo de STATUS<br>
--------------------------<br>
Logar na api para obter um JWT token;<br>
Passar o token como parametro de pesquisa (Authorization Bearer Token);<br>
GET localhost:8000/api/status<br>
GET localhost:8000/api/status?id=2<br>
GET localhost:8000/api/status?descricao=aberto<br>
DELETE localhost:8000/api/status/id<br>
POST localhost:8000/api/status - form-data: descricao, observacao<br>
PUT localhost:8000/api/status - x-www-form-urlencoded: descricao, observacao<br>
<br>
Rotas de acesso do módulo de TAREFAS (TASKS)<br>
---------------------------<br>
Logar na api para obter um JWT token;<br>
Passar o token como parametro de pesquisa (Authorization Bearer Token);<br>
GET localhost:8000/api/tasks<br>
GET localhost:8000/api/tasks?id=2<br>
GET localhost:8000/api/tasks?descricao=aberto<br>
GET localhost:8000/api/tasks?id_status=3 (status da tarefa - ABERTO, FECHADO, ETC)<br>
DELETE localhost:8000/api/tasks/id<br>
POST localhost:8000/api/tasks - form-data: descricao, observacao<br>
PUT localhost:8000/api/tasks - x-www-form-urlencoded: descricao, observacao, id_status<br>
  
  
