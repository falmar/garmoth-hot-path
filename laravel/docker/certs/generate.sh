#!/bin/bash

openssl genrsa -des3 -out ./rootCA.key 2048
openssl req -x509 -new -nodes -key ./rootCA.key -sha256 -days 365 -out ./rootCA.pem -config <( cat ./config/server.cnf )

openssl req -new -sha256 -nodes -out ./server.csr -newkey rsa:2048 -keyout ./key.pem -config <( cat ./config/server.cnf )
openssl x509 -req -in ./server.csr -CA ./rootCA.pem -CAkey ./rootCA.key -CAcreateserial -out ./cert.pem -days 500 -sha256 -extfile ./config/v3.cnf -CAserial ./ca.srl
