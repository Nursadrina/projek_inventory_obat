<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventori Obat</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-page">

    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <i class="fas fa-user-shield"></i>
                <h2>Sistem Inventori</h2>
                <p>Silahkan login untuk mengelola stok</p>
            </div>
            
            <form action="proses_login.php" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    Login Sekarang
                </button>
            </form>
            
            <div class="login-footer">
                <p>&copy; 2026 Inventori Obat NTT</p>
            </div>
        </div>
    </div>

    <script>
        // Interaktif: Efek Klik pada Tombol Login
        const btn = document.getElementById('btnLogin');
        btn.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            this.style.background = '#008f95';
        });
    </script>
</body>
</html>
