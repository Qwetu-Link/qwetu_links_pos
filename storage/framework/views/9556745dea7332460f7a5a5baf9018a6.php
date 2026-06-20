





<?php $__env->startSection('content'); ?>
    <div class="admin-layout">
        <!-- Mobile Top Bar -->
        <div class="mobile-top-bar" id="mobileTopBar">
            <button id="mobileMenuToggleBtn" class="mobile-menu-btn">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div class="mobile-logo">
                <span class="font-bold text-emerald-600">QwetuLinks</span><span class="text-xs text-gray-500">Enterprise
                    Admin</span>
            </div>
            <div class="w-8"></div>
        </div>

        <!-- Sidebar Fixed -->
        <div class="sidebar-fixed" id="fixedSidebar">
            <div class="p-5 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex-shrink-0 bg-emerald-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-link text-emerald-700 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">
                            Qwetu<span class="text-emerald-600">Links</span>
                        </h1>
                        <p class="text-xs text-gray-500">Enterprise Admin</p>
                    </div>
                </div>
            </div>
            <nav class="p-3 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 140px)">
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="dashboard">
                    <i class="fas fa-chart-line w-5"></i><span>Executive Dashboard</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="category">
                    <i class="fas fa-folder-tree w-5"></i><span>Product Category</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-700 font-semibold"
                    data-tab="catalog">
                    <i class="fas fa-tags w-5"></i><span>Product Catalog</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="variants">
                    <i class="fas fa-cubes w-5"></i><span>Product Variants</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="inventory">
                    <i class="fas fa-boxes w-5"></i><span>Inventory Intelligence</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="orders">
                    <i class="fas fa-tasks w-5"></i><span>Orders Pipeline</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="customers">
                    <i class="fas fa-users w-5"></i><span>Customers Hub</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="transactions">
                    <i class="fas fa-usd w-5"></i><span>Transactions Hub</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="installments">
                    <i class="fas fa-hand-holding-usd w-5"></i><span>Lipa Mdogo Core</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="analytics">
                    <i class="fas fa-chart-pie w-5"></i><span>Analytics Engine</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="reports">
                    <i class="fas fa-file-alt w-5"></i><span>Reports Center</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="settings">
                    <i class="fas fa-cog w-5"></i><span>Settings</span>
                </div>
                <div class="nav-item flex items-center gap-3 px-4 py-2.5  rounded-xl" data-tab="">
                </div>
            </nav>
            <div class="absolute bottom-0 left-0 right-0 p-5 border-t bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-emerald-700"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold">Store Manager</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                    <button id="logoutBtn" class="text-gray-400 hover:text-red-500">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="overlay-backdrop" id="mobileOverlay"></div>

        <!-- Main Content -->
        <div class="main-content-scroll" id="mainScrollArea">
            <div class="p-4 lg:p-8" id="pageRenderer">
                <!-- dynamic content will be injected here -->
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\qwetu_links_pos\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>