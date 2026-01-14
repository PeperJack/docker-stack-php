# Stack PHP/MySQL/PhpMyAdmin Docker

Stack de développement complète avec :
- PHP 8.2-FPM
- MySQL 5.7
- Nginx
- PhpMyAdmin

## Installation
```bash
docker-compose up -d
```

## Accès

- Site web : http://localhost
- PhpMyAdmin : http://localhost:8081
  - User: root
  - Password: root

## Structure
```
.
├── docker-compose.yml
├── nginx.conf
└── www/
    └── index.php
```
