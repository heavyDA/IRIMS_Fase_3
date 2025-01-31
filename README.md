# Laravel Application Setup with Swoole and Nginx on Ubuntu 22.04 LTS

This guide covers the setup of a Laravel application using **Swoole** as the PHP engine and **Nginx** as the web server. The instructions are tailored for **Ubuntu 22.04 LTS** with a **16 GB RAM** and **8-core CPU** server.

---

## Prerequisites

Ensure that your server has the following installed:

-   Ubuntu 22.04 LTS
-   Access to a **root** or **sudo** user

---

## 1. **Install PHP with Swoole**

### Step 1: Update the Package List and Install Dependencies

```bash
sudo apt update
sudo apt install -y wget curl unzip software-properties-common gnupg2 build-essential nginx
```

### Step 2: Install PHP 8.3 and Required Extensions

Add the repository for PHP 8.3:

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
```

Install **PHP 8.3** and required extensions (CLI and others needed for Laravel and Swoole):

```bash
sudo apt install -y php8.3-cli php8.3-dev php8.3-mysql php8.3-xml php8.3-curl php8.3-mbstring php8.3-bcmath php8.3-zip php8.3-gd php8.3-intl libcurl4-openssl-dev
```

### Step 3: Install Swoole PHP Extension

Install the **Swoole** extension via **PECL**:

```bash
pecl install -D 'enable-sockets="no" enable-openssl="yes" enable-http2="yes" enable-mysqlnd="yes" enable-hook-curl="yes" enable-cares="yes" with-postgres="yes"' openswoole
```

Enable the Swoole extension:

```bash
sudo bash -c "echo 'extension=openswoole' >> $(php -i | grep /.+/php.ini -oE)"
```

Verify the installation:

```bash
php -m | grep openswoole
```

---

## 2. **MariaDB 11.4 Database Server Setup**

### **2.1 Add MariaDB 11.4 Repository**

```bash
sudo apt install -y software-properties-common
sudo add-apt-repository 'deb [arch=amd64,arm64,ppc64el] https://mirrors.gigenet.com/mariadb/repo/11.4/ubuntu jammy main'
sudo apt update
```

### **2.2 Install MariaDB**

```bash
sudo apt install -y mariadb-server mariadb-client
```

### **2.3 Secure MariaDB Installation**

Run the secure installation script:

```bash
sudo mysql_secure_installation
```

-   Set a root password.
-   Remove anonymous users.
-   Disallow remote root login.
-   Remove the test database.
-   Reload privileges.

### **2.4 Configure MariaDB**

Edit the configuration file:

```bash
sudo nano /etc/my.cnf
```

Recommended settings:

```ini
[mysqld]
# Basic Settings
bind-address = 0.0.0.0  # Allow remote access (change if needed)
max_connections = 150   # Adjust based on workload
skip-name-resolve       # Speed up connections by skipping DNS lookups

# InnoDB Optimizations
innodb_buffer_pool_size = 2G  # 50% of total RAM
innodb_log_file_size = 512M   # Large redo logs for better write performance
innodb_log_buffer_size = 16M
innodb_flush_method = O_DIRECT
innodb_flush_log_at_trx_commit = 2  # Reduces I/O overhead
innodb_thread_concurrency = 4  # Equal to 2x CPU cores

# Table Cache & Index Optimization
table_open_cache = 4000
open_files_limit = 8000
thread_cache_size = 64
query_cache_type = 0  # Query cache is deprecated, best to disable it
query_cache_size = 0

# Sorting & Joins
tmp_table_size = 64M
max_heap_table_size = 64M
sort_buffer_size = 2M
read_rnd_buffer_size = 4M
join_buffer_size = 4M

# Logging (Adjust as needed)
slow_query_log = 1
slow_query_log_file = /var/log/mysql-slow.log
long_query_time = 2  # Log queries that take longer than 2 seconds
log_error = /var/log/mysql/error.log

# Binary Logging (Enable if you need replication or point-in-time recovery)
server-id = 1
log_bin = /var/log/mysql-bin.log
expire_logs_days = 7
binlog_format = ROW
```

Restart MariaDB:

```bash
sudo systemctl restart mariadb
```

### **2.5 Create Database and User**

Log in to the MariaDB shell:

```bash
sudo mysql -u root -p
```

Run the following commands:

```sql
CREATE DATABASE laravel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'laravel_user'@'%' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON laravel_db.* TO 'laravel_user'@'%';
FLUSH PRIVILEGES;
EXIT;
```

### **2.6 Enable Remote Access (Optional)**

1. Edit the configuration:
    ```bash
    sudo nano /etc/mysql/mariadb.conf.d/50-server.cnf
    ```
    Update `bind-address`:
    ```ini
    bind-address = 0.0.0.0
    ```
2. Restart MariaDB:
    ```bash
    sudo systemctl restart mariadb
    ```
3. Allow MariaDB through the firewall:
    ```bash
    sudo ufw allow 3306
    ```

---

## 3. **Install Laravel Octane with Swoole**

### Step 1: Install Laravel Octane

Navigate to your Laravel application directory and install **Laravel Octane**:

```bash
composer require laravel/octane
```

### Step 2: Install the Swoole Server

Run the following command to install **Swoole** as the server for **Octane**:

```bash
php artisan octane:install --server=swoole
```

### Step 3: Start the Swoole Server

Start the server with the command below:

```bash
php artisan octane:start --server=swoole
```

---

## 4. **Configure Nginx for Laravel with Swoole**

### Step 1: Configure Nginx

Create a new configuration file for your Laravel application in **Nginx**:

```bash
sudo nano /etc/nginx/sites-available/laravel
```

Add the following configuration:

```nginx
server {
    listen 80;
    server_name example.com;  # Replace with your domain or IP

    root /var/www/laravel/public;
    index index.php index.html;

    location / {
        proxy_http_version 1.1;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        proxy_pass http://127.0.0.1:8000; # Swoole server
        proxy_read_timeout 60;
        proxy_connect_timeout 60;
    }

    location ~* \.(?:ico|css|js|gif|jpe?g|png|woff2?|eot|ttf|svg|otf|webp)$ {
        expires 6M;
        access_log off;
        add_header Cache-Control "public";
    }

    location ~ \.php$ {
        return 404;  # Disable PHP execution via Nginx
    }

    location ~ /\.ht {
        deny all;
    }

    # Security Headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "strict-origin-when-cross-origin";
    add_header Permissions-Policy "geolocation=(self), microphone=(), camera=()";

    client_max_body_size 64M;
}
```

### Step 2: Enable the Site and Restart Nginx

Create a symbolic link to enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
```

Test the Nginx configuration:

```bash
sudo nginx -t
```

Restart Nginx:

```bash
sudo systemctl restart nginx
```

---

## 5. **Optimize Nginx for Performance and Security**

### Step 1: Update the Nginx Global Configuration

Open the main configuration file:

```bash
sudo nano /etc/nginx/nginx.conf
```

Update it with these performance and security improvements:

```nginx
user www-data;
worker_processes auto;
pid /run/nginx.pid;

events {
    worker_connections 4096;
    multi_accept on;
}

http {
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;

    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    gzip on;
    gzip_comp_level 5;
    gzip_min_length 256;
    gzip_proxied any;
    gzip_vary on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

    include /etc/nginx/conf.d/*.conf;
    include /etc/nginx/sites-enabled/*;
}
```

## 6. **Enable and Configure Firewall**

Enable the UFW firewall and allow Nginx traffic:

```bash
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

---

## 7. **Final Checks and Verifications**

### Check Swoole Installation

Ensure that Swoole is installed and running:

```bash
php -m | grep swoole
```

### Check Nginx Configuration

Verify that Nginx is serving your Laravel app:

```bash
sudo nginx -t
sudo systemctl restart nginx
```

---

### 8. **Create systemd Service Files**

#### Step 1: **Systemd Service for Laravel Octane**

Create a service file for Laravel Octane (`artisan octane:start`):

```bash
sudo nano /etc/systemd/system/laravel-octane.service
```

Add the following configuration:

```ini
[Unit]
Description=Laravel Octane Swoole Server
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/laravel  # Path to your Laravel project
ExecStart=/usr/bin/php /var/www/laravel/artisan octane:start --server=swoole --host=127.0.0.1 --port=8000
Restart=always
RestartSec=3

[Install]
WantedBy=multi-user.target
```

-   Make sure to replace `/var/www/laravel` with the path to your Laravel application directory.

#### Step 2: **Systemd Service for Laravel Queue**

Create a service file for the Laravel queue worker (`artisan queue:work`):

```bash
sudo nano /etc/systemd/system/laravel-queue.service
```

Add the following configuration:

```ini
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/laravel
ExecStart=/usr/bin/php /var/www/laravel/artisan queue:work --sleep=3 --tries=3
Restart=always
RestartSec=3

[Install]
WantedBy=multi-user.target
```

#### Step 3: **Systemd Service for Laravel Scheduler**

Create a service file for the Laravel scheduler (`artisan schedule:run`):

```bash
sudo nano /etc/systemd/system/laravel-scheduler.service
```

Add the following configuration:

```ini
[Unit]
Description=Laravel Scheduler
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/laravel
ExecStart=/usr/bin/php /var/www/laravel/artisan schedule:run --no-interaction
Restart=always
RestartSec=30

[Install]
WantedBy=multi-user.target
```

#### Step 4: **Reload systemd**

Reload the **systemd** manager to apply the new configurations:

```bash
sudo systemctl daemon-reload
```

---

### 9. **Enable and Start the Services**

To enable the services to start on boot, run the following commands:

```bash
sudo systemctl enable laravel-octane.service
sudo systemctl enable laravel-queue.service
sudo systemctl enable laravel-scheduler.service
```

Then, start the services:

```bash
sudo systemctl start laravel-octane.service
sudo systemctl start laravel-queue.service
sudo systemctl start laravel-scheduler.service
```

---

### 10. **Check Service Status**

To verify that everything is running properly, you can check the status of each service:

```bash
sudo systemctl status laravel-octane.service
sudo systemctl status laravel-queue.service
sudo systemctl status laravel-scheduler.service
```

---
