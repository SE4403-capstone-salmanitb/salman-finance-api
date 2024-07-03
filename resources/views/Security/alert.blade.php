<!-- resources/views/security/alert.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alert Keamanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Deteksi IP Berbeda!</h4>
            <p>Kami mendeteksi login dari IP yang berbeda. Untuk melindungi akun Anda, harap pilih salah satu opsi di bawah ini.</p>
            <hr>
            <form action="{{ route('security.deny') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Tolak Akses</button>
            </form>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Ubah Password</button>
        </div>
    </div>

    <!-- Modal untuk Mengubah Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('security.change-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
