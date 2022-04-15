FROM mysql:8.0.17

COPY ./deployment/my.cnf /etc/mysql/conf.d/custom.cnf
