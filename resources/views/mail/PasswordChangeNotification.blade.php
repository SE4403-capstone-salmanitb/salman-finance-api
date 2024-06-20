<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Perubahan Kata Sandi</title>
</head>
<body>
    <h1>Pemberitahuan Perubahan Kata Sandi</h1>
    </br>
    <p>Halo {{ $name }},</p>
    <p>Kata sandi Anda baru-baru ini diubah dari lokasi: {{ $geolocation }}.</p>
    <p>Jika Anda tidak melakukan perubahan ini, silakan hubungi tim dukungan kami segera.</p>
    </br>
    <p>With best regards,</p>
    <p>Tim {{ env("APP_NAME", "Pengembang") }}</p>
</body>
</html>
