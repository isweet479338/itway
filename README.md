# Laravel Basic Auth Starter

A Laravel starter project with basic authentication using Laravel UI, Bootstrap (or Vue/React), and front-end asset compilation via NPM.

---

## 🚀 Features

- Laravel 10+ (or compatible version)
- Laravel UI Authentication (Login, Register, Password Reset)
- Bootstrap (or optionally Vue/React)
- NPM + Laravel Mix for asset compilation

---

## 🛠️ Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL or another supported database

---

## ⚙️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Set Up Environment File

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with database credentials:

```env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Install Laravel UI Auth

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
# or use: php artisan ui vue --auth
# or: php artisan ui react --auth
```

### 6. Install NPM Dependencies

```bash
npm install
npm run dev
```

---

## 🧪 Run the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 📦 Build for Production

```bash
npm run build
```

---

## 🧾 License

This project is open-source and available under the [MIT license](LICENSE).
