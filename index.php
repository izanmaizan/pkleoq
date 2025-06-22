<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem EOQ - Economic Order Quantity PT Wings Group Indonesia">
    <meta name="author" content="PT Wings Group Indonesia">

    <title>EOQ - Login | PT Wings Group Indonesia</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --wings-red: #ed1c22;
            --wings-red-dark: #c41e3a;
            --wings-red-light: #ff6b6b;
            --wings-white: #ffffff;
            --wings-gray-50: #f8fafc;
            --wings-gray-100: #f1f5f9;
            --wings-gray-200: #e2e8f0;
            --wings-gray-300: #cbd5e1;
            --wings-gray-400: #94a3b8;
            --wings-gray-500: #64748b;
            --wings-gray-600: #475569;
            --wings-gray-700: #334155;
            --wings-gray-800: #1e293b;
            --wings-gray-900: #0f172a;
            --wings-gradient: linear-gradient(135deg, var(--wings-red) 0%, var(--wings-red-dark) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--wings-white);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Background Pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 25% 25%, rgba(237, 28, 34, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(237, 28, 34, 0.03) 0%, transparent 50%),
                linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            z-index: -1;
        }

        .bg-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ed1c22' fill-opacity='0.02'%3E%3Cpolygon points='50 0 60 40 100 50 60 60 50 100 40 60 0 50 40 40'/%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        /* Container */
        .login-container {
            height: 100vh;
            max-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow: hidden;
        }

        /* Main Card */
        .login-card {
            width: 100%;
            max-width: 450px;
            max-height: calc(100vh - 2rem);
            background: var(--wings-white);
            border-radius: 24px;
            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.05),
                0 20px 25px -5px rgba(237, 28, 34, 0.05);
            border: 1px solid var(--wings-gray-100);
            overflow: hidden;
            position: relative;
            animation: slideUp 0.6s ease-out;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Red accent bar */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--wings-gradient);
        }

        /* Header Section */
        .login-header {
            padding: 2rem 2.5rem 1.5rem;
            text-align: center;
            background: linear-gradient(135deg, var(--wings-white) 0%, var(--wings-gray-50) 100%);
            position: relative;
            flex-shrink: 0;
        }

        .logo-container {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .logo-container img {
            width: 100px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(237, 28, 34, 0.15));
            transition: transform 0.3s ease;
        }

        .logo-container:hover img {
            transform: scale(1.05);
        }

        .company-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--wings-red);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .company-address {
            font-size: 0.75rem;
            color: var(--wings-gray-500);
            font-weight: 400;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .system-title {
            font-size: 0.7rem;
            color: var(--wings-gray-400);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-top: 1px solid var(--wings-gray-200);
            padding-top: 0.75rem;
            margin-top: 0.75rem;
        }

        /* Form Section */
        .login-form {
            padding: 1.5rem 2.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .welcome-text h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--wings-gray-800);
            margin-bottom: 0;
        }

        /* Error Alert */
        .error-alert {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: shake 0.5s ease-in-out, fadeInDown 0.5s ease-out;
        }

        .error-alert .error-icon {
            color: #dc2626;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .error-alert .error-content {
            flex: 1;
        }

        .error-alert .error-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #991b1b;
            margin-bottom: 0.25rem;
        }

        .error-alert .error-message {
            font-size: 0.8rem;
            color: #dc2626;
            margin: 0;
            line-height: 1.4;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--wings-gray-700);
            margin-bottom: 0.4rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--wings-gray-400);
            font-size: 1rem;
            z-index: 10;
            transition: all 0.2s ease;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            font-size: 0.9375rem;
            font-weight: 400;
            border: 2px solid var(--wings-gray-200);
            border-radius: 12px;
            background: var(--wings-white);
            color: var(--wings-gray-800);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control.error {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .form-control.error:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .form-control::placeholder {
            color: var(--wings-gray-400);
            font-weight: 400;
        }

        .form-control:focus {
            border-color: var(--wings-red);
            box-shadow: 0 0 0 4px rgba(237, 28, 34, 0.08);
        }

        .form-control:focus+.input-icon {
            color: var(--wings-red);
            transform: translateY(-50%) scale(1.05);
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 0.875rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--wings-white);
            background: var(--wings-gradient);
            border: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(237, 28, 34, 0.25);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Footer */
        .login-footer {
            padding: 1.25rem 2.5rem 1.5rem;
            text-align: center;
            background: var(--wings-gray-50);
            border-top: 1px solid var(--wings-gray-100);
            flex-shrink: 0;
        }

        .footer-text {
            font-size: 0.7rem;
            color: var(--wings-gray-500);
            margin: 0;
        }

        .footer-text strong {
            color: var(--wings-red);
            font-weight: 600;
        }

        .footer-year {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.65rem;
            color: var(--wings-gray-400);
        }

        /* Loading State */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid var(--wings-white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .loading .btn-text {
            opacity: 0;
        }

        /* SweetAlert2 custom styling */
        .wings-alert {
            font-family: 'Inter', sans-serif !important;
            border-radius: 16px !important;
        }

        .swal2-confirm {
            background: var(--wings-gradient) !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        .swal2-popup {
            border-radius: 16px !important;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 0.5rem;
            }

            .login-card {
                margin: 0;
                border-radius: 16px;
                max-height: calc(100vh - 1rem);
                max-width: 100%;
            }

            .login-header {
                padding: 1.5rem 1.25rem 1rem;
            }

            .login-form {
                padding: 1.25rem 1.25rem 1rem;
            }

            .login-footer {
                padding: 1rem 1.25rem;
            }

            .company-name {
                font-size: 1rem;
            }

            .company-address {
                font-size: 0.7rem;
            }

            .logo-container img {
                width: 85px;
            }

            .welcome-text h2 {
                font-size: 1rem;
            }
        }

        @media (max-height: 700px) {
            .login-header {
                padding: 1.5rem 2.5rem 1rem;
            }

            .login-form {
                padding: 1.25rem 2.5rem;
            }

            .login-footer {
                padding: 1rem 2.5rem;
            }

            .logo-container {
                margin-bottom: 1rem;
            }

            .logo-container img {
                width: 85px;
            }

            .welcome-text {
                margin-bottom: 1.25rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }
        }

        @media (max-height: 600px) {
            .login-header {
                padding: 1rem 2.5rem 0.75rem;
            }

            .login-form {
                padding: 1rem 2.5rem;
            }

            .login-footer {
                padding: 0.75rem 2.5rem;
            }

            .logo-container img {
                width: 70px;
            }

            .company-name {
                font-size: 0.95rem;
            }

            .company-address {
                font-size: 0.65rem;
                margin-bottom: 0.5rem;
            }

            .system-title {
                font-size: 0.65rem;
                padding-top: 0.5rem;
                margin-top: 0.5rem;
            }

            .welcome-text h2 {
                font-size: 1rem;
            }
        }

        /* Animation untuk form elements */
        .form-group {
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .btn-login {
            animation: fadeInUp 0.6s ease-out 0.3s;
            animation-fill-mode: both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <!-- Main Container -->
    <div class="login-container">
        <div class="login-card">

            <!-- Header Section -->
            <div class="login-header">
                <div class="logo-container">
                    <img src="logo.svg" alt="PT Wings Group Indonesia" id="wingsLogo">
                </div>
                <h1 class="company-name">PT WINGS GROUP<br>CABANG MUARA BUNGO</h1>
                <p class="company-address">Jl. Lintas Sumatera, Senamat, Kec. Pelepat, Kabupaten Bungo, Jambi 37262</p>
                <div class="system-title">Economic Order Quantity System</div>
            </div>

            <!-- Form Section -->
            <div class="login-form">
                <div class="welcome-text">
                    <h2>Selamat Datang</h2>
                </div>

                <!-- Error Alert -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-alert" id="errorAlert">
                        <div class="error-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="error-content">
                            <div class="error-title">Login Gagal!</div>
                            <div class="error-message"><?= htmlspecialchars($_SESSION['error']); ?></div>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['error']); // Hapus error setelah ditampilkan
                endif;
                ?>

                <form action="pages/auth/loginSession.php" method="post" id="loginForm">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Masukkan username Anda" required autocomplete="username"
                                value="<?= isset($_SESSION['old_username']) ? htmlspecialchars($_SESSION['old_username']) : ''; ?>">
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan password Anda" required autocomplete="current-password">
                            <i class="fas fa-lock input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Masuk Sekarang
                        </span>
                    </button>
                </form>
            </div>

            <!-- Footer Section -->
            <div class="login-footer">
                <p class="footer-text">
                    &copy; <strong>PT Wings Group cabang Muara Bungo</strong>
                    <span class="footer-year">2025 - Sistem EOQ v1.0</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>

    <script>
        // DOM Elements
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const errorAlert = document.getElementById('errorAlert');

        // Auto-hide error alert after 5 seconds
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.animation = 'fadeOut 0.5s ease-out forwards';
                setTimeout(() => {
                    errorAlert.remove();
                }, 500);
            }, 5000);
        }

        // CSS for fadeOut animation
        const style = document.createElement('style');
        style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
    `;
        document.head.appendChild(style);

        // Form submission handler
        loginForm.addEventListener('submit', function(e) {
            // Add loading state
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;

            // Client-side validation
            const username = usernameInput.value.trim();
            const password = passwordInput.value.trim();

            if (!username || !password) {
                e.preventDefault();
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;

                showErrorAlert('Kolom Kosong', 'Mohon lengkapi username dan password.');
                return;
            }

            if (username.length < 3) {
                e.preventDefault();
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;

                showErrorAlert('Username Tidak Valid', 'Username minimal 3 karakter.');
                markInputError(usernameInput);
                return;
            }

            if (password.length < 4) {
                e.preventDefault();
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;

                showErrorAlert('Password Tidak Valid', 'Password minimal 4 karakter.');
                markInputError(passwordInput);
                return;
            }

            // Form will submit normally
            // Loading state will be maintained until page redirects
        });

        // Function to show error alert
        function showErrorAlert(title, message) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
                confirmButtonColor: 'var(--wings-red)',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'wings-alert'
                },
                showClass: {
                    popup: 'swal2-show'
                },
                hideClass: {
                    popup: 'swal2-hide'
                }
            });
        }

        // Function to mark input as error
        function markInputError(input) {
            input.classList.add('error');
            input.focus();

            // Remove error class after user starts typing
            input.addEventListener('input', function() {
                this.classList.remove('error');
            }, {
                once: true
            });
        }

        // Input focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
                this.parentElement.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.parentElement.style.transform = 'translateY(0)';
            });

            // Clear error state on input
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const icon = this.nextElementSibling;
                if (this.value.length > 0) {
                    icon.style.color = 'var(--wings-red)';
                    icon.style.transform = 'translateY(-50%) scale(1.05)';
                } else {
                    icon.style.color = 'var(--wings-gray-400)';
                    icon.style.transform = 'translateY(-50%) scale(1)';
                }
            });
        });

        // Logo hover effect
        const logo = document.getElementById('wingsLogo');
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) rotate(1deg)';
        });

        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Escape key to clear errors
            if (e.key === 'Escape') {
                inputs.forEach(input => input.classList.remove('error'));
                if (errorAlert) {
                    errorAlert.style.animation = 'fadeOut 0.5s ease-out forwards';
                    setTimeout(() => errorAlert.remove(), 500);
                }
            }

            // Enter key to submit form
            if (e.key === 'Enter' && !loginBtn.disabled) {
                loginForm.requestSubmit();
            }
        });

        // Prevent double submission
        let isSubmitting = false;
        loginForm.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }
            isSubmitting = true;
        });

        // Auto-focus username field on page load
        window.addEventListener('load', function() {
            if (!errorAlert) {
                usernameInput.focus();
            }
        });

        // Show password toggle function
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordIcon = passwordField.nextElementSibling;

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-lock');
                passwordIcon.classList.add('fa-lock-open');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-lock-open');
                passwordIcon.classList.add('fa-lock');
            }
        }

        // Add double-click to toggle password visibility
        document.getElementById('password').addEventListener('dblclick', togglePassword);

        // Error handling for logo loading
        logo.addEventListener('error', function() {
            const fallbackLogo = document.createElement('div');
            fallbackLogo.innerHTML =
                '<i class="fas fa-dove" style="font-size: 3rem; color: var(--wings-red);"></i>';
            fallbackLogo.style.textAlign = 'center';
            this.parentElement.replaceChild(fallbackLogo, this);
        });

        // Reset form validation on page load
        window.addEventListener('load', function() {
            inputs.forEach(input => {
                input.classList.remove('error');
            });
        });
    </script>

    <?php
    // Hapus session old_username setelah ditampilkan
    if (isset($_SESSION['old_username'])) {
        unset($_SESSION['old_username']);
    }
    ?>
</body>

</html>