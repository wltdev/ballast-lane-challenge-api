# 📌 Task Management API

A simple task management system built with Laravel that allows users to create, edit, delete, and view tasks. The system also tracks user milestones when the total user count reaches multiples of 100.

## 🚀 Features

- ✅ User registration and authentication (Laravel Sanctum)
- ✅ Task management (CRUD operations)
- ✅ Users can only manage their own tasks
- ✅ Milestone tracking when user count reaches multiples of 100
- ✅ RESTful API endpoints with JSON responses

---

## 📁 Project Structure

```
📂 app-backend
  📂 app/Http/Controllers       # API Controllers
  📂 app/Models                 # Eloquent Models
  📂 database/migrations        # Database Migrations
  📂 routes/api.php             # API Routes
  📂 tests/Feature              # API Tests
  📜 .env                       # Environment Variables
  📜 README.md                  # Documentation
```

---

## 🛠️ Installation

### 1️⃣ Clone the repository

```sh
git clone https://github.com/wltdev/ballast-lane-challenge-api
cd ballast-lane-challenge-api
```

### 2️⃣ Install dependencies

```sh
composer install
```

### 3️⃣ Set up the environment variables

Copy `.env.example` to `.env` and update database credentials:

```sh
cp .env.example .env
```

### 4️⃣ Generate the application key

```sh
php artisan key:generate
```

### 5️⃣ Run database migrations

```sh
php artisan migrate --seed
```

### 6️⃣ Start the Laravel server

```sh
php artisan serve
```

---

## 🔌 API Endpoints

### 🔑 Authentication

| Method | Endpoint        | Description         |
| ------ | --------------- | ------------------- |
| POST   | `/api/register` | Register a new user |
| POST   | `/api/login`    | Authenticate a user |
| POST   | `/api/logout`   | Logout a user       |

### 📝 Task Management

| Method | Endpoint          | Description                |
| ------ | ----------------- | -------------------------- |
| GET    | `/api/tasks`      | List all tasks of the user |
| POST   | `/api/tasks`      | Create a new task          |
| PUT    | `/api/tasks/{id}` | Update a task              |
| DELETE | `/api/tasks/{id}` | Delete a task              |

### 📊 Milestone Tracking

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/users/milestones` | View user milestones |

---

## 🧪 Running Tests

To execute the tests, run:

```sh
php artisan test
```

---

## 🐳 Docker (Optional)

To run the application using Docker:

```sh
docker-compose up -d
```
