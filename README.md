Just a simple rabbitmq project for learning and testing.

## How to run it?

- composer install
- copy .env.example .env
- set .env, e.g.:
    - RABBITMQ_HOST=127.0.0.1
    - RABBITMQ_PORT=5672
    - RABBITMQ_USER=user
    - RABBITMQ_PASSWORD=password
    - RABBITMQ_VHOST=vhost
    - RABBITMQ_MANAGEMENT_PORT=15672
- run docker: docker compose up -d --build
- generate run.bat file: php generate_bat_file.php
- run: run.bat

---
Visit my website

[adrianp.pl](https://adrianp.pl/)
