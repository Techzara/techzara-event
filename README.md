# symfony-sample

**Installation setup**

```
git clone this_repository
cd this_repository
composer install --prefer-dist
```
Edit database configuration in .env file

Then :
```
php bin/console doctrine:migrations:migrate
```
Run webserver

```
php bin/console server:run
```
