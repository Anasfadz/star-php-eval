# Star Media Group — Localhost Setup & Run Guide

Instructions to set up and serve this Laravel application on `localhost`.

## Prerequisites
- **PHP 8.5+**
- **Composer 2.x**
- **Node.js & npm** (for building Tailwind CSS / Vite assets)

## 1. Install Dependencies
```sh
composer install
npm install
```

## 2. Environment Configuration
Copy the example environment file and generate the application key:
```sh
cp .env.example .env
php artisan key:generate
```

### Database Option A: SQLite (default in `.env.example`)
Create the SQLite database file if it does not exist:
```sh
touch database/database.sqlite
```

### Database Option B: MySQL
Update your `.env` with your MySQL credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=start_practice
DB_USERNAME=root
DB_PASSWORD=
```

## 3. Run Migrations & Seed the Database
Run all migrations and populate sample data (5 categories, 20 articles with sample thumbnails downloaded to `storage/app/article/{id}/`, and 1 admin user):
```sh
php artisan migrate --seed
```

## 4. Build Frontend Assets
Build the Vite assets (Tailwind CSS + shadcn/ui styles + SweetAlert2):
```sh
npm run build
```

## 5. Serve on Localhost
Start the Laravel development server:
```sh
php artisan serve
```

Your application will be available at:
- **Public Landing / Article List:** `http://127.0.0.1:8000`
- **Article Detail Page:** `http://127.0.0.1:8000/articles/{permalink}` (increments `click_count` on each visit)
- **JSON API Endpoint:** `http://127.0.0.1:8000/api/articles`
- **Login:** `http://127.0.0.1:8000/login`
- **Dashboard (Authenticated):** `http://127.0.0.1:8000/dashboard` (create, edit, and delete articles, thumbnails, and categories)

*(Optional)* To run the PHP server, queue worker, and Vite dev server together with hot reload:
```sh
composer run dev
```

## 6. Run Tests
```sh
php artisan test
```

## Note
I have enhancement on my side at branch `enhancement`. Use credentials `admin@admin.com` / `12345` to create, edit, and delete categories and articles.

- the enhancement i made is auth login, logout, register.
- on authenticated session user can access dashboard to create, edit, and delete categories and articles.
- each article has click count.
- each article has a thumbnail image.
