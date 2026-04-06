# 📇 mini_crm_api

A RESTful API built with **Laravel** for managing contacts and notes — designed as a lightweight CRM backend with authentication, authorization, caching, queues, and rate limiting.

---

## 🚀 Features

-  Authentication via **Laravel Sanctum**
-  Full **Contacts CRUD** with per-user ownership
-  **Notes** management linked to contacts
-  **Policy-based authorization** (users can only access their own data)
-  **Cache versioning** for optimized contact listing
-  **Queue jobs & events** on contact creation
-  **Rate limiting** on contact endpoints
-  Consistent JSON responses via API Resources & custom response trait

---

## 🛠️ Tech Stack

- **PHP** >= 8.2
- **Laravel** >= 11.x
- **Laravel Sanctum** — API token authentication
- **MySQL** — Primary database
- **Redis** *(optional)* — Recommended for caching & queues
- **Laravel Queues** — Async job processing

---

## ⚙️ Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/RichiSoni/mini_crm_api.git
cd mini_crm_api
```

### 2. Install dependencies

```bash
composer install
```

### 3. Copy environment file

```bash
cp .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Configure your `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mini_crm
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=database    # Use 'redis' for production
QUEUE_CONNECTION=sync    # Use 'redis' or 'database' for async jobs
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Start the development server

```bash
php artisan serve
```

---

## Queue Setup *(Optional but Recommended)*

To process jobs asynchronously (e.g. `LogContactCreatedJob`), set `QUEUE_CONNECTION=database` or `redis` in your `.env`, then run:

```bash
# If using database queue driver
php artisan queue:table
php artisan migrate

# Start the queue worker
php artisan queue:work
```

---

## 📡 API Endpoints

All endpoints return JSON. Include `Accept: application/json` in your headers.

### 🔐 Authentication

| Method | Endpoint         | Description             |
|--------|------------------|-------------------------|
| `POST` | `/api/register`  | Register a new user     |
| `POST` | `/api/login`     | Login and receive token |
| `POST` | `/api/logout`    | Logout (requires auth)  |

### 👥 Contacts *(requires auth — rate limited: 10 req/min)*

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/contacts` | List all contacts (paginated, filterable) |
| `POST` | `/api/contacts` | Create a new contact |
| `GET` | `/api/contacts/{id}` | Get a single contact |
| `PUT/PATCH` | `/api/contacts/{id}` | Update a contact |
| `DELETE` | `/api/contacts/{id}` | Delete a contact |

**Query Parameters for `GET /api/contacts`:**

| Param | Type | Description |
|-------|------|-------------|
| `name` | string | Filter by contact name |
| `email` | string | Filter by contact email |
| `page` | integer | Page number |

### 📝 Notes *(requires auth)*

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/contacts/{contact_id}/notes` | List notes for a contact |
| `POST` | `/api/contacts/{contact_id}/notes` | Create a note |
| `GET` | `/api/contacts/{contact_id}/notes/{note_id}` | Get a single note |
| `PUT` | `/api/notes/{note_id}` | Update a note |
| `DELETE` | `/api/notes/{note_id}` | Delete a note |

---

## 🔑 Authentication Usage

**Register:**
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```

**Login:**
```http
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "secret123"
}
```

**Authenticated Requests** — include the token in every request:
```http
Authorization: Bearer {your_token_here}
```

---

## 📁 Project Structure

```
app/
├── Events/             # ContactCreated event
├── Http/
│   ├── Controllers/    # AuthController, ContactController, NotesController
│   ├── Middleware/     # ForceJsonResponse
│   ├── Requests/       # StoreContactRequest, UpdateContactRequest, StoreNoteRequest
│   └── Resources/      # ContactResource, NotesResource
├── Jobs/               # LogContactCreatedJob
├── Listeners/          # LogContactCreated
├── Models/             # User, Contact, Note
├── Policies/           # ContactPolicy, NotePolicy
├── Services/           # ContactService
└── ApiResponseTrait.php
```

---

## ✅ Validation Rules

**Contact fields:**

| Field | Rules |
|-------|-------|
| `name` | required, string, max:100 |
| `email` | required, valid email |
| `phone` | required, string |
| `company` | optional, string, max:255 |

**Note fields:**

| Field | Rules |
|-------|-------|
| `content` | required, max:500 |

---

## 🔒 Authorization

All contact and note operations are **user-scoped**. Users can only view, update, or delete their own data. Unauthorized access returns a `404` response (to avoid data leakage).

---
