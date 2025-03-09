# 📌 Project Management System

A Laravel-based project management API that allows users to create and manage projects with tasks. Features user authentication, project organization, and milestone tracking in a secure, containerized environment.

## 🚀 Features

- ✅ **Secure Authentication**: Complete user registration, login, and token-based authentication using Laravel Sanctum
- ✅ **Project Management**: Create and manage multiple projects with descriptions, deadlines, and team assignments
- ✅ **Comprehensive Task Management**: Create, read, update, and delete tasks within projects with support for status
- ✅ **User Privacy**: Role-based access control ensuring users can only manage their own content
- ✅ **System Analytics**: Milestone tracking when user count reaches multiples of 100
- ✅ **Modern API Architecture**: RESTful API endpoints with consistent JSON responses and proper status codes
- ✅ **API Documentation**: Interactive API documentation using Swagger/OpenAPI
- ✅ **Containerization**: Docker setup for consistent development and production environments
- ✅ **Comprehensive Testing**: Feature and unit tests with code coverage reports

---

## 📁 Project Structure

```
📂 ballast-lane-challenge/                     # Root project directory
  📂 app-backend/                              # Laravel backend application
    📂 app/
      📂 Http/Controllers/                     # API Controllers
      📂 Models/                               # Eloquent Models
    📂 database/migrations/                    # Database Migrations
    📂 routes/                                 # API Routes
    📂 tests/                                  # API Tests
    📜 .env                                    # Environment Variables
  📂 docker-compose/                           # Docker configuration files
  📜 docker-compose.yml                        # Docker Compose configuration
  📜 .dockerignore                             # Docker ignore file
  📜 Makefile                                  # Utility commands
  📜 README.md                                 # Documentation
```

---

## 🛠️ Installation

### 1️⃣ Clone the repository

```sh
git clone https://github.com/wltdev/ballast-lane-challenge
cd ballast-lane-challenge
```

### 2️⃣ Set up with Docker (Recommended)

The easiest way to set up the project is using Docker:

```sh
# Start all services
docker-compose up -d

# Run migrations and seed the database
docker-compose exec app php artisan migrate --seed
```

### 3️⃣ Manual Installation (Alternative)

If you prefer to install without Docker:

```sh
# Navigate to the backend directory
cd app-backend

# Install PHP dependencies
composer install

# Set up environment variables
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seed the database
php artisan migrate --seed

# Start the Laravel server
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

### 💼 Project Management

| Method | Endpoint             | Description                   |
| ------ | -------------------- | ----------------------------- |
| GET    | `/api/projects`      | List all projects of the user |
| POST   | `/api/projects`      | Create a new project          |
| GET    | `/api/projects/{id}` | View a specific project       |
| PUT    | `/api/projects/{id}` | Update a project              |
| DELETE | `/api/projects/{id}` | Delete a project              |

### 📊 Milestone Tracking

| Method | Endpoint                | Description          |
| ------ | ----------------------- | -------------------- |
| GET    | `/api/users/milestones` | View user milestones |

---

## 🧪 Running Tests

### With Docker

```sh
# Run all tests
docker-compose exec app php artisan test

# Run tests with coverage report
docker-compose exec app php artisan test --coverage
```

### Without Docker

```sh
cd app-backend
php artisan test
```

---

## 🛠️ Makefile Commands

The project includes a Makefile with useful commands for development:

```sh
# Start all services
make up

# Stop all services
make down

# Run tests
make test

# Generate test coverage report
make coverage
```

---

## 📚 API Documentation

After starting the server, you can access the API documentation at:

- Local development: [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)
- Docker setup: [http://localhost:8003/api/documentation](http://localhost:8003/api/documentation)
