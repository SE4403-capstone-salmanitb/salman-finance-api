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
Berikut adalah penjelasan masing-masing item yang ada pada konfigurasi .env

- **APP_NAME**: Nama aplikasi yang digunakan dalam Laravel. **(Ubah jika nama aplikasi berbeda)**
- **APP_ENV**: Menentukan lingkungan aplikasi. **(Ubah ke `production` saat siap untuk produksi)**
- **APP_KEY**: Kunci enkripsi aplikasi untuk keamanan data sensitif. **(Perlu diisi dengan kunci unik, dibuat secara otomatis pada tahap deployment)**
- **APP_DEBUG**: Jika diset `true`, aplikasi menampilkan informasi debugging. **(Ubah ke `false` pada produksi)**
- **APP_TIMEZONE**: Zona waktu default yang digunakan aplikasi. **(Ubah jika zona waktu berbeda, biasanya menggunakan 'Asia/Jakarta')**
- **APP_URL**: URL dasar aplikasi. **(Ubah sesuai dengan URL dari aplikasi backend)**
- **FRONTEND_URL**: URL frontend aplikasi. **(Ubah jika terpisah dari backend)**
  
- **APP_LOCALE**: Bahasa default aplikasi. **(Ubah menjadi id jika ingin menggunkana bahasa Indonesia)**
- **APP_FALLBACK_LOCALE**: Bahasa fallback jika terjemahan tidak ditemukan. **(Ubah jika bahasa fallback berbeda)**
- **APP_FAKER_LOCALE**: Lokal untuk `Faker`. **(Ubah jika ingin menggunakan lokal yang berbeda, tidak digunakan dalam deployment)**

- **APP_MAINTENANCE_DRIVER**: Metode penyimpanan status pemeliharaan. **(Ubah jika menggunakan metode lain, biasanya tidak perlu diubah)**
- **APP_MAINTENANCE_STORE**: Tempat penyimpanan status pemeliharaan. **(Ubah jika menggunakan metode lain, biasanya tidak perlu diubah)**

- **BCRYPT_ROUNDS**: Jumlah putaran untuk hashing kata sandi. **(Ubah jika memerlukan tingkat keamanan yang lebih tinggi, biasanya tidak perlu diubah)**

- **LOG_CHANNEL**: Channel yang digunakan untuk logging. **(Ubah jika ingin menggunakan channel lain)**
- **LOG_STACK**: Jenis stack logging. **(Ubah jika ingin metode lain)**
- **LOG_DEPRECATIONS_CHANNEL**: Channel log untuk pesan deprecation. **(Ubah jika ingin mencatat pesan deprecation)**
- **LOG_LEVEL**: Level logging yang ditampilkan. **(Ubah sesuai kebutuhan, misalnya ke `error` di produksi)**

- **DB_CONNECTION**: Jenis database yang digunakan. **(Ubah jika menggunakan jenis database lain)**
- **DB_HOST**: Alamat host database. **(Ubah jika database tidak berada di localhost)**
- **DB_PORT**: Port untuk koneksi database. **(Ubah jika menggunakan port yang berbeda)**
- **DB_DATABASE**: Nama database yang digunakan. **(Ubah sesuai nama database yang digunakan)**
- **DB_USERNAME**: Username untuk autentikasi ke database. **(Ubah jika menggunakan username yang berbeda)**
- **DB_PASSWORD**: Password untuk koneksi ke database. **(Ubah jika menggunakan password)**
- **DB_CHARSET**: Set karakter database. **(Tidak perlu diubah)**
- **DB_COLLATION**: Aturan perbandingan teks dalam database. **(Tidak perlu diubah)**

- **SESSION_DRIVER**: Driver untuk manajemen sesi. **(Disarankan menggunakan 'redis', jika server tidak memiliki redis gunakan 'file')**
- **SESSION_LIFETIME**: Durasi sesi (dalam menit). **(Ubah sesuai kebutuhan jika diperlukan)**
- **SESSION_ENCRYPT**: Jika `true`, sesi akan dienkripsi. **(Tidak perlu diubah)**
- **SESSION_PATH**: Path untuk sesi. **(Tidak perlu diubah)**
- **SESSION_DOMAIN**: Domain sesi. **(Ubah jika perlu untuk domain tertentu)**
- **SESSION_SAME_SITE**: Kebijakan SameSite untuk cookie sesi. **(Tidak perlu diubah)**
- **SESSION_SECURE_COOKIE**: Jika `true`, cookie sesi hanya dikirim melalui HTTPS. **(Tidak perlu diubah)**
- **SESSION_PARTITIONED_COOKIE**: Jika `true`, cookie sesi akan dipartisi. **(Tidak perlu diubah)**

- **BROADCAST_CONNECTION**: Koneksi untuk broadcasting. **(Ubah jika menggunakan metode lain)**
- **FILESYSTEM_DISK**: Disk default untuk penyimpanan file. **(Ubah jika menggunakan disk lain)**
- **QUEUE_CONNECTION**: Koneksi untuk antrian tugas. **(Ubah jika menggunakan metode lain)**

- **CACHE_STORE**: Store cache yang digunakan. **(Ubah jika menggunakan metode lain)**
- **CACHE_PREFIX**: Prefix untuk kunci cache. **(Ubah jika diperlukan)**

- **MEMCACHED_HOST**: Alamat host untuk server Memcached. **(Ubah jika menggunakan Memcached)**
  
- **REDIS_CLIENT**: Klien Redis yang digunakan. **(Ubah jika menggunakan klien lain)**
- **REDIS_HOST**: Host server Redis. **(Ubah jika Redis tidak berada di localhost)**
- **REDIS_PASSWORD**: Password untuk Redis. **(Ubah jika menggunakan password)**
- **REDIS_PORT**: Port yang digunakan Redis. **(Ubah jika menggunakan port yang berbeda)**

- **MAIL_MAILER**: Driver mail yang digunakan. **(Ubah sesuai kebutuhan)**
- **MAIL_HOST**: Host server mail. **(Ubah jika menggunakan server lain)**
- **MAIL_PORT**: Port untuk pengiriman email. **(Ubah jika menggunakan port yang berbeda)**
- **MAIL_USERNAME**: Username untuk autentikasi ke server mail. **(Ubah jika menggunakan username yang berbeda)**
- **MAIL_PASSWORD**: Password untuk autentikasi ke server mail. **(Ubah jika menggunakan password)**
- **MAIL_ENCRYPTION**: Metode enkripsi email. **(Ubah sesuai kebutuhan)**
- **MAIL_FROM_ADDRESS**: Alamat email pengirim default. **(Ubah jika perlu menggunakan alamat lain)**
- **MAIL_FROM_NAME**: Nama pengirim dalam email. **(Ubah jika perlu menggunakan nama lain)**

- **AWS_ACCESS_KEY_ID**: Kunci akses untuk AWS. **(Perlu diisi jika menggunakan AWS)**
- **AWS_SECRET_ACCESS_KEY**: Kunci rahasia untuk AWS. **(Perlu diisi jika menggunakan AWS)**
- **AWS_DEFAULT_REGION**: Wilayah default AWS. **(Ubah jika menggunakan wilayah lain)**
- **AWS_BUCKET**: Nama bucket S3 yang digunakan. **(Perlu diisi jika menggunakan S3)**
- **AWS_USE_PATH_STYLE_ENDPOINT**: Jika `true`, menggunakan gaya path endpoint untuk AWS S3. **(Ubah sesuai kebutuhan)**

- **VITE_APP_NAME**: Nama aplikasi untuk konfigurasi Vite. **(Tidak perlu di ubah)**
  
- **LOCATION_TESTING**: Untuk pengujian lokasi. **(Isi 'false' jika tidak digunakan)**
- **MAXMIND_USE_WEB**: Jika `true`, menggunakan API web MaxMind untuk geolokasi. Jika 'false' maka akan menggunakan database geolokasi yang sudah didownload. **(Ubah sesuai kebutuhan)**
- **MAXMIND_USER_ID**: ID pengguna untuk MaxMind. **(Ubah dengan id dari [https://www.maxmind.com/en/geolite2/signup])**
- **MAXMIND_LICENSE_KEY**: Kunci lisensi MaxMind. **(Ubah dengan license key dari [Maxmind](https://www.maxmind.com/en/geolite2/signup))**
- **IP2LOCATIONIO_TOKEN**: Token API untuk layanan IP2Location. **(Ubah dengan token yang di dapat dari [https://www.ip2location.io/])**


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

