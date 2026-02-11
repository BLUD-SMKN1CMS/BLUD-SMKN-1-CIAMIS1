<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - BLUD SMKN 1 CIAMIS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                        url('<?php echo e(asset("assets/smkn1ciamiswallpaper.png")); ?>') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            background: linear-gradient(135deg, #4A90E2 0%, #1A365D 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 1%);
            background-size: 30px 30px;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(30px, 30px) rotate(360deg); }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: contain;
            background: white;
            padding: 10px;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.5s ease;
        }

        .logo:hover {
            transform: rotate(15deg) scale(1.1);
        }

        .school-info h1 {
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .school-info .motto {
            font-size: 0.85em;
            opacity: 0.9;
            font-style: italic;
            position: relative;
            z-index: 1;
        }

        .login-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        /* POSISI IKON KIRI */
        .icon-left {
            position: absolute;
            left: 12px;
            top: 41px;
            width: 20px;
            height: 20px;
            opacity: 0.6;
            z-index: 2;
        }

        .form-group input {
            width: 100%;
            padding: 14px 45px 14px 40px;
            border: 2px solid #e1e5ee;
            border-radius: 10px;
            background: #f8f9fa;
            font-size: 16px;
            transition: all 0.3s ease;
            height: 50px;
        }

        .form-group input:focus {
            border-color: #4A90E2;
            background: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
            transform: translateY(-2px);
        }

        /* TOGGLE PASSWORD */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 41px;
            width: 22px;
            height: 22px;
            cursor: pointer;
            opacity: 0.6;
            user-select: none;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4A90E2, #1A365D);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.6s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 144, 226, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .error-message {
            background: #fee;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 0.9em;
            animation: shake 0.5s ease;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 0.9em;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #6c757d;
            opacity: 0.8;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #4A90E2;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .back-home a:hover {
            color: #1A365D;
            text-decoration: underline;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                border-radius: 15px;
            }
            
            .login-header {
                padding: 25px 15px;
            }
            
            .login-form {
                padding: 25px;
            }
            
            .logo {
                width: 70px;
                height: 70px;
            }
            
            .school-info h1 {
                font-size: 1.3em;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <div class="login-header">
        <div class="logo-container">
            <img src="<?php echo e(asset('assets/iconsmea.png')); ?>" class="logo" alt="Logo BLUD">
        </div>
        <div class="school-info">
            <h1>ADMIN PANEL</h1>
            <div class="motto">BLUD SMKN 1 CIAMIS</div>
            <div class="motto" style="font-size: 0.8em; margin-top: 5px;">Teaching Factory Products & Services</div>
        </div>
    </div>

    <div class="login-form">

        <?php if(session('error')): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="success-message">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.post')); ?>" id="loginForm">
            <?php echo csrf_field(); ?>

            <!-- USERNAME -->
            <div class="form-group">
                <label>Username Admin</label>
                <svg class="icon-left" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <input type="text" name="username" id="username" 
                       placeholder="Masukkan username" required autofocus
                       value="<?php echo e(old('username')); ?>">
            </div>

            <!-- PASSWORD DENGAN TOGGLE MATA -->
            <div class="form-group">
                <label>Password</label>
                <svg class="icon-left" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>

                <input type="password" id="password" name="password" 
                       placeholder="Masukkan password" required>

                <!-- TOGGLE PASSWORD -->
                <span class="toggle-password" onclick="togglePassword()">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </span>
            </div>

            <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember" style="font-weight: normal; color: #555;">
                    Ingat saya
                </label>
            </div>

            <button type="submit" class="btn-login" id="loginButton">
                <span id="buttonText">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Admin Panel
                </span>
                <span id="loadingSpinner" class="loading-spinner"></span>
            </button>

            <div class="back-home">
                <a href="<?php echo e(route('home')); ?>">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </form>

        <div class="copyright">
            © <?php echo e(date('Y')); ?> BLUD SMKN 1 CIAMIS. All rights reserved.
        </div>

    </div>
</div>

<!-- Scripts -->
<script>
// Toggle password visibility
function togglePassword() {
    const input = document.getElementById("password");
    const toggle = document.querySelector('.toggle-password svg');
    
    if (input.type === "password") {
        input.type = "text";
        // Ikon mata tertutup (slash)
        toggle.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = "password";
        // Ikon mata terbuka
        toggle.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
        `;
    }
}

// Form submission with loading animation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const button = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    // Validasi sederhana
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    
    if (!username || !password) {
        e.preventDefault();
        alert('Harap isi username dan password!');
        return;
    }
    
    // Show loading state
    buttonText.style.display = 'none';
    loadingSpinner.style.display = 'block';
    button.disabled = true;
    
    // Auto focus pada error
    setTimeout(() => {
        if (document.querySelector('.error-message')) {
            buttonText.style.display = 'block';
            loadingSpinner.style.display = 'none';
            button.disabled = false;
            document.getElementById('username').focus();
        }
    }, 2000);
});

// Auto focus on username
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('username').focus();
    
    // Enter key untuk submit
    document.getElementById('username').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('password').focus();
        }
    });
    
    document.getElementById('password').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('loginForm').submit();
        }
    });
});

// Auto-hide messages after 5 seconds
setTimeout(function() {
    const messages = document.querySelectorAll('.error-message, .success-message');
    messages.forEach(message => {
        message.style.opacity = '0';
        message.style.transition = 'opacity 0.5s ease';
        setTimeout(() => message.remove(), 500);
    });
}, 5000);
</script>

</body>
</html><?php /**PATH C:\Users\RISWAN\BLUD-SMKN-1-CIAMIS1\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>