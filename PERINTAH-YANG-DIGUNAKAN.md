# Daftar Perintah - Proyek Biara Loresa SCJ

Dokumentasi semua perintah yang digunakan dari awal sampai akhir dalam pembuatan website Biara Loresa SCJ dengan Laravel.

---

## 1. Persiapan Sistem (Update & Dependencies)

```bash
# Update package list
sudo apt-get update -y

# Install dependencies dasar
sudo apt-get install -y software-properties-common curl unzip git
```

---

## 2. Instalasi PHP

```bash
# Tambah repository PHP
sudo add-apt-repository ppa:ondrej/php -y
sudo apt-get update -y

# Install PHP 8.2 dan ekstensi yang dibutuhkan Laravel
sudo apt-get install -y php8.2 php8.2-cli php8.2-fpm php8.2-mbstring php8.2-xml php8.2-zip php8.2-curl php8.2-mysql php8.2-pgsql php8.2-sqlite3 php8.2-bcmath php8.2-gd php8.2-tokenizer php8.2-fileinfo

# Verifikasi instalasi PHP
php --version
```

---

## 3. Instalasi Composer

```bash
# Download dan install Composer secara global
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Verifikasi
composer --version
```

---

## 4. Instalasi Node.js & NPM

```bash
# Tambah repository Node.js 20
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -

# Install Node.js
sudo apt-get install -y nodejs

# Verifikasi
node --version
npm --version
```

---

## 5. Pembuatan Proyek Laravel

```bash
# Buat proyek Laravel baru
cd /home/ubuntu
composer create-project laravel/laravel biara-loresa-scj

# Masuk ke direktori proyek
cd biara-loresa-scj
```

---

## 6. Instalasi Dependencies Frontend

```bash
# Install NPM dependencies
npm install

# Install Tailwind CSS dan plugin
npm install -D tailwindcss@3 postcss autoprefixer @tailwindcss/typography

# Inisialisasi konfigurasi Tailwind
./node_modules/.bin/tailwindcss init -p
```

---

## 7. Build Assets

```bash
# Build assets untuk production
npm run build
```

---

## 8. Menjalankan Laravel (Development Server)

```bash
# Jalankan di port 8000
cd /home/ubuntu/biara-loresa-scj
php artisan serve --host=0.0.0.0 --port=8000

# Atau jalankan di port 80 (perlu authbind)
# Install authbind dan konfigurasi
sudo apt-get install -y authbind
sudo touch /etc/authbind/byport/80
sudo chmod 500 /etc/authbind/byport/80
sudo chown ubuntu /etc/authbind/byport/80

# Jalankan dengan authbind
authbind --deep php artisan serve --host=0.0.0.0 --port=80
```

---

## 9. Setup Nginx & PHP-FPM (Production)

```bash
# Stop Laravel development server
pkill -f "php artisan serve"
pkill -f "authbind"

# Install Nginx dan PHP-FPM
sudo apt-get install -y nginx php8.2-fpm

# Set permission storage Laravel
sudo chown -R www-data:www-data /home/ubuntu/biara-loresa-scj/storage /home/ubuntu/biara-loresa-scj/bootstrap/cache
sudo chmod -R 775 /home/ubuntu/biara-loresa-scj/storage /home/ubuntu/biara-loresa-scj/bootstrap/cache

# Copy proyek ke /var/www
sudo mkdir -p /var/www
sudo cp -r /home/ubuntu/biara-loresa-scj /var/www/
sudo chown -R www-data:www-data /var/www/biara-loresa-scj
sudo chmod -R 755 /var/www/biara-loresa-scj
sudo chmod -R 775 /var/www/biara-loresa-scj/storage /var/www/biara-loresa-scj/bootstrap/cache
```

---

## 10. Konfigurasi Nginx

File konfigurasi dibuat di `/etc/nginx/sites-available/biaraloresa.my.id`:

```bash
# Enable site
sudo ln -sf /etc/nginx/sites-available/biaraloresa.my.id /etc/nginx/sites-enabled/

# Remove default site (opsional)
sudo rm -f /etc/nginx/sites-enabled/default

# Test konfigurasi Nginx
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

---

## 11. Instalasi SSL dengan Certbot

```bash
# Install Certbot dengan plugin Nginx
sudo apt-get install -y certbot python3-certbot-nginx

# Cek DNS domain (pastikan sudah mengarah ke IP server)
dig +short biaraloresa.my.id A

# Install sertifikat SSL (domain utama)
sudo certbot --nginx -d biaraloresa.my.id --non-interactive --agree-tos --email admin@biaraloresa.my.id --redirect

# Untuk menambah www (jika DNS www sudah dikonfigurasi)
sudo certbot --nginx -d www.biaraloresa.my.id --expand --non-interactive
```

---

## 12. Perintah Laravel Artisan

```bash
# Generate application key
php artisan key:generate

# Buat database SQLite (jika belum ada)
touch database/database.sqlite

# Jalankan migrasi
php artisan migrate

# Buat controller
php artisan make:controller HomeController
php artisan make:controller ProfilController
php artisan make:controller BeritaController
php artisan make:controller GaleriController
php artisan make:controller KontakController
```

---

## 13. Sinkronisasi ke Production

```bash
# Copy file konfigurasi ke /var/www
sudo cp /home/ubuntu/biara-loresa-scj/.env /var/www/biara-loresa-scj/.env
sudo cp /home/ubuntu/biara-loresa-scj/config/app.php /var/www/biara-loresa-scj/config/app.php
sudo chown www-data:www-data /var/www/biara-loresa-scj/.env
```

---

## 14. Perintah Berguna Lainnya

```bash
# Cek status Nginx
sudo systemctl status nginx

# Restart Nginx
sudo systemctl restart nginx

# Cek status PHP-FPM
sudo systemctl status php8.2-fpm

# Perpanjangan sertifikat SSL (otomatis, tapi bisa manual)
sudo certbot renew

# Cek sertifikat SSL
sudo certbot certificates
```

---

## Ringkasan Alur

1. **Persiapan** → Update sistem, install PHP, Composer, Node.js
2. **Proyek** → Buat Laravel, install dependencies, build assets
3. **Development** → Jalankan `php artisan serve`
4. **Production** → Install Nginx, setup domain, install SSL
5. **Akses** → https://biaraloresa.my.id

---

*Dokumentasi dibuat pada: 4 Maret 2026*
