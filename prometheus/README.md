# Prometheus + Grafana setup for laravel app

> cd/move to this directory to execute docker commands

In order to test prom+graf is working correctly, setup the laravel project first

Everything here is pretty much already configured and done for testing the laravel app... see `laravel/docker/README.md` from that directory for setup

## Starting containers

In onder for Prometheus and Laravel app to communicate, a shared external docker network needed (once):

```bash
$ docker network create promoth
# if u see a hex hash (network id), it was created just fine 
```

At the prometheus project root directory, run `docker-compose up -d` to start containers, if no problem arises should output something similar to:

```text
Creating network "prometheus_net" with the default driver
Creating prometheus_grafana_1 ... done
Creating prometheus_prom_1    ... done
```

- Prometheus UI at http://localhost:3059 
- Grafana UI at http://localhost:3053

Ports can be changed at `docker-compose.yaml`

Grafana will prompt for user/password which is `admin/admin` and it will immediately ask to change the password.

----

## Moving to Production

This part acknowledges that production laravel app has the necessary dependencies in place to start exposing data...

Take look at `prometheus/prometheus.yaml` there are 2 scrape configs here, one for test and one for production, uncomment the production config

Now, you must create file `garmoth_prod` and add a secret key to it, which also must exist in prod laravel app, also uncomment the lines from `docker-compose.yaml` related to this key.

Can also remove the test scrape to stop pulling data from it.

I also recommend you edit the prometheus server's `/etc/hosts` and use private network IP (DO's VPC), so change garmoth.com to whatever you named the host in `/etc/hosts`
