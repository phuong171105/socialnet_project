# SocialNet

A lightweight social networking web application built with **Native PHP**, **MySQL**, **Nginx**, and **Linux**.

## Project Structure

```
socialnet_project/
├── admin/
│   └── newuser.php          # Admin: create new user accounts
├── socialnet/
│   ├── signin.php           # Sign In page
│   ├── index.php            # Home page (requires login)
│   ├── profile.php          # Profile page (?owner=<username>)
│   ├── setting.php          # Settings / edit profile
│   ├── about.php            # About page (static info)
│   └── signout.php          # Sign Out (destroys session)
├── config/
│   ├── db.php               # Database connection helper
│   ├── session.php          # Session bootstrap & auth guards
│   └── layout.php           # Shared HTML layout, CSS, NavBar
├── db.sql                   # SQL to create DB and tables
├── nginx.conf               # Nginx server block configuration
└── README.md                # This file
```

## Prerequisites

- Ubuntu 20.04 / 22.04 (or compatible Linux)
- Nginx ≥ 1.18
- PHP-FPM ≥ 8.1 with extensions: `mysqli`, `mbstring`
- MySQL ≥ 8.0 **or** MariaDB ≥ 10.5

---

## 1. Database Setup

```bash
# Log in to MySQL as root
sudo mysql -u root -p

# Inside MySQL shell:
source /path/to/socialnet_project/db.sql;
exit;
```

This creates:
- Database: `socialnet`
- Table: `account` (id, username, fullname, password, description, created_at)

### Configure DB credentials

Open `config/db.php` and set:

```php
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');   // or a dedicated MySQL user
define('DB_PASS', 'your_password_here');
```

---

## 2. Deploy Project Files

```bash
# Copy project to Nginx document root
sudo cp -r socialnet_project /var/www/
sudo chown -R www-data:www-data /var/www/socialnet_project
sudo chmod -R 755 /var/www/socialnet_project
```

---

## 3. Configure Nginx

```bash
# Copy the Nginx config
sudo cp /var/www/socialnet_project/nginx.conf \
        /etc/nginx/sites-available/socialnet

# Enable it
sudo ln -s /etc/nginx/sites-available/socialnet \
           /etc/nginx/sites-enabled/socialnet

# Remove default site if it conflicts
sudo rm -f /etc/nginx/sites-enabled/default

# Test and reload
sudo nginx -t
sudo systemctl reload nginx
```

> **PHP version**: The `nginx.conf` assumes `php8.1-fpm`. Adjust the socket
> path (`unix:/run/php/php8.1-fpm.sock`) if you use a different version.

---

## 4. PHP-FPM

```bash
# Install PHP and required extensions (if not already installed)
sudo apt update
sudo apt install -y php8.1-fpm php8.1-mysqli php8.1-mbstring

# Start and enable PHP-FPM
sudo systemctl enable --now php8.1-fpm
```

---

## 5. Verify

Open your browser and visit:

| URL | Page |
|-----|------|
| `http://localhost/admin/newuser.php` | Create the first user |
| `http://localhost/socialnet/signin.php` | Sign in |
| `http://localhost/socialnet/index.php` | Home |
| `http://localhost/socialnet/profile.php` | My profile |
| `http://localhost/socialnet/setting.php` | Settings |
| `http://localhost/socialnet/about.php` | About |

---

## Extra / Extended Features

The following features were added beyond the base requirements:

1. **Password change in Settings** – Users can change their password after verifying the current one.
2. **Secure password storage** – All passwords are hashed with `bcrypt` (`password_hash` / `password_verify`).
3. **Session fixation protection** – `session_regenerate_id(true)` is called on every successful login.
4. **Config directory protection** – Nginx denies direct HTTP access to `/config/`.
5. **Responsive dark-mode UI** – Modern design with glassmorphism, gradient animations, and a sticky navigation bar.
6. **User avatar initials** – Auto-generated coloured avatar from the first letter of the username.
7. **Full Name editable in Settings** – Users can update their display name.

---

## Notes

- The `/config/` folder is protected by Nginx (`deny all`) and should never be web-accessible.
- To reset a password manually: `UPDATE account SET password = '<bcrypt_hash>' WHERE username = 'target';`
- Student Name: **Nguyen Van Phuong** | Student Number: **20225678**
