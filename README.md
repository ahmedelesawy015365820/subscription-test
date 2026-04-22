# 🚀 SaaS Subscription & Accounting System

A robust, production-ready Multi-Tenant SaaS platform built with **Laravel 12**, featuring automated billing, comprehensive double-entry accounting, and strict data isolation.

---

## 📌 Features

### 🏢 Multi-Tenant Core
- **Strict Isolation**: Data is separated at the database level using `tenant_id` and enforced via Laravel Global Scopes.
- **Automatic Tenant Provisioning**: New tenants are automatically created upon user registration.

### 💳 Subscription & Billing Engine
- **Flexible Plans**: Manage monthly and yearly billing cycles.
- **Automated Invoicing**: System automatically generates invoices for active subscriptions based on billing dates.
- **Subscription Lifecycle**: Support for activating, canceling, and resuming subscriptions.

### 📊 Double-Entry Accounting
- **Revenue Recognition**: Automatically creates journal entries for revenue (Deferred vs Earned).
- **Automated Ledger**: Every financial event (Invoicing, Payment) triggers real-time updates to the General Ledger.
- **Financial Reports**: Instant generation of **Income Statements** and **Balance Sheets**.

### 🔐 Security & Authorization
- **RBAC (Role Based Access Control)**: Strictly defined roles (Admin, User) using Laravel Policies and Gates.
- **Secure APIs**: Protected via Laravel Sanctum with Bearer Token authentication.
- **Enum-Powered**: All statuses and types are centralized via PHP Enums for type safety.

---

## 🧠 Architecture

The project follows Clean Architecture principles:
- **Controllers**: Thin controllers that delegate logic to Services.
- **Services**: Contain all core business logic (e.g., Invoicing, Accounting calculation).
- **Repositories**: Standardized database operations using DTOs.
- **DTOs (Data Transfer Objects)**: Type-safe data movement between layers.

---

## 📂 API Endpoints

The project includes a comprehensive API surface. A complete Postman Collection is provided for testing.

### Key Modules:
- `Auth`: /register, /login, /logout
- `Plans`: CRUD for subscription plans.
- `Customers`: Manage tenant customers.
- `Subscriptions`: Manage subscriptions.
- `Invoices`: Manual and automated invoice generation.
- `Payments`: Process payments and update ledger.
- `Reports`: Access Income Statement & Balance Sheet.

---

## 🧪 Testing

The system is fully tested with high coverage:
- **Feature Tests**: End-to-end testing of business flows (Registration -> Subscription -> Payment).
- **Security Tests**: Verification of tenant isolation and unauthorized access prevention.
- **Accounting Tests**: Verification of ledger arithmetic and entry correctness.

Run tests using:
```bash
php artisan test
```

---

## 🛠 Installation

1. **Clone the repository**
2. **Setup environment**:
   ```bash
   copy .env.example .env
   ```
3. **Install dependencies**:
   ```bash
   composer install
   ```
4. **Generate App Key**:
   ```bash
   php artisan key:generate
   ```
5. **Migrate & Seed**:
   ```bash
   php artisan migrate:fresh --seed
   ```
6. **Start the server**:
   ```bash
   php artisan serve
   ```

---

## 🛠 Tech Stack
- **Framework**: Laravel 12
- **Database**: PostgreSQL
- **Auth**: Laravel Sanctum
- **Tools**: Postman, PHPUnit
