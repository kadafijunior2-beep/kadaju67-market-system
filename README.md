# Kadaju67 Market Vendor Management System

A premium Laravel-based Market Vendor Management System with Black & Gold luxury theme. Manages vendors, stalls, payments, and generates reports with PDF export.

## Features

### Core Management
- **Vendor Management** — Full CRUD with search, filter by status/business type, soft deletes
- **Stall Management** — Full CRUD with vendor assignment, occupancy tracking, soft deletes
- **Payment Management** — Full CRUD with receipt generation, PDF export, multiple payment methods
- **Reporting** — Vendor reports, stall reports, revenue analytics, monthly summaries

### Security & Access Control
- **Role-Based Access** — Admin, Manager, and Staff roles with Policies and `authorize()` gates
- **Form Request Validation** — Dedicated Store/Update requests for all entities
- **CSRF & XSS Protection** — Laravel's built-in security middleware
- **Rate Limiting** — Login attempt throttling (5 attempts per minute)

### User Experience
- **Luxury Black & Gold Theme** — Custom SCSS with animated sidebar, stat cards, tables, buttons
- **Responsive Design** — Mobile offcanvas sidebar, full desktop layout with Bootstrap 5
- **Dashboard Analytics** — Revenue chart (Chart.js), vendor status doughnut, recent payments feed
- **Activity Logging** — Service-layer transaction logging with polymorphic relationships

### Technical Features
- **Service Layer Pattern** — Business logic encapsulated in Service classes
- **Soft Deletes** — All major entities support soft deletion
- **PDF Receipts** — dompdf-powered receipt and report PDF export
- **Chart.js Integration** — Interactive revenue and status charts
- **Vite + SCSS** — Modern asset bundling with Bootstrap 5 customization

## Technologies

| Technology | Version |
|---|---|
| **PHP** | ^8.3 |
| **Laravel** | ^13.8 |
| **Bootstrap 5** | 5.3.x |
| **Vite** | ^6.x |
| **Chart.js** | ^4.x |
| **dompdf (barryvdh/laravel-dompdf)** | latest |
| **Laravel Excel (maatwebsite/excel)** | latest |
| **SQLite** | 3.x |
| **Node.js** | ^24.x |
| **Sass/SCSS** | latest |

## Directory Structure

```
kadaju67-market-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Auth, Dashboard, Vendor, Stall, Payment, Report, ActivityLog
│   │   ├── Middleware/         # AdminMiddleware, LogActivityMiddleware
│   │   └── Requests/          # Store/Update Form Requests + Auth LoginRequest
│   ├── Models/                # User, Vendor, Stall, Payment, ActivityLog
│   ├── Providers/             # AppServiceProvider (Policy registration, Gates)
│   ├── Services/              # VendorService, StallService, PaymentService, ReportService
│   └── Policies/              # VendorPolicy, StallPolicy, PaymentPolicy
├── bootstrap/                 # app.php (middleware aliases)
├── config/                    # Database, session, app, etc.
├── database/
│   ├── factories/             # VendorFactory, StallFactory, PaymentFactory
│   ├── migrations/            # 9 migration files
│   └── seeders/               # AdminSeeder, VendorSeeder, StallSeeder, PaymentSeeder
├── resources/
│   ├── scss/                  # app.scss (full Black & Gold theme)
│   ├── js/                    # app.js (Bootstrap JS)
│   └── views/
│       ├── layouts/           # admin.blade.php (sidebar + top navbar)
│       ├── auth/              # login.blade.php (Kadaju67 branding)
│       ├── vendors/           # index, create, edit, show
│       ├── stalls/            # index, create, edit, show
│       ├── payments/          # index, create, edit, show, receipt, pdf-receipt
│       ├── reports/           # index, vendors, stalls, revenue, monthly, PDF exports
│       ├── activity-logs/     # index
│       └── profile/           # edit
├── routes/
│   ├── web.php                # All application routes
│   └── auth.php               # Authentication routes (Breeze)
└── public/                    # Vite build output
```

## Installation

### Prerequisites

- PHP ^8.3
- Composer 2.x
- Node.js ^24.x + npm
- SQLite 3.x (or MySQL 8.x)

### Step 1: Clone & Install

```bash
git clone https://github.com/kadafijunior/kadaju67-market-vendor-management-system.git
cd kadaju67-market-vendor-management-system
composer install
npm install
```

### Step 2: Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Database Configuration

**SQLite (default):**
```bash
touch database/database.sqlite
# .env already has DB_CONNECTION=sqlite
```

**MySQL (alternative):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=market_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4: Migrate & Seed

```bash
php artisan migrate:fresh --seed
```

This creates all tables and seeds:
- 3 users: `admin@kadaju67.com`, `manager@kadaju67.com`, `staff@kadaju67.com` (password: `password`)
- 50 vendors, 30 stalls, 200+ payments

### Step 5: Build Frontend

```bash
npm run build
```

### Step 6: Run

```bash
php artisan serve
```

Visit `http://localhost:8000` and login with:
- **Email:** `admin@kadaju67.com`
- **Password:** `password`

## Default Users

| Role | Email | Password |
|---|---|---|
| Admin | admin@kadaju67.com | password |
| Manager | manager@kadaju67.com | password |
| Staff | staff@kadaju67.com | password |

## Routes

| Method | URI | Controller | Auth |
|---|---|---|---|
| GET | `/dashboard` | DashboardController@index | auth+verified |
| GET/POST | `/vendors` | VendorController | auth+verified |
| GET/POST | `/stalls` | StallController | auth+verified |
| GET/POST | `/payments` | PaymentController | auth+verified |
| GET/POST | `/stalls/{stall}/assign-vendor` | StallController@assignVendor | auth+verified |
| GET | `/payments/{payment}/receipt` | PaymentController@receipt | auth+verified |
| GET | `/payments/{payment}/print-receipt` | PaymentController@printReceipt | auth+verified |
| GET | `/reports/*` | ReportController | auth+verified |
| GET | `/activity-logs` | ActivityLogController@index | auth+verified |

## Screenshots

<!-- Add screenshots here once available -->
| Page | Description |
|---|---|
| Login | Kadaju67-branded login page with remember me |
| Dashboard | Revenue chart, vendor status, recent payments, activity feed |
| Vendors | Searchable, filterable vendor list with CRUD |
| Stalls | Stall management with vendor assignment |
| Payments | Payment tracking with receipt/PDF export |
| Reports | Vendor, stall, revenue, and monthly reports with PDF |

## Deployment

### Deploy to Koyeb (Free)

This project is pre-configured with `Dockerfile` and `.koyeb.yaml` for deployment on Koyeb.

#### Prerequisites

1. A [Koyeb account](https://app.koyeb.com) (free tier works, no credit card)
2. Push this repository to your GitHub account

#### Steps

1. Log in to [Koyeb Dashboard](https://app.koyeb.com)
2. Click **Create App**
3. Select **GitHub** as the deployment method
4. Connect your GitHub account and select `kadaju67-market-system`
5. Koyeb will auto-detect the `Dockerfile`
6. Under **Environment Variables**, add:
   - `DB_CONNECTION` → `pgsql`
   - `SESSION_DRIVER` → `file`
   - `CACHE_STORE` → `file`
   - `QUEUE_CONNECTION` → `database`
   - `LOG_LEVEL` → `warning`
7. Click **Deploy** and wait for the build (5-10 minutes)
8. **Add PostgreSQL:**
   - Go to your app → **Services** → **Add Service**
   - Select **Database** → **PostgreSQL**
   - Copy the connection details shown
   - Go back to your app's **Environment Variables** and add:
     - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
9. Your app will restart automatically. Visit the Koyeb-generated URL.

#### First Login

1. Open the **Web Console** in your Koyeb app dashboard
2. Run:
   ```bash
   php artisan db:seed --force
   ```
3. Login with:
   - **Email:** `admin@kadaju67.com`
   - **Password:** `password`

**Important:** Change the password immediately after first login.

### Production Optimization Checklist

- [ ] `APP_DEBUG=false` — prevents stack trace leaks
- [ ] `APP_ENV=production` — enables production optimizations
- [ ] `LOG_LEVEL=warning` — reduces log verbosity
- [ ] Cache config, routes, and views: `php artisan optimize`
- [ ] Composer with `--no-dev --optimize-autoloader`
- [ ] HTTPS enforced (auto with Render)
- [ ] Database credentials set via environment variables
- [ ] `SESSION_DRIVER` uses file or database (not array)
- [ ] `SESSION_ENCRYPT=true` for secure session data

## License

This project is open-source and available under the [MIT License](LICENSE).

---

**Built with** Laravel 13, Bootstrap 5, and the Black & Gold luxury theme.
