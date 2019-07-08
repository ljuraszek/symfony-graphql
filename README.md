# Symfony GraphQL test app

## How to run

1. Clone repo
2. Copy .env to .env.local
3. Setup db credentials in .env.local
4. run composer install
5. run bin/console doctrine:database:create (if db was not already created)
6. run bin/console doctrine:migrations:migrate
7. run bin/console hautelook:fixtures:load
8. have fun

