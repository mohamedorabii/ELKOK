# 🛒 ELKOK

A full-stack e-commerce platform built with **Laravel 12**, serving both a **Blade web storefront** and a **REST API** for mobile apps — powered by the same Service Layer with zero code duplication.

---

## ✨ Features

### 🛍️ Shopping Experience
- Browse products by category, subcategory & brand
- Product variants — Color & Size, each with its own stock, price & SKU
- Multiple product images with a primary image flag
- Product details with related products
- Stock management with quantity tracking (per variant)
- Multilingual content (English & Arabic)

### 👤 Authentication
- Register & Login
- OTP Email Verification (6-digit code — no links!)
- Forgot & Reset Password via OTP
- Google OAuth (Login with Google)
- Guest cart support with auto-merge on login

### 🛒 Cart
- Guest cart (session-based) + User cart (DB-based)
- Add, update, remove & clear cart items
- Stock validation before checkout
- Cart ownership validation (IDOR protection)

### 💳 Checkout & Orders
- Place orders with delivery details
- Checkout confirmation step before order placement
- Per-governorate shipping pricing
- Order history & order details
- Cancel pending orders (automatically restores stock)
- Race condition protection with DB pessimistic locking

### 🖥️ Admin Panel
- Filament dashboard at `/admin`
- CRUD for products, categories, brands, subcategories, orders, users & shipping
- Colors & Sizes management for product variants
- Stats widget (total users, products, orders, revenue)

### 📱 REST API
Every feature available via REST API — ready for any mobile app.

### 📞 Contact
- Social-first contact page (Facebook, Instagram, TikTok & WhatsApp)
- Contact form email via `ContactService`

---

## 🏗️ Architecture

```
Service Layer Pattern
─────────────────────
Controller (Blade)  ──┐
                       ├──▶  Service  ──▶  Database
Controller (API)    ──┘
```

### Services

| Service | Responsibility |
|---|---|
| `AuthService` | Register, Login, OTP, Password Reset |
| `OtpService` | OTP generation, storage & verification |
| `SocialAuthService` | Google OAuth (Blade + API) |
| `CartService` | Cart CRUD with ownership & stock validation |
| `CheckoutService` | Order placement, totals, cancellation |
| `ProductService` | Product listing & details |
| `CategoryService` | Active categories |
| `SubCategoryService` | Subcategories & products |
| `BrandService` | Brands & products |
| `HomeService` | Latest products |
| `ContactService` | Contact form email |

### Event Listeners
- `SendOtpOnRegister` → Sends OTP after registration
- `MergeGuestCart` → Merges guest cart on login

---

## 🐳 Docker Setup

### Stack

| Service | Image | Port |
|---|---|---|
| PHP | php:8.2-fpm (custom) | 9000 |
| Nginx | nginx:alpine | 8888:80 |
| MySQL | mariadb:10.5 | 3307:3306 |
| phpMyAdmin | phpmyadmin | 8080:80 |
| Redis | redis:alpine | 6379:6379 |

### Requirements
- Docker Desktop
- WSL2 (Ubuntu) — recommended for better performance on Windows

### Installation

```bash
# 1. Clone the project
git clone https://github.com/mohamedorabii/ELKOK.git
cd ELKOK

# 2. Start Docker (on WSL2)
docker-compose up -d --build

# 3. Enter the container
docker exec -it elkok_app bash

# 4. Setup the app
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### Daily Usage (WSL2)
```bash
cd ~/ELKOK
docker-compose up -d
code .
```

### URLs

| Service | URL |
|---|---|
| Website | http://localhost:8888 |
| phpMyAdmin | http://localhost:8080 |

---

## 📡 API Endpoints

### Auth (Public)
```
POST /api/register
POST /api/login
POST /api/forgot-password
POST /api/reset-password
POST /api/auth/{provider}/callback    ← Google OAuth
```

### Auth (Protected - Bearer Token)
```
POST /api/logout
POST /api/verify-otp
POST /api/resend-otp
GET  /api/user
```

### Catalog (Public)
```
GET /api/home
GET /api/products
GET /api/products/{id}
GET /api/categories
GET /api/categories/{id}/products
GET /api/subcategories
GET /api/subcategories/{id}/products
GET /api/brands
GET /api/brands/{id}/products
```

### Cart (Protected)
```
GET    /api/cart
POST   /api/cart
PUT    /api/cart/{id}
DELETE /api/cart/{id}
DELETE /api/cart
```

### Checkout & Orders (Protected)
```
GET  /api/checkout
POST /api/checkout
GET  /api/orders
GET  /api/orders/{id}
```

---

## 🔧 Tech Stack

### Backend
| Package | Version |
|---|---|
| PHP | ^8.2 |
| laravel/framework | ^12.0 |
| filament/filament | ^4.4 |
| laravel/sanctum | ^4.0 |
| laravel/socialite | ^5.25 |
| laravel/ui | ^4.6 |

### Frontend
| Package | Version |
|---|---|
| Vite | ^7.0.7 |
| Bootstrap | ^5.2.3 |
| Tailwind CSS | ^4.0.0 |
| Axios | ^1.11.0 |

---

## 🗄️ Database Models

| Model | Relationships |
|---|---|
| `User` | Sanctum tokens, Filament admin access |
| `Category` | `hasMany(Subcategory)`, `hasMany(Product)` |
| `Subcategory` | `belongsTo(Category)`, `hasMany(Product)` |
| `Brand` | `hasMany(Product)` |
| `Product` | `belongsTo(Category, Subcategory, Brand)`, `hasMany(ProductVariant, ProductImage)` |
| `ProductVariant` | `belongsTo(Product, Color, Size)` — per-variant stock, price & SKU |
| `ProductImage` | `belongsTo(Product)` — gallery images with primary flag |
| `Color` | `hasMany(ProductVariant)` |
| `Size` | `hasMany(ProductVariant)` |
| `Cart` | `belongsTo(User)`, `belongsTo(Product)` |
| `Order` | `belongsTo(User)`, `hasMany(OrderItem)` |
| `OrderItem` | `belongsTo(Order)`, `belongsTo(Product)` |
| `ShippingSetting` | Per-governorate shipping price |

---

## 🔐 Security Features

- Sanctum token authentication for API
- Rate limiting on all auth endpoints (5 req/min)
- OTP-based email verification (no plain links)
- OTP-based password reset
- Cart ownership validation (IDOR protection)
- Guest cart isolation by session ID
- Stock validation & DB row locking during checkout (race condition protection)
- Pending-only order cancellation with stock restoration
- Admin access control via `canAccessPanel()`
- Global API exception handler (returns structured JSON)
- CSRF protection on all web routes

---

## 🌍 Environment Variables

### Required
```env
APP_KEY=
DB_CONNECTION=mysql
DB_HOST=mysql
DB_DATABASE=elkok
DB_USERNAME=elkok
DB_PASSWORD=elkok

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URL=

REDIS_HOST=redis
REDIS_PORT=6379
```

---

## 📁 Project Structure

```
app/
├── Filament/          ← Admin panel resources & widgets
├── Http/
│   ├── Controllers/
│   │   ├── Api/       ← REST API controllers
│   │   ├── Auth/      ← Blade auth controllers
│   │   ├── Backend/   ← Contact, Social, Verification
│   │   └── FrontEnd/  ← Blade storefront controllers
│   ├── Requests/      ← Form validation
│   └── Resources/     ← API JSON transformers
├── Listeners/         ← OTP on register, Guest cart merge
├── Models/
├── Notifications/     ← OTP email notification
├── Providers/
└── Services/          ← All business logic
docker/
└── nginx/
routes/
├── api.php
└── web.php
```

---

## 🧪 Running Tests

```bash
php artisan test
```

---

## 👨‍💻 Author

**Mohamed Alaa Oraby**
Laravel Developer
📧 devmohamedalaaoraby@gmail.com