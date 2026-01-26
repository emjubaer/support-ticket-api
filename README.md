# Support Ticketing API (Laravel)

This project is a backend-only Support / Helpdesk Ticketing API built with Laravel. It follows clean architecture principles and is designed as a **junior-level interview practice project**.

---

## 📌 Features Overview

* Authentication using **Laravel Sanctum**
* Role-based access: **Customer, Agent, Admin**
* Ticket lifecycle with strict status flow
* Policy-based authorization (no role checks in controllers)
* Business logic handled in **Service classes**
* Validation using **Form Requests**
* Enums for ticket status and priority
* Responses formatted using **JSON:API specification**

---

## 🛠️ Tech Stack

* PHP 8.1+
* Laravel 10+
* Laravel Sanctum
* MySQL (or any relational DB)

---

## ⚙️ Setup Instructions (Step by Step)

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/emjubaer/support-ticket-api.git
cd support-ticket-api
```

---

### 2️⃣ Install Dependencies

```bash
composer install
```

---

### 3️⃣ Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:

```env
DB_DATABASE=support_ticket
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4️⃣ Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This will create:

* 1 Customer user
* 1 Agent user
* 1 Admin user
* Sample tickets and messages

---

### 5️⃣ Start the Server

```bash
php artisan serve
```

API will be available at:

```
http://127.0.0.1:8000/api
```

---

## 🔐 Authentication

### Login

**POST** `/api/login`

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

**Response (JSON:API):**

```json
{
  "data": {
    "type": "token",
    "attributes": {
      "token": "YOUR_SANCTUM_TOKEN"
    }
  }
}
```

Use this token as:

```
Authorization: Bearer YOUR_SANCTUM_TOKEN
```

---

### Logout

**POST** `/api/logout`

---

## 🎫 Ticket APIs

### Create Ticket (Customer)

**POST** `/api/tickets`

```json
{
  "subject": "Login problem",
  "priority": "high",
  "message": "I cannot log in to my account"
}
```

---

### Get Tickets (Paginated)

**GET** `/api/tickets?status=open&priority=high`

**Response:**

```json
{
  "data": [
    {
      "type": "tickets",
      "id": "1",
      "attributes": {
        "subject": "Login problem",
        "status": "open",
        "priority": "high"
      }
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3
  },
  "links": {
    "first": "...",
    "next": "..."
  }
}
```

---

### View Single Ticket

**GET** `/api/tickets/{id}`

---

### Update Ticket Status (Agent/Admin)

**PATCH** `/api/tickets/{id}/status`

```json
{
  "status": "resolved"
}
```

Rules enforced:

* open → in_progress → resolved → closed
* closed is terminal
* closed_at auto set

---

### Assign Agent (Admin only)

**PATCH** `/api/tickets/{id}/assign`

```json
{
  "assigned_agent_id": 2
}
```

---

## 💬 Ticket Messages

### Add Message

**POST** `/api/tickets/{id}/messages`

```json
{
  "message": "We are working on your issue"
}
```

Closed tickets will return an error.

---

## 🔐 Authorization Rules (Summary)

| Action           | Customer | Agent | Admin |
| ---------------- | -------- | ----- | ----- |
| Create Ticket    | ✅        | ❌     | ❌     |
| View Own Ticket  | ✅        | ❌     | ❌     |
| View All Tickets | ❌        | ✅     | ✅     |
| Update Status    | ❌        | ✅     | ✅     |
| Assign Agent     | ❌        | ❌     | ✅     |

Authorization is enforced using **Laravel Policies only**.

---

## 🧠 Architecture Notes

* Controllers are thin
* No role checks in controllers
* All business rules live in Service classes
* Policies handle permissions
* JSON:API used for all responses

---

## ✅ Interview Notes

This project demonstrates:

* Clean separation of concerns
* Proper use of Laravel Policies
* Service-layer business logic
* Enum-based domain modeling

---

## 📬 Contact

This project was built for learning and interview practice.


