<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Deployment Guide
Berikut adalah panduan deployment aplikasi **Laravel** dalam bahasa Indonesia yang mudah dipahami:

---

### 1. **Siapkan Server**
   - **Pilih Server:** Gunakan penyedia layanan seperti **DigitalOcean**, **AWS**, atau **Vultr**.
   - **Install LAMP/LEMP Stack:** Pastikan server menggunakan **Linux**, **Apache/Nginx**, **MySQL**, dan **PHP** (versi 8.1+).
   - **Install Composer:** Laravel membutuhkan Composer untuk mengelola dependensi:
     ```bash
     sudo apt install composer
     ```

### 2. **Install Ekstensi PHP (termasuk GD)**
   - **Pastikan PHP mendukung GD**:
     ```bash
     sudo apt install php-gd
     ```
   - **Cek apakah GD sudah terpasang**:
     ```bash
     php -m | grep gd
     ```

### 3. **Kloning Proyek Laravel**
   - **Login ke Server via SSH**:
     ```bash
     ssh user@alamat-server-anda
     ```
   - **Masuk ke Direktori Web**:
     ```bash
     cd /var/www/html
     ```
   - **Kloning Repositori Anda**:
     ```bash
     git clone [https://github.com/SE4403-capstone-salmanitb/salman-finance-api.git]
     ```

### 4. **Konfigurasi Environment**
   - **Salin `.env.example` menjadi `.env`**:
     ```bash
     cp .env.example .env
     ```
   - **Generate App Key**:
     ```bash
     php artisan key:generate
     ```
   - **Sesuaikan file `.env`** (atur kredensial database, URL aplikasi, dll. lihat lebih lanjut pada [#Environtment])

### 5. **Install Dependensi**
   ```bash
   composer install
   ```

### 6. **Migrasi Database**
   - **Jalankan Migrasi**:
     ```bash
     php artisan migrate --force
     ```
   - **Download Data Geolocation terbaru**:
     ```bash
     php artisan location:update
     ```

### 7. **Atur Izin Akses (Permissions)**
   - Pastikan direktori **storage** dan **bootstrap/cache** bisa ditulis:
     ```bash
     sudo chown -R www-data:www-data /var/www/html/proyeklaravel
     sudo chmod -R 775 /var/www/html/proyeklaravel/storage
     sudo chmod -R 775 /var/www/html/proyeklaravel/bootstrap/cache
     ```

### 8. **Konfigurasi Web Server**
   - **Untuk Nginx**: Buat file konfigurasi di `/etc/nginx/sites-available/proyeklaravel`:
     ```nginx
     server {
         listen 80;
         server_name namadomainanda.com;
         root /var/www/html/proyeklaravel/public;

         index index.php index.html;

         location / {
             try_files $uri $uri/ /index.php?$query_string;
         }

         location ~ \.php$ {
             include snippets/fastcgi-php.conf;
             fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
             include fastcgi_params;
         }
     }
     ```
   - **Untuk Apache**: Ubah **`/etc/apache2/sites-available/000-default.conf`**:
     ```apache
     <VirtualHost *:80>
         ServerAdmin admin@namadomainanda.com
         DocumentRoot /var/www/html/proyeklaravel/public

         <Directory /var/www/html/proyeklaravel>
             AllowOverride All
         </Directory>

         ErrorLog ${APACHE_LOG_DIR}/error.log
         CustomLog ${APACHE_LOG_DIR}/access.log combined
     </VirtualHost>
     ```
   - **Aktifkan Modul Rewrite (untuk Apache)**:
     ```bash
     sudo a2enmod rewrite
     sudo systemctl restart apache2
     ```

### 9. **Optimasi Laravel untuk Produksi**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### 10. **Atur Cron Jobs (Opsional)**
   - Buka crontab:
     ```bash
     crontab -e
     ```
   - Tambahkan baris ini untuk menjalankan **Laravel task scheduler** setiap menit:
     ```bash
     * * * * * cd /var/www/html/proyeklaravel && php artisan schedule:run >> /dev/null 2>&1
     ```

### 11. **Pengaturan SSL (Opsional)**
   - Gunakan **Certbot** untuk sertifikat SSL gratis:
     ```bash
     sudo apt install certbot python3-certbot-nginx
     sudo certbot --nginx -d namadomainanda.com
     ```

### Selesai!
Aplikasi Laravel Anda sudah aktif dengan dukungan PHP GD dan siap digunakan.

## Environtment

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
While this project is currenly licensed as Closed Source License

```
All Rights Reserved

Copyright (c) 2024 Tim Capstone Masjid Salman ITB

THE CONTENTS OF THIS PROJECT ARE PROPRIETARY AND CONFIDENTIAL.
UNAUTHORIZED COPYING, TRANSFERRING OR REPRODUCTION OF THE CONTENTS OF THIS PROJECT, VIA ANY MEDIUM IS STRICTLY PROHIBITED.

The receipt or possession of the source code and/or any parts thereof does not convey or imply any right to use them
for any purpose other than the purpose for which they were provided to you.

The software is provided "AS IS", without warranty of any kind, express or implied, including but not limited to
the warranties of merchantability, fitness for a particular purpose and non infringement.
In no event shall the authors or copyright holders be liable for any claim, damages or other liability,
whether in an action of contract, tort or otherwise, arising from, out of or in connection with the software
or the use or other dealings in the software.

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the software.
```
Thanks! 

