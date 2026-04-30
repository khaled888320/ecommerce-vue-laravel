# 🛍️ E-Commerce API — Laravel

A production-ready RESTful API built with Laravel for a full-stack e-commerce application.

## 🚀 Tech Stack

- **PHP 8.1** + **Laravel 10**
- **MySQL** / SQLite
- **Laravel Sanctum** — API Authentication
- **Service Layer** + **Repository Pattern**

## ✨ Features

- 🔐 Authentication (Register, Login, Logout)
- 🛍️ Products with filtering, search & pagination
- 📂 Categories management
- 🛒 Shopping Cart
- 📦 Orders & Checkout
- 👨‍💼 Admin Panel (Products & Categories CRUD)
- ✅ Form Request Validation
- 🔒 Role-based access control (Admin middleware)

## 📋 API Endpoints

### Auth
| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | /api/register | Register new user |
| POST | /api/login | Login |
| POST | /api/logout | Logout (auth required) |
| GET | /api/me | Get current user (auth required) |

### Products
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/products | List products (filter, search, paginate) |
| GET | /api/products/{id} | Product details |

### Cart
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/cart | Get cart (auth required) |
| POST | /api/cart | Add to cart (auth required) |
| DELETE | /api/cart/{id} | Remove from cart (auth required) |

### Orders
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/orders | My orders (auth required) |
| POST | /api/orders | Place order (auth required) |
| GET | /api/orders/{id} | Order details (auth required) |

### Admin
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/admin/products | List all products |
| POST | /api/admin/products | Create product |
| PUT | /api/admin/products/{id} | Update product |
| DELETE | /api/admin/products/{id} | Delete product |
| GET | /api/admin/categories | List categories |
| POST | /api/admin/categories | Create category |
| PUT | /api/admin/categories/{id} | Update category |
| DELETE | /api/admin/categories/{id} | Delete category |

## ⚙️ Installation

app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── AuthController
│   │   ├── ProductController
│   │   ├── CartItemController
│   │   └── OrderController
│   ├── Middleware/
│   │   └── IsAdmin         # Admin protection
│   └── Requests/           # Form validation
├── Models/                 # Eloquent models
├── Services/               # Business logic
└── Repositories/           # Database queries

## 👨‍💻 Author

**Khaled Marouani** — Full Stack Developer
- GitHub: [@khaled888320](https://github.com/khaled888320)