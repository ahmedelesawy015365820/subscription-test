# 🚀 Subscription 

## 📌 Overview

* User authentication
* Admin authentication
* Dynamic subscription plans
* Subscription lifecycle (trial, active, past_due, canceled)
* Grace period handling
* Automated scheduling باستخدام Jobs + Scheduler

---

## 🧠 Architecture

* Controllers → handle HTTP requests
* Requests → validation
* DTOs → structured data transfer
* Services → business logic
* Repositories → database operations
* Observers → database operations
* Jobs → background processing
* enums
---
# Dashboard
## 🔐 Authentication (Admin)

* Register → creates user + assigns Free Plan automatically
* Login → returns Sanctum token

#### plan (crud)

* apiResource (index - store - update - destroy)
* use Observer befour(store - update) => is_default ( لو باعته ب 1 بخلي كل ال في جدول ب 0 )
---

# Clients

## 🔐 Authentication

* Register → creates user + assigns Free Plan automatically
* Login → returns Sanctum token
---



## 🤖 Automation (Scheduler)

Runs daily job:

* new ProcessSubscriptions()


## 📬 API Endpoints

### 🔐 Auth admin

* POST /api/admin/login

---

### 📦 Plans admin

* POST /api/plans
* GET /api/plans
* UPDATE /api/plans/update/{$id}
* Delete /api/plans/{$id}

---

### 🔐 Auth user

* POST /api/register
* POST /api/login

---

### 🔄 Subscriptions user

* POST /api/subscriptions

---


