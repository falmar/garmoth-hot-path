# DigitalOcean server config

Not much...

A clean Ubuntu droplet is enough, you can [install docker](https://docs.docker.com/engine/install/ubuntu/) and ready to go

The installations does not come with SSL by default, you can install a reverse proxy with SSL to point into grafana's port and add network firewalls to only allow the reverse proxy to be exposed

or if you already have a digital ocean load balancer with SSL use that...
