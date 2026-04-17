<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    
    <title>@yield('title', config('app.name'))</title>

    <!-- SEO Meta Tags -->
    @yield('meta')
    <meta name="author" content="Kodi It Team">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('image/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('image/qwetu_link_pos.png') }}" type="image/png">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'Aptos';
            src: url('/Aptos/Aptos.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        body {
            font-family: 'Aptos', 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            line-height: 1.5;
            font-size: 0.9rem;
            scroll-behavior: smooth;
        }

        /* POS Brand Colors */
        :root {
            --pos-primary: #10b981;
            --pos-bg-light: #f1f5f9;
            --pos-border: #cbd5e1;
            --brand-white: #ffffff;
            --brand-dark: #0f172a;
            --gray-bg: #f8fafc;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* Fixed Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 16px 0;
            transition: all 0.2s;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .logo-img {
            height: 48px;
            width: auto;
            transition: transform 0.2s;
        }

        .logo-img:hover {
            transform: scale(1.02);
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-links a {
            text-decoration: none;
            font-weight: 500;
            color: #1e293b;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--pos-primary);
        }

        .btn-outline {
            border: 1.5px solid var(--pos-primary);
            background: transparent;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 600;
            color: var(--pos-primary);
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: var(--pos-primary);
            color: white !important;
        }

        .btn-login {
            background: var(--pos-primary);
            color: white;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            background: #0e9f6e;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            padding: 120px 0 60px;
            background: linear-gradient(120deg, #f1f5f9 0%, #ffffff 100%);
        }

        .hero-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .hero-content {
            flex: 1;
        }

        .hero-badge {
            background: #d1fae5;
            color: var(--pos-primary);
            display: inline-block;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hero-content h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            background: linear-gradient(to right, #0f172a, var(--pos-primary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #334155;
            margin-bottom: 32px;
            max-width: 550px;
        }

        .hero-stats {
            display: flex;
            gap: 30px;
        }

        .stat-item h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--brand-dark);
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image i {
            font-size: 12rem;
            color: var(--pos-primary);
            opacity: 0.8;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.05));
        }

        .btn-primary {
            display: inline-block;
            background: var(--pos-primary);
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 16px;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #0e9f6e;
            transform: translateY(-2px);
        }

        #home, #about-us, #features, #pricing-plans, #why, #contact {
            scroll-margin-top: 90px;
        }

        /* Section Titles */
        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            text-align: center;
            margin: 60px 0 40px;
            position: relative;
        }

        .section-title:after {
            content: '';
            width: 70px;
            height: 4px;
            background: var(--pos-primary);
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 4px;
        }

        /* About Us (Mission & Vision) */
        .about-us-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 50px;
        }

        .mission-vision-card {
            flex: 1;
            background: white;
            border-radius: 32px;
            padding: 32px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--pos-border);
            transition: 0.2s;
            text-align: center;
        }

        .mission-vision-card i {
            font-size: 2.5rem;
            color: var(--pos-primary);
            margin-bottom: 20px;
        }

        .mission-vision-card h3 {
            font-size: 1.7rem;
            margin-bottom: 16px;
        }

        /* Features Grid */
        .features-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-bottom: 60px;
        }

        .feature-card {
            background: white;
            border-radius: 28px;
            padding: 32px;
            width: 280px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            transition: all 0.2s;
            border: 1px solid var(--pos-border);
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: var(--pos-primary);
        }

        .feature-icon {
            font-size: 2.8rem;
            color: var(--pos-primary);
            margin-bottom: 20px;
        }

        .feature-card h4 {
            font-size: 1.4rem;
            margin-bottom: 12px;
        }

        /* About / Overview with Image (restored) */
        .about-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
            background: var(--pos-bg-light);
            border-radius: 32px;
            padding: 40px;
            margin: 20px 0 40px;
            border-left: 6px solid var(--pos-primary);
        }

        .about-text {
            flex: 1.5;
        }

        .about-image {
            flex: 1;
            text-align: center;
        }

        .about-image img {
            max-width: 100%;
            border-radius: 28px;
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--pos-border);
        }

        /* Why Choose Us */
        .why-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 28px;
            justify-content: center;
            margin-bottom: 60px;
        }

        .why-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 28px;
            width: 260px;
            text-align: center;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--pos-border);
        }

        .why-card i {
            font-size: 2.2rem;
            color: var(--pos-primary);
            margin-bottom: 18px;
        }

        /* ========== NEW PRICING PLANS (4 packages) ========== */
        .pricing-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin: 30px 0 60px;
        }

        .pricing-card {
            flex: 1;
            min-width: 250px;
            background: white;
            border-radius: 32px;
            padding: 32px 24px;
            position: relative;
            transition: all 0.25s ease;
            border: 1px solid var(--pos-border);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04);
            text-align: center;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: var(--pos-primary);
            box-shadow: 0 24px 40px rgba(16, 185, 129, 0.12);
        }

        /* Ribbon style for popular package */
        .popular-ribbon {
            position: absolute;
            top: 18px;
            right: -10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 6px 20px;
            border-radius: 40px 8px 8px 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.5px;
            z-index: 5;
            text-transform: uppercase;
        }

        .popular-ribbon i {
            margin-right: 5px;
            font-size: 0.7rem;
        }

        .pricing-card h3 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 20px 0 8px;
            color: #0f172a;
        }

        .pricing-price {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--pos-primary);
            margin: 16px 0 8px;
        }

        .pricing-price span {
            font-size: 1rem;
            font-weight: 500;
            color: #64748b;
        }

        .pricing-description {
            color: #475569;
            margin-bottom: 24px;
            font-size: 0.85rem;
            border-bottom: 1px dashed var(--pos-border);
            padding-bottom: 16px;
        }

        .feature-list {
            text-align: left;
            margin: 24px 0;
            list-style: none;
        }

        .feature-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            color: #1e293b;
        }

        .feature-list li i.fa-check-circle {
            color: var(--pos-primary);
            width: 20px;
            font-size: 1rem;
        }

        .feature-list li i.fa-times-circle {
            color: #cbd5e1;
            width: 20px;
        }

        .pricing-btn {
            width: 100%;
            background: transparent;
            border: 1.5px solid var(--pos-primary);
            padding: 12px 0;
            border-radius: 60px;
            font-weight: 700;
            color: var(--pos-primary);
            transition: 0.2s;
            cursor: pointer;
            margin-top: 16px;
        }

        .pricing-btn:hover {
            background: var(--pos-primary);
            color: white;
            transform: scale(0.98);
        }

        .btn-premium {
            background: var(--pos-primary);
            color: white;
            border: none;
        }

        .btn-premium:hover {
            background: #0e9f6e;
        }

        /* Original Pricing CTA */
        .pricing-cta {
            background: var(--pos-bg-light);
            border-radius: 48px;
            padding: 56px 40px;
            margin: 60px auto;
            text-align: center;
            border: 1px solid var(--pos-border);
        }

        .btn-large {
            background: var(--pos-primary);
            color: white;
            padding: 14px 36px;
            border-radius: 60px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 20px;
            transition: 0.2s;
        }

        .btn-large:hover {
            background: #0e9f6e;
            transform: translateY(-2px);
        }

        /* Login & Signup Section (dedicated page section) */
        .auth-section {
            background: linear-gradient(135deg, #f8fafc, #ffffff);
            border-radius: 48px;
            padding: 48px 40px;
            margin: 40px auto 60px;
            border: 1px solid var(--pos-border);
        }

        .auth-tabs {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--pos-border);
            padding-bottom: 12px;
        }

        .auth-tab-btn {
            background: none;
            border: none;
            font-size: 1.3rem;
            font-weight: 600;
            padding: 8px 24px;
            cursor: pointer;
            color: #64748b;
            transition: 0.2s;
            position: relative;
        }

        .auth-tab-btn.active {
            color: var(--pos-primary);
        }

        .auth-tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -14px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--pos-primary);
        }

        .auth-pane {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .auth-pane.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-form {
            max-width: 480px;
            margin: 0 auto;
        }

        .auth-form input {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 1px solid var(--pos-border);
            border-radius: 40px;
            font-size: 1rem;
        }

        .auth-form button {
            width: 100%;
            background: var(--pos-primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .auth-form button:hover {
            background: #0e9f6e;
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        /* Contact Section */
        .contact-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background: #f9fafb;
            border-radius: 48px;
            padding: 48px;
            margin: 40px 0 50px;
            border: 1px solid var(--pos-border);
        }

        .contact-info {
            flex: 1;
        }

        .contact-info h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .contact-details {
            margin: 30px 0;
        }

        .contact-details p {
            margin: 16px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .contact-details i {
            width: 28px;
            color: var(--pos-primary);
        }

        .contact-form {
            flex: 1;
            background: white;
            padding: 32px;
            border-radius: 32px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.05);
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 18px;
            border: 1px solid var(--pos-border);
            border-radius: 24px;
            font-family: inherit;
            font-size: 1rem;
        }

        .contact-form button {
            background: var(--pos-primary);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 40px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .contact-form button:hover {
            background: #0e9f6e;
        }

        /* Newsletter */
        .newsletter {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            border-radius: 48px;
            padding: 56px 40px;
            margin: 60px auto;
            text-align: center;
        }

        .news-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-top: 28px;
        }

        .news-form input {
            padding: 14px 24px;
            border-radius: 60px;
            border: none;
            width: 280px;
        }

        .news-form button {
            background: var(--pos-primary);
            border: none;
            padding: 14px 32px;
            border-radius: 60px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            color: white;
        }

        .news-form button:hover {
            background: #0e9f6e;
        }

        .footer {
            text-align: center;
            padding: 40px 0 30px;
            border-top: 1px solid var(--pos-border);
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 28px;
            margin-bottom: 20px;
        }

        .social-icons a {
            color: #5b6e8c;
            font-size: 1.4rem;
            transition: 0.2s;
        }

        .social-icons a:hover {
            color: var(--pos-primary);
        }

        /* Scroll animations */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1), transform 0.8s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 800px) {
            .container {
                padding: 0 24px;
            }

            .hero-content h1 {
                font-size: 2.3rem;
            }

            .navbar .container {
                flex-direction: column;
            }

            .contact-wrapper {
                padding: 28px;
            }

            .about-wrapper {
                flex-direction: column;
            }

            .pricing-card {
                min-width: 280px;
            }

            .popular-ribbon {
                font-size: 0.65rem;
                padding: 4px 16px;
            }
        }
    </style>
</head>

<body>

    @yield('content')

    <footer class="footer container">
        <div class="social-icons">
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
        </div>
        <p>© 2026 Qwetu Link POS — Smart Point of Sale for Modern Business</p>
    </footer>

    <script>
        // Scroll animations
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: "0px 0px -30px 0px"
        });
        fadeElements.forEach(el => observer.observe(el));

        // Newsletter form
        const subForm = document.getElementById('subscribeForm');
        if (subForm) {
            subForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const email = document.getElementById('subEmail').value.trim();
                if (email && email.includes('@')) {
                    alert(`✨ Thanks! ${email} will receive POS launch updates.`);
                    subForm.reset();
                } else {
                    alert('Please enter a valid email address.');
                }
            });
        }

        // Contact form
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('✅ Message received! Our POS specialist will contact you within 24 hours.');
                contactForm.reset();
            });
        }

        // Auth tabs (login/signup) - keep if needed but we removed actual auth panes from DOM for brevity, but script references them safely
        const loginPane = document.getElementById('auth-login');
        const signupPane = document.getElementById('auth-signup');
        if (loginPane && signupPane) {
            const tabBtns = document.querySelectorAll('.auth-tab-btn');
            const switchToSignup = document.getElementById('switchToSignup');
            const switchToLogin = document.getElementById('switchToLogin');

            function switchAuthTab(tab) {
                if (tab === 'login') {
                    loginPane.classList.add('active');
                    signupPane.classList.remove('active');
                    if (tabBtns.length >= 2) {
                        tabBtns[0].classList.add('active');
                        tabBtns[1].classList.remove('active');
                    }
                } else {
                    loginPane.classList.remove('active');
                    signupPane.classList.add('active');
                    if (tabBtns.length >= 2) {
                        tabBtns[0].classList.remove('active');
                        tabBtns[1].classList.add('active');
                    }
                }
            }

            if (tabBtns.length) {
                tabBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const tab = btn.getAttribute('data-auth');
                        switchAuthTab(tab);
                    });
                });
            }
            if (switchToSignup) {
                switchToSignup.addEventListener('click', (e) => {
                    e.preventDefault();
                    switchAuthTab('signup');
                });
            }
            if (switchToLogin) {
                switchToLogin.addEventListener('click', (e) => {
                    e.preventDefault();
                    switchAuthTab('login');
                });
            }

            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            if (loginForm) {
                loginForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    alert('🔐 Demo: POS dashboard will be available after launch. Stay tuned!');
                });
            }
            if (signupForm) {
                signupForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    alert('📝 Demo: Account creation will open soon. Leave your email in the newsletter!');
                });
            }
        }

        // Smooth scroll for navbar links
        document.querySelectorAll('.nav-links a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && href.startsWith('#')) {
                    e.preventDefault();
                    const targetId = href.substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
