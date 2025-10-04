<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Peradilan Agama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #006120;
            --secondary-color: #004a18;
            --accent-color: #008c2d;
            --light-bg: #f5f7f9;
            --dark-text: #212529;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7f9 0%, #e0e6eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        
        .login-left {
            background: linear-gradient(to bottom right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h20v20H0z' fill='none'/%3E%3Cpath d='M1 1h18v18H1V1zm1 1h16v16H2V2zm2 2h12v12H4V4zm2 2h8v8H6V6zm2 2h4v4H8V8z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }
        
        .login-left h2 {
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
        }
        
        .login-left p {
            opacity: 0.9;
            line-height: 1.6;
            position: relative;
        }
        
        .login-left img {
            max-width: 100%;
            margin-top: 30px;
            position: relative;
        }
        
        .login-right {
            padding: 40px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #6c757d;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 140, 45, 0.25);
        }
        
        .input-group-text {
            background-color: white;
            border-radius: 8px 0 0 8px;
        }
        
        .form-floating>.form-control:focus~label, 
        .form-floating>.form-control:not(:placeholder-shown)~label {
            color: var(--accent-color);
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            border: none;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
            box-shadow: 0 3px 5px rgba(0, 97, 32, 0.2);
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 5px 8px rgba(0, 97, 32, 0.3);
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }
        
        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: all 0.3s;
        }
        
        .social-btn.google {
            background-color: #DB4437;
        }
        
        .social-btn.facebook {
            background-color: #4267B2;
        }
        
        .social-btn.twitter {
            background-color: #1DA1F2;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
            opacity: 0.9;
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #6c757d;
            margin: 20px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        
        .divider::before {
            margin-right: .5em;
        }
        
        .divider::after {
            margin-left: .5em;
        }
        
        .additional-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .password-container {
            position: relative;
        }
        
        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 20px;
        }
        
        .floating-label label {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
            transition: all 0.3s;
            pointer-events: none;
        }
        
        .floating-label input:focus ~ label,
        .floating-label input:not(:placeholder-shown) ~ label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            background-color: white;
            padding: 0 5px;
            color: var(--accent-color);
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            color: white;
            position: relative;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        }
        
        .copyright {
            text-align: center;
            margin-top: 20px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="row g-0">
            <div class="col-md-6">
                <div class="login-left">
                    <div class="logo">⚖️</div>
                    <h4>Pengadilan Tinggi Agama</h4>
                    <small>Sistem Informasi Perkara</small>
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/login-3305943-2757111.png" alt="Login Illustration">
                    <div class="mt-4">
                        <p>Butuh bantuan? <a href="#" style="color: white; text-decoration: underline;">Hubungi administrator</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="login-right">
                    <div class="login-header">
                        <h2>Masuk ke Sistem</h2>
                        <p>Silakan masukkan kredensial Anda</p>
                    </div>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="floating-label">
                            <input id="username" type="username" class="form-control" name="username" required autocomplete="username" autofocus placeholder=" ">
                            <label for="username"><i class="fas fa-user me-2"></i>Nama Pengguna</label>
                        </div>
                        
                        <div class="floating-label">
                            <div class="password-container">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder=" ">
                                <label for="password"><i class="fas fa-lock me-2"></i>Kata Sandi</label>
                                <span class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat Saya
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <a class="btn btn-link p-0" href="#" style="color: var(--primary-color);">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                </button>
                            </div>
                        </div>
                        
                        <div class="divider">
                            atau akses layanan lainnya
                        </div>
                        
                        <div class="text-center mt-4">
                            {{-- <p>Pengguna baru? <a href="{{ route('register') }}" style="color: var(--primary-color);">Registrasi perangkat</a></p> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Menambahkan efek interaktif pada input fields
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', () => {
                if (input.value === '') {
                    input.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>