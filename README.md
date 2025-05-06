# TLYN – Online Gold Trading Backend

TLYN is a backend project developed for **TLYN**, an innovative company focused on the online trading of **melted gold**. The system enables users to securely manage their gold transactions, place buy/sell orders, and monitor their wallet balances in real-time.

---

## 🔧 Tech Stack

* **Framework**: Laravel 11
* **PHP**: ^8.2
* **Database**: MySQL
* **Queue System**: Laravel Queue
* **Dockerized**: Yes (via `docker-compose.yml`)
* **Authentication**: Custom (FakeAuthMiddleware)
* **Testing**: Feature
---

## 🤖 CI/CD Configuration

This project includes a CI pipeline defined in the ci.yml file for GitHub Actions. The pipeline automates the following tasks:

1.Environment Setup: Sets up the testing environment, including the required services like MySQL.

2.Dependency Installation: Installs PHP dependencies using Composer.

3.Database Setup: Configures the database connection and runs migrations.

4.Caching: Caches Composer dependencies to speed up subsequent builds.

5.Tests: Runs tests to ensure that the application works as expected.

This ensures continuous integration for consistent and reliable builds 

---


## 📁 Directory Structure

```
└── amirmahdi-for-tlyn/
    ├── README.md
    ├── artisan
    ├── composer.json
    ├── composer.lock
    ├── docker-compose.yml
    ├── dockerfile
    ├── nginx.conf
    ├── package.json
    ├── phpunit.xml
    ├── postcss.config.js
    ├── tailwind.config.js
    ├── vite.config.js
    ├── .editorconfig
    ├── .env.example
    ├── app/
    │   ├── Exceptions/
    │   │   └── InsufficientBalanceException.php
    │   ├── Http/
    │   │   ├── Kernel.php
    │   │   ├── Controllers/
    │   │   │   ├── Controller.php
    │   │   │   ├── OrderController.php
    │   │   │   ├── TransactionController.php
    │   │   │   ├── UserController.php
    │   │   │   └── WalletController.php
    │   │   ├── Middleware/
    │   │   │   └── FakeAuthMiddleware.php
    │   │   ├── Requests/
    │   │   │   ├── StoreOrderRequest.php
    │   │   │   └── UpdateWalletRequest.php
    │   │   └── Resources/
    │   │       ├── OrderResource.php
    │   │       ├── TransactionResource.php
    │   │       ├── UserResource.php
    │   │       ├── WalletResource.php
    │   │       └── Paginated/
    │   │           ├── OrderResources.php
    │   │           └── TransactionResources.php
    │   ├── Models/
    │   │   ├── Order.php
    │   │   ├── Trade.php
    │   │   ├── Transaction.php
    │   │   ├── User.php
    │   │   └── Wallet.php
    │   ├── Providers/
    │   │   ├── AppServiceProvider.php
    │   │   ├── RepositoryServiceProvider.php
    │   │   └── RouteServiceProvider.php
    │   ├── Repositories/
    │   │   ├── OrderRepository.php
    │   │   ├── TradeRepository.php
    │   │   ├── TransactionRepository.php
    │   │   ├── WalletRepository.php
    │   │   └── Interfaces/
    │   │       ├── OrderRepositoryInterface.php
    │   │       ├── TradeRepositoryInterface.php
    │   │       ├── TransactionRepositoryInterface.php
    │   │       └── WalletRepositoryInterface.php
    │   └── Services/
    │       ├── OrderService.php
    │       ├── TradeService.php
    │       ├── TransactionService.php
    │       └── WalletService.php
    ├── bootstrap/
    │   ├── app.php
    │   ├── providers.php
    │   └── cache/
    │       └── .gitignore
    ├── config/
    │   ├── app.php
    │   ├── auth.php
    │   ├── cache.php
    │   ├── database.php
    │   ├── filesystems.php
    │   ├── logging.php
    │   ├── mail.php
    │   ├── queue.php
    │   ├── request-docs.php
    │   ├── services.php
    │   └── session.php
    ├── database/
    │   ├── .gitignore
    │   ├── factories/
    │   │   ├── UserFactory.php
    │   │   └── WalletFactory.php
    │   ├── migrations/
    │   │   ├── 0001_01_01_000000_create_users_table.php
    │   │   ├── 0001_01_01_000001_create_cache_table.php
    │   │   ├── 0001_01_01_000002_create_jobs_table.php
    │   │   ├── 2025_05_04_193306_create_wallets_table.php
    │   │   ├── 2025_05_04_193320_create_transactions_table.php
    │   │   ├── 2025_05_04_193327_create_orders_table.php
    │   │   └── 2025_05_04_193333_create_trades_table.php
    │   └── seeders/
    │       └── DatabaseSeeder.php
    ├── public/
    │   ├── index.php
    │   ├── robots.txt
    │   └── .htaccess
    ├── resources/
    │   ├── css/
    │   │   └── app.css
    │   ├── js/
    │   │   ├── app.js
    │   │   └── bootstrap.js
    │   └── views/
    │       └── welcome.blade.php
    ├── routes/
    │   ├── api.php
    │   └── console.php
    ├── storage/
    │   ├── app/
    │   │   ├── .gitignore
    │   │   ├── private/
    │   │   │   └── .gitignore
    │   │   └── public/
    │   │       └── .gitignore
    │   ├── framework/
    │   │   ├── .gitignore
    │   │   ├── cache/
    │   │   │   ├── .gitignore
    │   │   │   └── data/
    │   │   │       └── .gitignore
    │   │   ├── sessions/
    │   │   │   └── .gitignore
    │   │   ├── testing/
    │   │   │   └── .gitignore
    │   │   └── views/
    │   │       └── .gitignore
    │   └── logs/
    │       └── .gitignore
    ├── tests/
    │   ├── TestCase.php
    │   ├── Feature/
    │   │   └── StoreOrderTest.php
    │   └── Unit/
    │       └── ExampleTest.php
    └── .github/
        └── workflows/
            └── ci.yml

```

---

## 📦 Dependencies

### Required

* `laravel/framework:^11.31`
* `rakutentech/laravel-request-docs:^2.42`

### Development

* `phpunit/phpunit:^11.0.1`
* `fakerphp/faker`
* `laravel/sail`
* `laravel/pint`
* `mockery/mockery`
* `nunomaduro/collision`

---

## 🚀 Getting Started

### Prerequisites

* Docker & Docker Compose
* PHP 8.2+
* Composer

### Installation

```bash
git clone git@github.com:AmirMahdi-for/tlyn.git
cd amirmahdi-for-tlyn
cp .env.example .env
composer install
php artisan key:generate
docker-compose up -d --build
```

---

## 📌 Key Features

* Place buy/sell gold orders
* Track wallet balance
* Secure transaction handling
* Custom user identification (via `X-User-ID` header)
* Repository-Service pattern
* Feature

---

## 🧪 Running Tests

```bash
php artisan test
```

---

## 🧰 Development Commands

```bash
composer dev
```

Runs:

* `php artisan serve`
* `php artisan queue:listen`
* `php artisan pail`

---

## 📄 API Documentation

Run the following to generate API docs using `laravel-request-docs`:

```bash
php artisan request-docs:generate
```

---

## 🏗 Architecture

* **Controllers**: Handle HTTP requests
* **Services**: Business logic
* **Repositories**: Data persistence
* **Resources**: API response formatting
* **Requests**: Validation

---

## 🔐 Auth Middleware

A custom middleware `FakeAuthMiddleware` reads the `X-User-ID` header and binds the user to the request.

---

## 🛠 Docker

Includes Dockerfile and NGINX config. Use `docker-compose up` to boot your app and database.

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first.

---