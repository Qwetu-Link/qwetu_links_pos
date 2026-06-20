<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>

    <!-- SEO Meta Tags -->
    <?php echo $__env->yieldContent('meta'); ?>
    <meta name="author" content="Qwetu Link Team">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('image/favicon.ico')); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo e(asset('image/qwetu_link_pos.png')); ?>" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: "Inter", sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            margin: 0;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            z-index: 50;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .main-content-scroll {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            overflow-y: auto;
        }

        /* Mobile styles */
        .mobile-top-bar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            z-index: 60;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            color: #0f172a;
        }

        .mobile-menu-btn:hover {
            background: #f1f5f9;
        }

        .mobile-logo {
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1.2;
        }

        @media (max-width: 768px) {
            .mobile-top-bar {
                display: flex;
                z-index: 60;
            }

            .main-content-scroll {
                margin-left: 0;
                margin-top: 60px;
            }

            .sidebar-fixed {
                transform: translateX(-100%);
                width: 280px;
                z-index: 70;
            }

            .sidebar-fixed.mobile-open {
                transform: translateX(0);
            }

            .overlay-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 45;
                display: none;
            }

            .overlay-backdrop.active {
                display: block;
            }
        }

        .nav-item {
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-item.active {
            background-color: #ecfdf5;
            color: #047857;
            font-weight: 600;
        }

        .main-content-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .main-content-scroll::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .main-content-scroll::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        .fade-in {
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Simple card styling for placeholders */
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>

    <script>
        // ---------- PAGE RENDER FUNCTIONS (placeholder content) ----------
        function renderDashboard() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-6"><i class="fas fa-chart-line text-emerald-600 mr-2"></i>Executive Dashboard</h1>
        <div class="mt-8 stat-card"><p class="text-gray-600">Welcome to QwetuLinks Admin – real‑time KPIs and alerts.</p></div>
      </div>
    `;
        }

        function renderCatalog() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-tags text-emerald-600 mr-2"></i>Product Catalog</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Manage your products, variants, and pricing.</p>
        </div>
      </div>
    `;
        }

        function renderVariants() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-cubes text-emerald-600 mr-2"></i>Product Variants</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Manage SKU, color, size, and stock per variant.</p>
          <div class="mt-4 text-sm text-gray-500">Variant table / cards go here.</div>
        </div>
      </div>
    `;
        }

        function renderInventory() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-boxes text-emerald-600 mr-2"></i>Inventory Intelligence</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Multi‑location stock levels, low stock alerts, and reorder triggers.</p>
          <div class="grid grid-cols-2 gap-4 mt-4"><div class="p-4 bg-green-50 rounded-lg">Healthy SKUs: 42</div><div class="p-4 bg-amber-50 rounded-lg">Low Stock: 12</div></div>
        </div>
      </div>
    `;
        }

        function renderOrders() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-tasks text-emerald-600 mr-2"></i>Orders Pipeline</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Track, filter and manage customer orders.</p>
          <div class="overflow-x-auto mt-4"><table class="min-w-full text-sm"><thead class="bg-gray-50"><tr><th class="p-3 text-left">Order ID</th><th class="p-3 text-left">Status</th><th class="p-3 text-left">Total</th></tr></thead><tbody><tr><td class="p-3">ORD-001</td><td><span class="bg-amber-100 px-2 py-1 rounded-full">Pending</span></td><td>KES 12,450</td></tr></tbody></table></div>
        </div>
      </div>
    `;
        }

        function renderCustomers() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-users text-emerald-600 mr-2"></i>Customers Hub</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Customer profiles, segments, and payment scores.</p>
          <div class="mt-4 flex gap-2"><input type="text" placeholder="Search customers..." class="border rounded-lg px-4 py-2 w-full max-w-sm"><button class="bg-emerald-600 text-white px-4 py-2 rounded-lg">Search</button></div>
        </div>
      </div>
    `;
        }

        function renderTransactions() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-usd text-emerald-600 mr-2"></i>Transactions Hub</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">View payments, expenses, and reconciliation.</p>
          <button class="mt-4 bg-emerald-600 text-white px-4 py-2 rounded-lg">+ New Transaction</button>
        </div>
      </div>
    `;
        }

        function renderInstallments() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-hand-holding-usd text-emerald-600 mr-2"></i>Lipa Mdogo Core</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Payment plans, installment tracking, collections dashboard.</p>
          <div class="grid grid-cols-2 gap-4 mt-4"><div class="p-3 bg-green-50">Active Plans: 24</div><div class="p-3 bg-red-50">Overdue: 5</div></div>
        </div>
      </div>
    `;
        }

        function renderAnalytics() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-chart-pie text-emerald-600 mr-2"></i>Analytics Engine</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Revenue trends, sales by category, customer insights.</p>
          <div class="h-48 flex items-center justify-center bg-gray-50 mt-4 rounded-lg"><i class="fas fa-chart-line text-3xl text-gray-400"></i><span class="ml-2 text-gray-500">Chart placeholder</span></div>
        </div>
      </div>
    `;
        }

        function renderReports() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-file-alt text-emerald-600 mr-2"></i>Reports Center</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">Export and generate business reports.</p>
          <button class="mt-4 bg-gray-800 text-white px-4 py-2 rounded-lg">Download CSV</button>
        </div>
      </div>
    `;
        }

        function renderSettings() {
            return `
      <div class="fade-in">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-cog text-emerald-600 mr-2"></i>Settings</h1>
        <div class="bg-white rounded-xl p-6 border shadow-sm">
          <p class="text-gray-600">General, user, and system preferences.</p>
          <div class="mt-4 space-y-2"><label class="block">Company Name: <input type="text" class="border rounded p-2 w-full" placeholder="QwetuLinks"></label></div>
        </div>
      </div>
    `;
        }

        // Map each tab to its render function
        const pageMap = {
            dashboard: renderDashboard,
            catalog: renderCatalog,
            variants: renderVariants,
            inventory: renderInventory,
            orders: renderOrders,
            customers: renderCustomers,
            transactions: renderTransactions,
            installments: renderInstallments,
            analytics: renderAnalytics,
            reports: renderReports,
            settings: renderSettings,
        };

        let currentTab = "dashboard";

        function renderCurrentTab() {
            const renderer = pageMap[currentTab];
            const container = document.getElementById("pageRenderer");
            if (container && renderer) {
                container.innerHTML = renderer();
            } else if (container) {
                container.innerHTML =
                    `<div class="bg-white rounded-xl p-6 text-center text-gray-500">Page not found.</div>`;
            }
        }

        // Sidebar navigation: update active class and call renderCurrentTab
        function initNavigation() {
            const navItems = document.querySelectorAll(".nav-item");
            navItems.forEach((item) => {
                item.addEventListener("click", () => {
                    const tab = item.getAttribute("data-tab");
                    if (tab && pageMap[tab]) {
                        // Update active class
                        navItems.forEach((nav) => nav.classList.remove("active"));
                        item.classList.add("active");
                        currentTab = tab;
                        renderCurrentTab();
                        // Close mobile sidebar after navigation
                        if (window.innerWidth <= 768) closeMobileSidebar();
                    }
                });
            });
            // Set default active
            const defaultItem = document.querySelector(
                '.nav-item[data-tab="dashboard"]',
            );
            if (defaultItem) defaultItem.classList.add("active");
            renderCurrentTab();
        }

        // Mobile sidebar toggle
        function initMobileSidebar() {
            const sidebar = document.getElementById("fixedSidebar");
            const toggleBtn = document.getElementById("mobileMenuToggleBtn");
            const overlay = document.getElementById("mobileOverlay");
            if (!sidebar || !toggleBtn || !overlay) return;

            const openMobile = () => {
                sidebar.classList.add("mobile-open");
                overlay.classList.add("active");
                document.body.style.overflow = "hidden";
            };
            const closeMobile = () => {
                sidebar.classList.remove("mobile-open");
                overlay.classList.remove("active");
                document.body.style.overflow = "";
            };
            window.closeMobileSidebar = closeMobile;
            toggleBtn.addEventListener("click", openMobile);
            overlay.addEventListener("click", closeMobile);
            document
                .querySelectorAll(".nav-item")
                .forEach((link) => link.addEventListener("click", closeMobile));
        }

        // Optional logout demo button
        function initLogout() {
            const logoutBtn = document.getElementById("logoutBtn");
            if (logoutBtn) {
                logoutBtn.addEventListener("click", () => {
                    alert("Demo logout – you can integrate your own auth logic.");
                });
            }
        }

        // Initialise everything
        document.addEventListener("DOMContentLoaded", () => {
            initNavigation();
            initMobileSidebar();
            initLogout();
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\qwetu_links_pos\resources\views/layouts/helper/sidebar.blade.php ENDPATH**/ ?>