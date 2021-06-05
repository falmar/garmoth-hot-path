# Laravel Naive Docker Setup

## Setting up local domain

https://api.garmoth.local:3050

you can change port in `docker-compose.yaml` find the nginx service

```yaml
ports:
- 3050:443 # change 3050 to your preferred port
```

head to your system's equivalent of unix `/etc/hosts`... if you don't have done it already, add entry:

```text
# garmoth
127.0.0.1 garmoth.local api.garmoth.local
```

### HTTPS certs

It requires HTTPS in order to generate certificate head to `$ cd ./docker/certs` and execute `$ ./generate.sh` script will ask passphrases to generate the certificate, use any random thing


## Starting containers

At the laravel project root directory, run `docker-compose up -d` to start containers, if no problem arises should output something similar to:

```text
Creating network "laravel_net" with the default driver
Creating laravel_mysql_1 ... done
Creating laravel_redis_1 ... done
Creating laravel_php_1   ... done
Creating laravel_nginx_1 ... done
```

Open up laravel app https://api.garmoth.local:3050 or with the port you have assigned... 
