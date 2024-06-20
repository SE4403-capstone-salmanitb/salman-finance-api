<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Perubahan Email</title>
</head>
<body>
    <h1>Pemberitahuan Perubahan Email</h1>
    </br>
    <p>Halo {{ $name }},</p>
    <p>Kata email Anda baru-baru ini diubah menjadi {{ $email }} dari lokasi: {{ $geolocation }}.</p>
    <p>Jika Anda tidak melakukan perubahan ini, silakan hubungi tim dukungan kami segera.</p>
    </br>
    <p>Dengan salam hangat,</p>
    <p>Tim {{ env("APP_NAME", "Pengembang") }}</p>
</body>
</html>
