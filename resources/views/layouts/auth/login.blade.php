<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />

    <title>@yield('title', config('app.name'))</title>

    <!-- SEO Meta Tags -->
    @yield('meta')
    <meta name="author" content="Qwetu Link Team">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('image/qwetu_link_pos.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: "Inter", sans-serif;
        }

        body {
            background: linear-gradient(135deg,
                    #0f172a 0%,
                    #1e1b4b 50%,
                    #0f172a 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .split-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
            justify-content: center;
            align-items: center;
        }

        /* Left side - Logo (now on left) */
        .left-side {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
            z-index: 10;
        }

        /* Right side - Form Card (overlaps left side) */
        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: relative;
            z-index: 20;
            padding: 2rem;
        }

        .logo-container {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border-radius: 1.2rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 30;
            transition: transform 0.3s ease;
        }

        /* Overlap effect: form card extends into left side (overlaps logo) */
        @media (min-width: 1024px) {
            .right-side {
                justify-content: flex-start;
                padding-left: 0;
            }

            .form-card {
                transform: translateX(-40px);
                margin-left: -20px;
            }

            .left-side {
                margin-right: -20px;
                justify-content: flex-end;
                padding-right: 0;
            }
        }

        @media (max-width: 1024px) {
            .split-layout {
                flex-direction: column;
            }

            .left-side {
                display: none;
            }

            .right-side {
                justify-content: center;
                padding: 2rem;
            }

            .form-card {
                transform: none;
                margin: 0 auto;
            }

            .logo-image {
                max-width: 200px;
            }
        }

        @media (min-width: 1024px) {
            .form-card .img-container1 {
                display: none;
            }
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }

        .shake {
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
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
    @yield('content')

    <script>
        // Login validation
        const VALID_EMAIL = "admin@lipamdogo.com";
        const VALID_PASSWORD = "admin123";

        const dashboardUrl = "{{ route('dashboard') }}";

        const loginForm = document.getElementById("loginForm");
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");
        const errorDiv = document.getElementById("errorMessage");
        const errorText = document.getElementById("errorText");
        const rememberCheckbox = document.getElementById("rememberMe");

        function checkSavedSession() {
            const saved = localStorage.getItem("lipamdogo_auth");
            if (saved) {
                try {
                    const data = JSON.parse(saved);
                    if (data.email === VALID_EMAIL && data.remember) {
                        initAdminDashboard(data.email);
                        return true;
                    }
                } catch (e) {}
            }
            if (sessionStorage.getItem("lipamdogo_auth_temp")) {
                initAdminDashboard(VALID_EMAIL);
                return true;
            }
            return false;
        }

        function showError(message) {
            errorText.innerText = message;
            errorDiv.classList.remove("hidden");
            errorDiv.classList.add("shake");
            setTimeout(() => errorDiv.classList.remove("shake"), 500);
        }

        function hideError() {
            errorDiv.classList.add("hidden");
        }

        function validateLogin(email, password) {
            if (!email || !password) {
                showError("Please enter both email and password");
                return false;
            }
            if (email !== VALID_EMAIL) {
                showError("Invalid email address");
                return false;
            }
            if (password !== VALID_PASSWORD) {
                showError("Invalid password");
                return false;
            }
            return true;
        }

        togglePassword.addEventListener("click", () => {
            const type =
                passwordInput.getAttribute("type") === "password" ?
                "text" :
                "password";
            passwordInput.setAttribute("type", type);
            togglePassword.innerHTML =
                type === "password" ?
                '<i class="fas fa-eye"></i>' :
                '<i class="fas fa-eye-slash"></i>';
        });

        //   document
        //     .getElementById("forgotPassword")
        //     .addEventListener("click", (e) => {
        //       e.preventDefault();
        //       alert(
        //         "Password reset link would be sent to your email. Demo: Use admin@lipamdogo.com / admin123",
        //       );
        //     });

        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const email = emailInput.value.trim();
            const password = passwordInput.value;

            if (validateLogin(email, password)) {
                if (rememberCheckbox.checked) {
                    localStorage.setItem(
                        "lipamdogo_auth",
                        JSON.stringify({
                            email: email,
                            remember: true
                        }),
                    );
                } else {
                    sessionStorage.setItem("lipamdogo_auth_temp", "true");
                }

                const btn = document.getElementById("loginBtn");
                btn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i> Signing in...';
                btn.disabled = true;

                setTimeout(() => {
                    window.location.href = dashboardUrl;
                }, 800);
            } else {
                loginForm.classList.add("shake");
                setTimeout(() => loginForm.classList.remove("shake"), 500);
            }
        });

        emailInput.addEventListener("focus", hideError);
        passwordInput.addEventListener("focus", hideError);

        // Check for existing session
        if (!checkSavedSession()) {
            // show login page normally
        }
    </script>
</body>

</html>
