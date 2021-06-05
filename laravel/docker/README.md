# Laravel Naive Docker Setup

## Setting up local domain

http://api.garmoth.local:3050 or localhost:3050

you can change port in `docker-compose.yaml` find the nginx service

```yaml
ports:
- 3050:80 # change 3050 to your preferred port
```

head to your system's equivalent of unix `/etc/hosts`... if you don't have done it already, add entry:

```text
# garmoth
127.0.0.1 garmoth.local api.garmoth.local
```

## Starting containers

In onder for Prometheus and this Laravel app to communicate, a shared external docker network is needed:

```bash
$ docker network create promoth
# if u see a hex hash (network id), it was created just fine 
```

At the laravel project root directory, run `docker-compose up -d` to start containers, if no problem arises should output something similar to:

```text
Creating network "laravel_net" with the default driver
Creating laravel_mysql_1 ... done
Creating laravel_redis_1 ... done
Creating laravel_php_1   ... done
Creating laravel_nginx_1 ... done
```

Open up laravel app https://api.garmoth.local:3050 or with the port you have assigned... 

### Config .env

Just copy and paste .env.example into .env, after composer install maybe the `APP_KEY=` will be generated if not, use usual laravel command to generate key AFTER composer install

## php compose install

Now you will want to install the php dependencies, get inside the container as

```bash
$ docker ps

# you will see something like this:
# ......
bdef09482252   laravel_php    "docker-php-entrypoi…"   4 hours ago   Up 55 minutes   9000/tcp   laravel_php_1
# ......
# copy your "php" container name and "ssh" into it

$ docker exec -it laravel_php_1 sh
/usr/share/nginx/html #

# and run composer install
$ composer install
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
......
```
