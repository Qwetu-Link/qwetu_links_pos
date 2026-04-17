@extends('layouts.app')

@section('title', $seo['title'])

@section('meta')
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    <meta property="og:title" content="{{ $seo['og_title'] }}">
    <meta property="og:description" content="{{ $seo['og_description'] }}">
@endsection

@section('content')

    <!-- Fixed Navbar -->
    <div class="navbar">
        <div class="container">
            <a href="#home" style="display: flex; align-items: center;">
                <img class="logo-img" src="image/qwetu_link_pos.png" alt="Qwetu Link POS Logo">
            </a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#about-us">About Us</a>
                <a href="#features">Features</a>
                <a href="#pricing-plans">Pricing</a>
                <a href="#why">Why Us</a>
                <a href="#contact">Contact</a>
                <a href="#" class="btn-outline">Login / Sign Up</a>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container hero-grid">
            <div class="hero-content fade-up">
                <div class="hero-badge"><i class="fas fa-bolt"></i> Next-gen Point of Sale</div>
                <h1>Qwetu Link POS</h1>
                <h2>Smarter Sales, Faster Growth</h2>
                <p>Modern, cloud-based POS system built for retail, restaurants, and service businesses. Real-time
                    inventory, seamless payments, and actionable insights.</p>
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>99.9%</h3>
                        <p>uptime guaranteed</p>
                    </div>
                    <div class="stat-item">
                        <h3>500+</h3>
                        <p>businesses ready</p>
                    </div>
                </div>
                <button class="btn-primary"
                    onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Request Early
                    Access <i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="hero-image fade-up">
                <i class="fas fa-cash-register"></i>
            </div>
        </div>
    </section>

    <!-- About Us Section (Mission & Vision) -->
    <div class="container" id="about-us">
        <div class="section-title">About Us</div>
        <div class="about-us-grid fade-up">
            <div class="mission-vision-card">
                <i class="fas fa-bullseye"></i>
                <h3>Our Mission</h3>
                <p>To empower African businesses with an intelligent, reliable, and easy-to-use POS system that
                    streamlines operations, boosts sales, and drives growth.</p>
            </div>
            <div class="mission-vision-card">
                <i class="fas fa-eye"></i>
                <h3>Our Vision</h3>
                <p>To become the most trusted point-of-sale ecosystem across Africa, enabling seamless commerce for
                    retailers, restaurants, and service providers.</p>
            </div>
        </div>
        <div class="about-wrapper fade-up" style="margin-top: 0;">
            <div class="about-text">
                <h3 style="margin-bottom: 16px; color: var(--pos-primary);">Who We Are</h3>
                <p>Qwetu Link POS is a product of Qwetu Links, a technology company dedicated to simplifying business
                    operations. We combine deep local knowledge with modern technology to create a POS that works for
                    you — whether you're a small kiosk or a growing chain. Our team is passionate about helping
                    merchants thrive in the digital economy.</p>
            </div>
            <div class="about-image">
                <img src="image/qwetu_link_pos.png" alt="Team Qwetu Link POS">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container" id="features">
        <div class="section-title">Powerful Features</div>
        <div class="features-grid fade-up">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h4>Real-time Analytics</h4>
                <p>Live sales dashboard, profit margins, and top-selling products.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                <h4>Smart Inventory</h4>
                <p>Low stock alerts, auto reordering, and multi-location sync.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-credit-card"></i></div>
                <h4>Flexible Payments</h4>
                <p>Accept M-Pesa, cards, mobile money, and cash – all in one.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h4>Cross-Platform</h4>
                <p>Works on tablet, smartphone, or desktop – online & offline.</p>
            </div>
        </div>
    </div>

    <!-- About / Overview with Image (restored section) -->
    <div class="container" id="about-overview">
        <div class="section-title">Why Qwetu Link POS?</div>
        <div class="about-wrapper fade-up">
            <div class="about-text">
                <h3 style="margin-bottom: 16px; color: var(--pos-primary);">Designed for African Businesses</h3>
                <p>Qwetu Link POS is more than just a cash register – it's a complete business management tool. Built
                    with local challenges in mind: offline capability for unreliable internet, multi-currency support,
                    and easy integration with popular payment gateways. Whether you run a single shop or a chain of
                    stores, our POS grows with you.</p>
                <ul style="margin-top: 20px; list-style: none;">
                    <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: var(--pos-primary);"></i>
                        No long-term contracts – pay as you grow</li>
                    <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: var(--pos-primary);"></i>
                        24/7 local support in English & Swahili</li>
                    <li style="margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: var(--pos-primary);"></i>
                        Free onboarding and training</li>
                </ul>
                <button class="btn-primary" style="margin-top: 24px;"
                    onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Get Started
                    →</button>
            </div>
            <div class="about-image">
                <img src="image/qwetu_link_pos.png" alt="Qwetu Link POS Dashboard">
            </div>
        </div>
    </div>

    <!-- ========== NEW PRICING PLANS SECTION: 4 PACKAGES (cheapest → most expensive) ========== -->
    <div class="container" id="pricing-plans">
        <div class="section-title">Simple, Transparent Pricing</div>
        <div class="pricing-grid fade-up">
            <!-- PACKAGE 1: LITE (Cheapest) -->
            <div class="pricing-card">
                <h3>Lite</h3>
                {{-- <div class="pricing-price">$19<span>/month</span></div> --}}
                <div class="pricing-description">Perfect for small shops & kiosks</div>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Up to 500 transactions/month</li>
                    <li><i class="fas fa-check-circle"></i> Basic sales reports</li>
                    <li><i class="fas fa-check-circle"></i> Cash & mobile money tracking</li>
                    <li><i class="fas fa-check-circle"></i> Single register/location</li>
                    <li><i class="fas fa-times-circle"></i> Inventory management</li>
                    <li><i class="fas fa-times-circle"></i> 24/7 priority support</li>
                </ul>
                <button class="pricing-btn"
                    onclick="alert('✨ Lite plan: start selling smarter. Contact us to activate.')">Start Free Trial
                    →</button>
            </div>

            <!-- PACKAGE 2: STANDARD -->
            <div class="pricing-card">
                <h3>Standard</h3>
                {{-- <div class="pricing-price">$49<span>/month</span></div> --}}
                <div class="pricing-description">Great for growing retail stores</div>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Unlimited transactions</li>
                    <li><i class="fas fa-check-circle"></i> Smart inventory management</li>
                    <li><i class="fas fa-check-circle"></i> Low stock alerts & auto reorder</li>
                    <li><i class="fas fa-check-circle"></i> Customer loyalty tools</li>
                    <li><i class="fas fa-check-circle"></i> Email & chat support</li>
                    <li><i class="fas fa-times-circle"></i> Multi-location sync</li>
                </ul>
                <button class="pricing-btn"
                    onclick="alert('📈 Standard plan: perfect for retailers ready to scale. Get full inventory control.')">Choose
                    Plan</button>
            </div>

            <!-- PACKAGE 3: BUSINESS (MOST POPULAR + RIBBON) -->
            <div class="pricing-card">
                <div class="popular-ribbon"><i class="fas fa-star"></i> Most Popular</div>
                <h3>Business</h3>
                {{-- <div class="pricing-price">$89<span>/month</span></div> --}}
                <div class="pricing-description">Everything for multi-location businesses</div>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Unlimited transactions + locations</li>
                    <li><i class="fas fa-check-circle"></i> Advanced analytics & custom reports</li>
                    <li><i class="fas fa-check-circle"></i> Offline mode with auto-sync</li>
                    <li><i class="fas fa-check-circle"></i> Multi-user roles & permissions</li>
                    <li><i class="fas fa-check-circle"></i> Dedicated account manager</li>
                    <li><i class="fas fa-check-circle"></i> 24/7 priority support (WhatsApp & phone)</li>
                </ul>
                <button class="pricing-btn btn-premium"
                    onclick="alert('🔥 Business plan (Most Popular) – unlimited locations + premium features. Best value for growing chains!')">Upgrade
                    Now</button>
            </div>

            <!-- PACKAGE 4: ENTERPRISE (Most expensive) -->
            <div class="pricing-card">
                <h3>Enterprise</h3>
                {{-- <div class="pricing-price">$179<span>/month</span></div> --}}
                <div class="pricing-description">Custom solutions for large businesses</div>
                <ul class="feature-list">
                    <li><i class="fas fa-check-circle"></i> Everything in Business + custom API</li>
                    <li><i class="fas fa-check-circle"></i> White-glove onboarding & training</li>
                    <li><i class="fas fa-check-circle"></i> ERP & accounting integrations</li>
                    <li><i class="fas fa-check-circle"></i> SLA-based 24/7 support</li>
                    <li><i class="fas fa-check-circle"></i> Custom reporting & AI insights</li>
                    <li><i class="fas fa-check-circle"></i> Bulk SMS & email marketing tools</li>
                </ul>
                <button class="pricing-btn"
                    onclick="alert('🏢 Enterprise plan: contact our sales team for custom deployment and dedicated infrastructure.')">Contact
                    Sales</button>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="container" id="why">
        <div class="section-title">Why Choose Qwetu Link POS?</div>
        <div class="why-grid fade-up">
            <div class="why-card"><i class="fas fa-shield-alt"></i>
                <h4>Secure & Reliable</h4>
                <p>End-to-end encryption, automatic backups, and bank-grade security.</p>
            </div>
            <div class="why-card"><i class="fas fa-charging-station"></i>
                <h4>Offline Mode</h4>
                <p>Keep selling even when the internet is down – syncs automatically.</p>
            </div>
            <div class="why-card"><i class="fas fa-chart-line"></i>
                <h4>Actionable Insights</h4>
                <p>AI-driven suggestions to boost sales and reduce waste.</p>
            </div>
            <div class="why-card"><i class="fas fa-headset"></i>
                <h4>Local Support</h4>
                <p>Phone, WhatsApp, and email support – 7 days a week.</p>
            </div>
        </div>
    </div>

    <!-- Pricing & Call to Action (Early Access) -->
    <div class="container">
        <div class="pricing-cta fade-up">
            <i class="fas fa-gem" style="font-size: 3rem; color: var(--pos-primary); margin-bottom: 16px;"></i>
            <h3>Launching Soon – Be Among the First</h3>
            <p>Sign up for early access and get 3 months free + priority support.</p>
            <button class="btn-large"
                onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Reserve Your Spot <i
                    class="fas fa-calendar-check"></i></button>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container" id="contact">
        <div class="section-title">Get In Touch</div>
        <div class="contact-wrapper fade-up">
            <div class="contact-info">
                <h3>Let’s talk about your business</h3>
                <p>Have questions or want a personalized demo? Our team is ready to help you transform your sales
                    operations.</p>
                <div class="contact-details">
                    <p><i class="fas fa-envelope"></i> info.pos@qwetulinks.co.ke</p>
                    <p><i class="fas fa-phone-alt"></i> +254 </p>
                    <p><i class="fas fa-map-marker-alt"></i> Nairobi, Kenya</p>
                </div>
                <div class="social-icons" style="justify-content: flex-start; margin-top: 20px;">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="contact-form">
                <form id="contactForm">
                    <input type="text" placeholder="Full name" required>
                    <input type="email" placeholder="Email address" required>
                    <input type="text" placeholder="Phone number">
                    <textarea rows="3" placeholder="Tell us about your business or inquiry..."></textarea>
                    <button type="submit">Send Message <i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="container">
        <div class="newsletter fade-up">
            <i class="fas fa-envelope-open-text"
                style="font-size: 2.5rem; color: var(--pos-primary); margin-bottom: 12px;"></i>
            <h3>Get POS updates & launch offers</h3>
            <p>Subscribe to receive product news, tips, and exclusive discounts.</p>
            <form class="news-form" id="subscribeForm">
                <input type="email" placeholder="Your email address" required id="subEmail">
                <button type="submit">Notify Me <i class="fas fa-bell"></i></button>
            </form>
        </div>
    </div>

@endsection
