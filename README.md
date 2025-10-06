# jb-hardware-enterprise

```bash
# set up .env variables
cp .env.example .env

# change each .env variable to use your app name
APP_NAME="Web App Name"
DB_HOST=web-app-name-mysql # web-app-name must be your repository name
DB_DATABASE=web_app_name

# install composer dependencies
composer install

# update .env with Laravel Sail's variables
php artisan sail:install

# if using Docker Desktop on Linux, run `docker context use default`

# run Docker containers in background
docker compose down --volumes
docker compose up -d

# check running containers
docker ps

docker exec -it web-app-name-mysql mysql -u root -p

# if prompted for a password, enter password 'password' (without quotes)
# create mysql user
create user 'root'@'172.19.0.7' identified by 'password';

# grant all permissions to root user
grant all on *.* to 'root'@'172.19.0.7';
grant all privileges on *.* to 'root'@'172.19.0.7' with grant option;

# create project database
# !!! replace web_app_name with the name of your web app
create database web_app_name character set utf8mb4 collate utf8mb4_unicode_ci;
exit;

# open terminal inside app container
# !!! replace web-app-name with the name of your web app
docker exec -ti web-app-name-laravel bash

# install npm dependencies
npm install

# generate encryption key
php artisan key:generate

# precompile configs for performance
php artisan optimize

# run database migrations
# if this returns an error on user 'sail', edit .env and use DB_USER=root
php artisan migrate --seed

# start development server
npm run dev

# To process queue, for first time setup:
.env
- QUEUE_CONNECTIONS= database

- php artisan optimize
- sudo apt install supervisor
- cd /etc/supervisor/conf.d
- vim laravel-worker.conf

# Put it in the file
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=/usr/bin/php /var/www/html/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/worker.log
stopwaitsecs=1


- sudo supervisorctl reread

- sudo supervisorctl update

- sudo supervisorctl start "laravel-worker:*"
