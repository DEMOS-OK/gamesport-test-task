```bash
# 1 Можно запустить с дефолтным конфигом nginx и добавить запись в /etc/hosts
sudo -e /etc/hosts # для MacOS и Linux
# C:\Windows\System32\drivers\etc\hosts - для Windows
# добавить строку 127.0.0.1    gstt.test

# Либо скорректировать/создать конфиг под себя в .docker/nginx/conf.d

# 2
docker-compose up -d

# 3 Зайти в контейнер. Следующие действия будут выполняться внутри контейнера
docker-compose exec gstt-fpm bash

# 4
cp .env.example .env
# Можно скорректировать .env под себя

# 3
php artisan key:generate
php artisan migrate
php artisan db:seed
# Авторизоваться можно под сгенерированным юзером
# test@example.com
# password
# он уже идёт с датой регистрации более 10 дней.

# 4
npm i
npm run build

# 5 запуск воркера очередей
php artisan queue:work

# можно тестировать
```