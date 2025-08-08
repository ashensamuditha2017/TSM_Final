<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel%20Socialite-Google%20API%20Integration-brightgreen" alt="Project Badge"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-%3E=8.1-blue" alt="PHP Version"></a>
  <!-- <a href="#"><img src="https://img.shields.io/github/license/ashensamuditha2017/TSM_Final" alt="License"></a> -->
</p>

## About the Project

**Laravel Socialite Google API Integration** is a Laravel-based application built for the **CCS4360 - Techniques in Social Media** module.  
It demonstrates **OAuth 2.0 authentication** and API integration using Laravel Socialite to connect with Google's services, including:

- **Google Calendar** – Display upcoming events.
- **Gmail** – Show recent emails.
- **Google Tasks** – List to-do items.

The application handles **secure Google login** and **automatic token refresh** for persistent access without repeated logins.

---

## Key Features

- 🔐 **Google OAuth 2.0 Login** via Laravel Socialite.
- 📅 **Google Calendar API**: Retrieve and display upcoming events.
- 📧 **Gmail API**: List recent emails.
- 📝 **Google Tasks API**: Display to-do lists.
- ♻ **Token Management**: Automatic access token refresh.

---

## Getting Started

### 1. Prerequisites
Ensure you have the following installed:
- PHP **8.1+**
- Composer
- A web server (Laravel Valet, XAMPP, or PHP built-in server)
- Node.js & npm

---

### 2. Installation

Clone the repository:

```bash
git clone [repository-url]
cd [your-project-directory]
````

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

---

### 3. Environment Setup

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Edit `.env` to configure:

* Database connection
* Google OAuth credentials

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/call-back
```

You must create a Google Cloud Project and enable:

* **Google Calendar API**
* **Gmail API**
* **Google Tasks API**

---

### 4. Database Migration

```bash
php artisan migrate
```

---

### 5. Running the Application

Start Laravel backend:

```bash
php artisan serve
```

Run frontend build/watch process:

```bash
npm run dev
```

Your app will now be running at:

```
http://127.0.0.1:8000
```

---

## Troubleshooting

### 403 Permission Denied

* Ensure APIs are enabled in Google Cloud Console.
* Wait a few minutes after enabling.

### Login Redirection Issues

* Add your Google account as a **Test User** in OAuth Consent Screen settings.

### Composer Dependency Conflicts

* Update dependencies:

```bash
composer update --with-all-dependencies
```

* Or update only Google API client:

```bash
composer require google/apiclient
```

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

```
