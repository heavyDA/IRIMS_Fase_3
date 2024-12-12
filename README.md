## IRIMS Phase 3
-----------------

### 1. Pre Requisites
-----------------
1. Install [Laravel Herd] (https://herd.laravel.com)
2. Install [Mariadb 11.4.4 (LTS)] (https://mariadb.org/)
3. Install [Heidi SQL] (https://www.heidisql.com/) / [DBeaver] (https://dbeaver.io/)

### 2. Getting Started
-----------------
#### 2.1 Setting up the project
1. Install `Laravel Herd` with `PHP 8.3`, `Node 22`
2. Go to `Laravel Herd` Panel
3. Open Sites Button
4. Click on `+ Add` Button
5. Choose `Link existing project`
6. Enter the path to cloned repository
7. Set the `name` of the project
8. Check to use `https`
9. Voila, you can access the site on `https://{project_name}.test`

#### 2.2 Setting up the dependencies
1. Go to your project directory
2. Run `composer install`
3. Run `npm install`
4. Run `npm run dev`
5. Run `php artisan migrate --seed`