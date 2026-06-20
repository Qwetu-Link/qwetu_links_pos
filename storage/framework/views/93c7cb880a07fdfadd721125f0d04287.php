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
            background: linear-gradient(135deg, #f0f4f8 0%, #e8edf3 100%);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
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

        .modal-transition {
            transition: opacity 0.2s ease;
        }

        .product-card {
            transition: all 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }

        .product-image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 1rem;
            transition: all 0.2s;
            cursor: pointer;
            background: #f8fafc;
        }

        .file-upload-area:hover {
            border-color: #10b981;
            background: #f0fdf4;
        }

        .image-preview-circle {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid white;
        }

        .scrollbar-custom::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-custom::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Product step indicator styles */
        .variant-item {
            transition: all 0.2s;
        }

        .step-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .step {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #475569;
        }

        .step.active {
            background: #10b981;
            color: white;
        }

        .step.completed {
            background: #059669;
            color: white;
        }
    </style>
</head>

<body class="antialiased p-4 md:p-6">
    <?php echo $__env->yieldContent('content'); ?>

    <script>
        // ==================== STANDALONE PRODUCT CATALOG MODULE ====================
        // Full product management with image upload (local storage persistence)
        // Independent, can be dropped into Laravel blade or any project.

        (function() {
            // ---------- DATA ----------
            let inventoryProducts = [];
            let deleteTargetId = null;
            let currentImageDataURL = null;

            //pagination state
            var productCurrentPage = 1;
            var productPerPage = 10;
            var productFilteredItems = [];

            // Load initial data
            async function loadInitialData() {
                try {
                    // 1. Load from localStorage first (fast)
                    let allProducts = localStorage.getItem("qwetulinks_products");

                    if (allProducts) {
                        inventoryProducts = JSON.parse(allProducts);
                    } else {
                        // 2. Fetch fresh data from JSON file
                        const res = await fetch("../data/qwetulinks_inventory.json");

                        if (!res.ok) {
                            throw new Error("Failed to load Product JSON file");
                        }
                        const proddata = await res.json();

                        inventoryProducts = proddata.products;
                        console.log("Fetched inventory data:", inventoryProducts);
                        // 3. Update cache
                        localStorage.setItem(
                            "qwetulinks_products",
                            JSON.stringify(inventoryProducts),
                        );
                    }
                } catch (error) {
                    console.error("Error loading inventory:", error);
                }
            }

            function generateProductId() {
                if (inventoryProducts.length === 0) return "PRD-0001";
                // Extract the numeric part from "PRD-0001" style IDs and increment
                const maxNum = inventoryProducts.reduce((max, p) => {
                    const num = parseInt(p.id.replace(/\D/g, "")) || 0;
                    return Math.max(max, num);
                }, 0);
                return `PRD-${String(maxNum + 1).padStart(4, "0")}`;
            }

            function generateVariantId(productId) {
                return `var_${productId}_${Date.now()}_${Math.floor(Math.random() * 1000)}`;
            }

            function autoGenerateSku(productName, color, size) {
                let prefix = productName
                    .substring(0, 3)
                    .toUpperCase()
                    .replace(/[^A-Z]/g, "");
                if (prefix.length < 2) prefix = "PRD";
                const col = (color || "DEF").substring(0, 3).toUpperCase();
                const sz = String(size || "").toUpperCase();
                return `${prefix}-${col}-${sz}`;
            }

            function getAllVariants() {
                let variants = [];
                inventoryProducts.forEach((product) => {
                    product.variants.forEach((v) =>
                        variants.push({
                            ...v,
                            productName: product.name,
                            productId: product.id,
                            productImage: product.imageUrl,
                        }),
                    );
                });
                return variants;
            }

            function formatCurrency(amount) {
                return new Intl.NumberFormat("en-KE", {
                    style: "currency",
                    currency: "KES",
                    minimumFractionDigits: 0,
                }).format(amount);
            }

            function formatCompactCurrency(amount) {
                if (amount >= 1000000) return `KES ${(amount / 1000000).toFixed(1)}M`;
                if (amount >= 1000) return `KES ${(amount / 1000).toFixed(0)}K`;
                return `KES ${amount}`;
            }

            function escapeHtml(str = "") {
                return String(str)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function getProductImageSrc(product) {
                if (product.imageData && product.imageData.startsWith("data:image"))
                    return product.imageData;
                if (product.imageUrl && product.imageUrl.trim())
                    return product.imageUrl;
                return "https://via.placeholder.com/60x60?text=No+Img";
            }

            // CRUD Operations
            function addProduct(productData) {
                const newProduct = {
                    id: generateProductId(),
                    name: productData.name,
                    category: productData.category,
                    buyPrice: productData.buyPrice,
                    sellPrice: productData.sellPrice,
                    stock: productData.stock,
                    size: productData.size,
                    supplier: productData.supplier || "",
                    description: productData.description || "",
                    imageData: productData.imageData || null,
                    imageUrl: productData.imageUrl || null,
                };
                products.unshift(newProduct);
                persistData();
                return newProduct;
            }

            //function update product
            function updateProduct(id, productData) {
                const index = products.findIndex((p) => p.id === id);
                if (index !== -1) {
                    products[index] = {
                        ...products[index],
                        ...productData,
                        id: id
                    };
                    persistData();
                    return products[index];
                }
                return null;
            }

            //function del product
            function deleteProduct(id) {
                inventoryProducts = inventoryProducts.filter((p) => p.id != id);
                // persistData();
            }

            // Render Main UI
            function renderCatalog() {
                const products = inventoryProducts;

                // Flatten all variants
                const variants = products.flatMap((p) => p.variants);

                // 1. Total variants (not products)
                const totalProducts = products.length;

                // 2. Total inventory value (sellPrice * totalStock)
                const totalValue = variants.reduce(
                    (sum, v) => sum + v.sellPrice * v.inventory.totalStock,
                    0,
                );

                // 3. Average sell price (per variant)
                const avgPrice = variants.length ?
                    variants.reduce((sum, v) => sum + v.sellPrice, 0) / variants.length :
                    0;

                // 4. Low stock count (totalStock <= 10)
                const lowStockCount = variants.filter(
                    (v) => v.inventory.totalStock <= 10,
                ).length;

                return `
              <div class="space-y-6 fade-in">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                  <div>
                    <h1 class="text-3xl font-bold text-gray-800"><i class="fas fa-tags text-emerald-600 mr-2"></i>Product Catalog</h1>
                    <p class="text-gray-500 mt-1">Manage your inventory, products, and pricing</p>
                  </div>
                  <div class="flex gap-2">
                    <button id="addProductBtn" class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition flex items-center gap-2"><i class="fas fa-plus-circle"></i> Add Product</button>
                    <button id="exportCatalogBtn" class="px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center gap-2"><i class="fas fa-download"></i> Export CSV</button>
                  </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                  <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-blue-600 mb-2"><i class="fas fa-box"></i><p class="text-sm font-medium">Total Products</p></div><p class="text-2xl font-bold">${totalProducts}</p></div>
                  <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-emerald-600 mb-2"><i class="fas fa-chart-line"></i><p class="text-sm font-medium">Inventory Value</p></div><p class="text-2xl font-bold">${formatCurrency(totalValue)}</p></div>
                  <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-purple-600 mb-2"><i class="fas fa-receipt"></i><p class="text-sm font-medium">Avg. Price</p></div><p class="text-2xl font-bold">${formatCurrency(Math.round(avgPrice))}</p></div>
                  <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-amber-600 mb-2"><i class="fas fa-exclamation-triangle"></i><p class="text-sm font-medium">Low Stock Items</p></div><p class="text-2xl font-bold text-amber-600">${lowStockCount}</p></div>
                </div>

                <!-- Search & Filter -->
                <div class="bg-white rounded-xl border p-4 shadow-sm">
                  <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1 relative"><i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i><input type="text" id="searchProductInput" placeholder="Search by product name, category, or supplier..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500"></div>
                    <div><select id="categoryFilterSelect" class="px-4 py-2.5 border border-gray-200 rounded-xl bg-white"><option value="all">All Categories</option><option>Men's Clothing</option><option>Women's Clothing</option><option>Accessories</option><option>Footwear</option><option>Kids Wear</option><option>Outerwear</option></select></div>
                  </div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="productsGridContainer"></div>

                <!-- Footer -->
                ${products.length > 0
            ? `
        <div class="bg-white rounded-xl p-4 flex flex-wrap justify-between items-center text-sm border mt-4">
          
          <!-- Left -->
          <div id="paginationInfo" class="text-gray-500">
          </div>

          <!-- Center -->
          <div id="paginationControls" class="flex items-center gap-1">
            <button class="px-2 py-1 bg-emerald-600 text-white rounded" data-page="first">«</button>
            <button class="px-2 py-1 bg-emerald-600 text-white rounded" data-page="prev">‹</button>

            <div id="pageNumbers" class="flex gap-1"></div>

            <button class="px-2 py-1 bg-emerald-600 text-white rounded" data-page="next">›</button>
            <button class="px-2 py-1 bg-emerald-600 text-white rounded" data-page="last">»</button>
          </div>

          <!-- Right -->
          <div>
            <select id="itemsPerPage" class="border rounded px-2 py-1">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <span class="text-gray-500">Items per page</span>
          </div>
        </div>
        `
            : ""
          }
              </div>
            `;
            }

            // function renderCatalogUI() {
            //   const totalProducts = products.length;
            //   const totalValue = products.reduce(
            //     (sum, p) => sum + p.sellPrice * p.stock,
            //     0,
            //   );
            //   const avgPrice = products.length
            //     ? products.reduce((sum, p) => sum + p.sellPrice, 0) /
            //       products.length
            //     : 0;
            //   const lowStockCount = products.filter((p) => p.stock <= 10).length;

            //   return `
        //   <div class="space-y-6 fade-in">
        //     <!-- Header -->
        //     <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        //       <div>
        //         <h1 class="text-3xl font-bold text-gray-800"><i class="fas fa-tags text-emerald-600 mr-2"></i>Product Catalog</h1>
        //         <p class="text-gray-500 mt-1">Manage your inventory, products, and pricing</p>
        //       </div>
        //       <div class="flex gap-2">
        //         <button id="addProductBtn" class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition flex items-center gap-2"><i class="fas fa-plus-circle"></i> Add Product</button>
        //         <button id="exportCatalogBtn" class="px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition flex items-center gap-2"><i class="fas fa-download"></i> Export CSV</button>
        //       </div>
        //     </div>

        //     <!-- Stats Cards -->
        //     <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        //       <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-blue-600 mb-2"><i class="fas fa-box"></i><p class="text-sm font-medium">Total Products</p></div><p class="text-2xl font-bold">${totalProducts}</p></div>
        //       <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-emerald-600 mb-2"><i class="fas fa-chart-line"></i><p class="text-sm font-medium">Inventory Value</p></div><p class="text-2xl font-bold">${formatCurrency(totalValue)}</p></div>
        //       <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-purple-600 mb-2"><i class="fas fa-receipt"></i><p class="text-sm font-medium">Avg. Price</p></div><p class="text-2xl font-bold">${formatCurrency(Math.round(avgPrice))}</p></div>
        //       <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-amber-600 mb-2"><i class="fas fa-exclamation-triangle"></i><p class="text-sm font-medium">Low Stock Items</p></div><p class="text-2xl font-bold text-amber-600">${lowStockCount}</p></div>
        //     </div>

        //     <!-- Search & Filter -->
        //     <div class="bg-white rounded-xl border p-4 shadow-sm">
        //       <div class="flex flex-col lg:flex-row gap-4">
        //         <div class="flex-1 relative"><i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i><input type="text" id="searchProductInput" placeholder="Search by product name, category, or supplier..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500"></div>
        //         <div><select id="categoryFilterSelect" class="px-4 py-2.5 border border-gray-200 rounded-xl bg-white"><option value="all">All Categories</option><option>Men's Clothing</option><option>Women's Clothing</option><option>Accessories</option><option>Footwear</option><option>Kids Wear</option><option>Outerwear</option></select></div>
        //       </div>
        //     </div>

        //     <!-- Products Grid -->
        //     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="productsGridContainer"></div>

        //     <!-- Footer -->
        //     <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-4 text-sm text-gray-700 border border-emerald-100 flex justify-between items-center flex-wrap gap-2">
        //       <span><i class="fas fa-database text-emerald-600 mr-2"></i>${totalProducts} products in catalog | Last updated: ${new Date().toLocaleString()}</span>
        //       <span class="text-xs text-gray-500">Data persists in browser storage</span>
        //     </div>
        //   </div>
        // `;
            // }

            function renderProductsGrid(filteredProducts) {
                const container = document.getElementById("productsGridContainer");
                if (!container) return;
                if (filteredProducts.length === 0) {
                    container.innerHTML =
                        '<div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-xl border"><i class="fas fa-box-open text-4xl mb-3 opacity-50"></i><p>No products found. Click "Add Product" to get started.</p></div>';
                    return;
                }

                container.innerHTML = filteredProducts
                    .map((product) => {
                        // Total stock across all variants
                        const totalStock = product.variants.reduce(
                            (sum, v) => sum + v.inventory.totalStock,
                            0,
                        );

                        //  unique variant  sizes (remove duplicates)
                        const uniqueSizes = [
                            ...new Set(product.variants.map((v) => v.size)),
                        ];
                        return `
              <div class="product-card bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all">
                <div class="relative h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
                  <img src="${getProductImageSrc(product)}" alt="${escapeHtml(product.name)}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/200?text=Product'">
                  ${totalStock <= 10 ? `<div class="absolute top-2 right-2 bg-amber-500 text-white text-xs px-2 py-1 rounded-full"><i class="fas fa-exclamation-triangle mr-1"></i>Low Stock</div>` : ""}
                </div>
                <div class="p-4">
                  <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-gray-800 text-lg leading-tight">${escapeHtml(product.name)}</h3>
                    <div class="flex -space-x-2">
                    ${uniqueSizes
                .map(
                  (size, index) => `
                                  <span class="text-xs bg-gray-100 px-2 py-1 rounded-full text-gray-600 border border-white z-[${10 - index}]">
                                    ${size}
                                  </span>
                                `,
                )
                .join("")}
                  </div>
                  </div>
                  <p class="text-sm text-gray-500 mb-2">${product.category}  ${product.brand ? "• " + product.brand : ""}</p>
                  <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-1"><i class="fas fa-boxes text-gray-400 text-sm"></i><span class="text-sm font-medium ${totalStock <= 10 ? "text-amber-600" : "text-gray-700"}">Stock: ${totalStock} units</span></div>
                  </div>
                  <div class="flex gap-2">
                    <button class="editProductBtn flex-1 px-3 py-2 text-sm text-blue-500 border border-blue-500 rounded-lg hover:bg-blue-100 transition font-medium" data-id="${product.id}"><i class="fas fa-edit mr-1"></i> Edit</button>
                    <button class="deleteProductBtn flex-1 px-3 py-2 text-sm border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition font-medium" data-id="${product.id}" data-name="${escapeHtml(product.name)}"><i class="fas fa-trash-alt mr-1"></i> Delete</button>
                  </div>
                </div>
              </div>
            `;
                    })
                    .join("");

                // Attach event listeners to buttons
                document.querySelectorAll(".editProductBtn").forEach((btn) => {
                    btn.addEventListener("click", (e) => {
                        const id = btn.dataset.id;
                        openProductModal(id);
                        // document
                    });
                });
                document.querySelectorAll(".deleteProductBtn").forEach((btn) => {
                    btn.addEventListener("click", (e) => {
                        deleteTargetId = btn.dataset.id;
                        name = btn.dataset.name;
                        document.getElementById("deleteModal").classList.remove("hidden");
                        document.getElementById("deleteModal").classList.add("flex");
                        document.getElementById("deleteName").innerText =
                            `Are you sure you want to delete product (${name})?`;
                    });
                });
            }

            //Product Filtering Logic
            function filterProducts() {
                const searchTerm =
                    document.getElementById("searchProductInput")?.value.toLowerCase() ||
                    "";
                const categoryFilter =
                    document.getElementById("categoryFilterSelect")?.value || "all";
                let filtered = [...inventoryProducts];
                if (searchTerm) {
                    filtered = filtered.filter(
                        (p) =>
                        p.name.toLowerCase().includes(searchTerm) ||
                        (p.category && p.category.toLowerCase().includes(searchTerm)) ||
                        (p.supplier && p.supplier.toLowerCase().includes(searchTerm)),
                    );
                }
                if (categoryFilter !== "all") {
                    filtered = filtered.filter((p) => p.category === categoryFilter);
                }
                productFilteredItems = filtered;
                productCurrentPage = 1;
                renderProductPage();
                ''
            }

            function renderProductPage() {
                var start = (productCurrentPage - 1) * productPerPage;
                var paginated = productFilteredItems.slice(
                    start,
                    start + productPerPage,
                );
                renderProductsGrid(paginated);
                updateProductPaginationUI();
            }

            function updateProductPaginationUI() {
                var total = productFilteredItems.length;
                var totalPages = Math.ceil(total / productPerPage) || 1;
                if (productCurrentPage > totalPages) productCurrentPage = totalPages;
                var start = (productCurrentPage - 1) * productPerPage + 1;
                var end = Math.min(productCurrentPage * productPerPage, total);

                var info = document.getElementById("paginationInfo");
                if (info)
                    info.textContent =
                    (total === 0 ? "0" : start) +
                    "\u2013" +
                    end +
                    " of " +
                    total +
                    " items";

                var pageNumbers = document.getElementById("pageNumbers");
                if (pageNumbers) {
                    pageNumbers.innerHTML = "";
                    var maxV = 5;
                    var sp = Math.max(1, productCurrentPage - Math.floor(maxV / 2));
                    var ep = Math.min(totalPages, sp + maxV - 1);
                    if (ep - sp < maxV - 1) sp = Math.max(1, ep - maxV + 1);
                    for (var i = sp; i <= ep; i++) {
                        (function(pageNum) {
                            var btn = document.createElement("button");
                            btn.textContent = pageNum;
                            btn.className =
                                "px-2 py-1 rounded text-sm " +
                                (pageNum === productCurrentPage ?
                                    "bg-emerald-600 text-white" :
                                    "bg-gray-200 hover:bg-gray-300");
                            btn.onclick = function() {
                                productCurrentPage = pageNum;
                                renderProductPage();
                            };
                            pageNumbers.appendChild(btn);
                        })(i);
                    }
                }

                // Arrow buttons
                document.querySelectorAll("[data-page]").forEach(function(btn) {
                    btn.onclick = function() {
                        var tp =
                            Math.ceil(productFilteredItems.length / productPerPage) || 1;
                        var action = btn.dataset.page;
                        if (action === "first") productCurrentPage = 1;
                        if (action === "prev" && productCurrentPage > 1)
                            productCurrentPage--;
                        if (action === "next" && productCurrentPage < tp)
                            productCurrentPage++;
                        if (action === "last") productCurrentPage = tp;
                        renderProductPage();
                    };
                });

                var pps = document.getElementById("itemsPerPage");
                if (pps && !pps._patchedChange) {
                    pps._patchedChange = true;
                    pps.value = String(productPerPage);
                    pps.onchange = function(e) {
                        productPerPage = Number(e.target.value);
                        productCurrentPage = 1;
                        renderProductPage();
                    };
                }
            }

            function getAllVariants() {
                let list = [];
                inventoryProducts.forEach((p) => {
                    p.variants.forEach((v) => {
                        list.push({
                            ...v,
                            productName: p.name,
                            productId: p.id,
                            productCategory: p.category,
                        });
                    });
                });
                return list;
            }

            // Product modal with step handling
            let currentEditingProductId = null;
            let tempVariants = []; // used when editing existing product or creating new


            // Modal Functions
            function openProductModal(productId) {
                currentImageDataURL = null;
                document
                    .getElementById("imagePreviewContainer")
                    .classList.add("hidden");
                document.getElementById("prodImageFile").value = "";

                currentEditingProductId = productId != null ? productId : null;

                const product =
                    productId != null ?
                    inventoryProducts.find((p) => p.id == productId) :
                    null;

                document.getElementById("modalTitle").innerHTML = product ?
                    '<i class="fas fa-edit text-emerald-600 mr-2"></i>Edit Product' :
                    '<i class="fas fa-plus-circle text-emerald-600 mr-2"></i>Add New Product';

                document.getElementById("productForm").reset();
                document.getElementById("productId").value = product?.id ?? "";
                document.getElementById("prodName").value = product?.name ?? "";
                document.getElementById("prodCategory").value =
                    product?.category ?? "Men's Clothing";
                document.getElementById("prodBrand").value = product?.brand ?? "";
                document.getElementById("prodDesc").value = product?.description ?? "";

                // Safe image handling — only runs when product exists
                if (product) {
                    if (product.imageData?.startsWith("data:")) {
                        currentImageDataURL = product.imageData;
                        showImagePreview(currentImageDataURL, "product_image");
                    } else if (product.imageUrl) {
                        currentImageDataURL = product.imageUrl;
                        showImagePreview(product.imageUrl, "from_url");
                    }
                }

                tempVariants = product ?
                    JSON.parse(JSON.stringify(product.variants)) : [];
                renderVariantsList();

                showStep1();
                document.getElementById("productModal").classList.remove("hidden");
            }

            function renderVariantsList() {
                const container = document.getElementById("variantsListContainer");
                if (!container) return;
                if (tempVariants.length === 0) {
                    container.innerHTML =
                        '<div class="text-center text-gray-400 py-8"><i class="fas fa-cubes text-3xl mb-2"></i><p>No variants yet. Click "Add Variant" to create one.</p></div>';
                    return;
                }
                container.innerHTML = tempVariants
                    .map(
                        (v, idx) => `
        <div class="variant-item bg-white border rounded-xl p-4 flex flex-wrap justify-between items-center">
          <div><span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">${v.sku}</span><div class="mt-1"><span class="font-medium">${v.color} / ${v.size}</span> | Buy: KES ${v.buyPrice} Sell: KES ${v.sellPrice}</div><div class="text-xs text-gray-500">Main stock: ${v.inventory.locations.find((l) => l.name === "Main Store")?.stock || 0} | Total stock: ${v.inventory.totalStock}</div></div>
          <div class="flex gap-2"><button class="deleteTempVariantBtn text-red-600 px-2 py-1 rounded" data-idx="${idx}"><i class="fas fa-trash-alt"></i> Delete</button></div>
        </div>
      `,
                    )
                    .join("");

                document.querySelectorAll(".deleteTempVariantBtn").forEach((btn) =>
                    btn.addEventListener("click", (e) => {
                        const idx = parseInt(btn.dataset.idx);
                        tempVariants.splice(idx, 1);
                        renderVariantsList();
                    }),
                );
            }

            function computeVariantInventory(variant) {
                const inv = variant.inventory;
                const total = inv.locations.reduce((sum, loc) => sum + loc.stock, 0);
                inv.totalStock = total;
                if (total === 0) inv.status = "reorder";
                else if (total <= 5) inv.status = "critical";
                else if (total <= inv.reorderPoint) inv.status = "low";
                else inv.status = "healthy";
                return inv;
            }

            function addNewVariantFromModal() {
                const productName = document.getElementById("prodName").value.trim();
                if (!productName) {
                    alert("Please fill product name first");
                    return;
                }
                const category = document.getElementById("prodCategory").value;
                const color = document.getElementById("newVariantColor").value.trim();
                const size = document.getElementById("newVariantSizeSelect")?.value;
                const sku = autoGenerateSku(productName, color, size);
                const buyPrice = parseFloat(
                    document.getElementById("newVariantBuyPrice").value,
                );
                const sellPrice = parseFloat(
                    document.getElementById("newVariantSellPrice").value,
                );
                const mainStock =
                    parseInt(document.getElementById("newVariantMainStock").value) || 0;
                if (!color || !size) {
                    alert("Color and size are required");
                    return;
                }
                // Create variant with Main Store stock = mainStock, others 0
                const newVariant = {
                    id: generateVariantId(),
                    sku: sku,
                    color: color,
                    size: size,
                    buyPrice: buyPrice,
                    sellPrice: sellPrice,
                    inventory: {
                        totalStock: mainStock,
                        reorderPoint: 10,
                        status: mainStock === 0 ? "reorder" : "healthy",
                        lastRestocked: new Date().toISOString().slice(0, 10),
                        locations: [{
                                name: "Main Store",
                                stock: mainStock,
                                reorderPoint: 5
                            },
                            {
                                name: "Warehouse A",
                                stock: 0,
                                reorderPoint: 5
                            },
                            {
                                name: "Outlet",
                                stock: 0,
                                reorderPoint: 5
                            },
                        ],
                    },
                };
                computeVariantInventory(newVariant);
                tempVariants.push(newVariant);
                renderVariantsList();
                document.getElementById("addVariantModal").classList.add("hidden");
                document.getElementById("newVariantColor").value = "";
                document.getElementById("newVariantMainStock").value = 0;
                document.getElementById("newVariantSku").value = "";
            }

            function showImagePreview(src, filename) {
                const container = document.getElementById("imagePreviewContainer");
                document.getElementById("imagePreviewLocal").src = src;
                document.getElementById("previewFileName").innerText = filename;
                container.classList.remove("hidden");
            }

            function closeProductModal() {
                document.getElementById("productModal").classList.add("hidden");
                currentImageDataURL = null;
            }

            function saveProductFromForm() {
                const name = document.getElementById("prodName").value.trim();
                if (!name) return alert("Product name required");
                if (tempVariants.length === 0)
                    return alert("Please add at least one variant");

                const productData = {
                    name,
                    category: document.getElementById("prodCategory").value,
                    brand: document.getElementById("prodBrand").value.trim(),
                    description: document.getElementById("prodDesc").value,
                    imageData: currentImageDataURL?.startsWith("data:") ?
                        currentImageDataURL : null,
                    imageUrl:
                        !currentImageDataURL || !currentImageDataURL.startsWith("data:") ?
                        currentImageDataURL || "" : null,
                    variants: tempVariants,
                };

                if (currentEditingProductId) {
                    const index = inventoryProducts.findIndex(
                        (p) => p.id === currentEditingProductId,
                    );
                    if (index !== -1) {
                        inventoryProducts[index] = {
                            ...inventoryProducts[index],
                            ...productData,
                            id: currentEditingProductId,
                        };
                        alert(`Product "${name}" updated.`);
                    }
                } else {
                    const newId = generateProductId();
                    inventoryProducts.unshift({
                        id: newId,
                        ...productData
                    });
                    alert(`Product "${name}" added.`);
                }

                // persistData();
                closeProductModal();
                // renderCurrentTab();
                refreshUI()
                return true;
            }



            // Dynamic size selector for add variant modal based on category
            function updateNewVariantSizeOptions() {
                const category = document.getElementById("prodCategory").value;
                const container = document.getElementById("newVariantSizeContainer");
                if (category === "Footwear") {
                    let select = `<select id="newVariantSizeSelect" class="w-full p-2 border rounded" required>`;
                    for (let i = 10; i <= 50; i++)
                        select += `<option value="${i}">${i}</option>`;
                    select += `</select>`;
                    container.innerHTML = select;
                } else {
                    const sizes = ["XS", "S", "M", "L", "XL", "XXL", "One Size"];
                    let select = `<select id="newVariantSizeSelect" class="w-full p-2 border rounded" required>`;
                    sizes.forEach(
                        (sz) => (select += `<option value="${sz}">${sz}</option>`),
                    );
                    select += `</select>`;
                    container.innerHTML = select;
                }
            }

            // Navigation
            function showStep1() {
                document.getElementById("step1Content").classList.remove("hidden");
                document.getElementById("step2Content").classList.add("hidden");
                document.getElementById("step1Indicator").classList.add("active");
                document.getElementById("step2Indicator").classList.remove("active");
                document.getElementById("step1Indicator").classList.remove("completed");
                document.getElementById("step2Indicator").classList.remove("completed");
            }

            function showStep2() {
                if (!document.getElementById("prodName").value.trim()) {
                    alert("Please enter product name first");
                    return;
                }
                document.getElementById("step1Content").classList.add("hidden");
                document.getElementById("step2Content").classList.remove("hidden");
                document.getElementById("step1Indicator").classList.remove("active");
                document.getElementById("step2Indicator").classList.add("active");
                document.getElementById("step1Indicator").classList.add("completed");
                renderVariantsList();
            }


            function confirmDelete() {
                if (deleteTargetId) {
                    const product = inventoryProducts.find(
                        (p) => p.id === deleteTargetId,
                    );
                    deleteProduct(deleteTargetId);
                    alert(`Product "${product?.name ?? deleteTargetId}" deleted.`);
                    deleteTargetId = null;
                    document.getElementById("deleteModal").classList.add("hidden");
                    // renderCurrentTab();
                    refreshUI()
                }
            }

            function cancelDelete() {
                deleteTargetId = null;
                document.getElementById("deleteModal").classList.add("hidden");
            }

            function exportToCSV() {
                const headers = [
                    "Product ID",
                    "Product Name",
                    "Category",
                    "Brand",
                    "Variant ID",
                    "SKU",
                    "Color",
                    "Size",
                    "Buy Price (KES)",
                    "Sell Price (KES)",
                    "Total Stock",
                    "Status",
                    "Reorder Point",
                    "Last Restocked",
                    "Description",
                ];

                const rows = inventoryProducts.flatMap((product) =>
                    product.variants.map((v) => [
                        product.id,
                        product.name,
                        product.category,
                        product.brand,
                        v.id,
                        v.sku,
                        v.color,
                        v.size,
                        v.buyPrice,
                        v.sellPrice,
                        v.inventory.totalStock,
                        v.inventory.status,
                        v.inventory.reorderPoint,
                        v.inventory.lastRestocked,
                        product.description || "",
                    ]),
                );

                const csvContent = [headers, ...rows]
                    .map((row) =>
                        row
                        .map((cell) => `"${String(cell ?? "").replace(/"/g, '""')}"`)
                        .join(","),
                    )
                    .join("\n");

                const blob = new Blob(["\uFEFF" + csvContent], {
                    type: "text/csv;charset=utf-8;",
                });

                const link = document.createElement("a");
                const url = URL.createObjectURL(blob);

                link.href = url;
                link.setAttribute("download", "qwetulinks_inventory_export.csv");

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                URL.revokeObjectURL(url);

                alert("📄 Inventory exported successfully!");
            }

            function attachCatalogEvents() {
                // Search and filter
                const searchInput = document.getElementById("searchProductInput");
                const categoryFilter = document.getElementById("categoryFilterSelect");
                if (searchInput) searchInput.addEventListener("input", filterProducts);
                if (categoryFilter)
                    categoryFilter.addEventListener("change", filterProducts);

                // Add product button
                const addBtn = document.getElementById("addProductBtn");
                if (addBtn)
                    addBtn.addEventListener("click", () => openProductModal(null));

                // Export button
                const exportBtn = document.getElementById("exportCatalogBtn");
                if (exportBtn) exportBtn.addEventListener("click", exportToCSV);

                // Modal close buttons
                const closeModalBtn = document.getElementById("closeProductModalBtn");
                const cancelBtn = document.getElementById("cancelProductBtn");
                if (closeModalBtn)
                    closeModalBtn.addEventListener("click", closeProductModal);
                if (cancelBtn) cancelBtn.addEventListener("click", closeProductModal);

                // Product tab navigation
                document
                    .getElementById("nextToVariantsBtn")
                    ?.addEventListener("click", showStep2);

                document
                    .getElementById("backToInfoBtn")
                    ?.addEventListener("click", showStep1);

                document
                    .getElementById("openAddVariantModalBtn")
                    ?.addEventListener("click", () => {
                        updateNewVariantSizeOptions();
                        document.getElementById("newVariantColor").value = "";
                        document.getElementById("newVariantMainStock").value = 0;
                        if (document.getElementById("newVariantSku"))
                            document.getElementById("newVariantSku").value = "";
                        document
                            .getElementById("addVariantModal")
                            .classList.remove("hidden");
                        document.getElementById("addVariantModal").classList.add("flex");
                    });

                document
                    .getElementById("confirmAddVariantBtn")
                    ?.addEventListener("click", addNewVariantFromModal);

                document
                    .getElementById("closeAddVariantModalBtn")
                    ?.addEventListener("click", () =>
                        document.getElementById("addVariantModal").classList.add("hidden"),
                    );

                // Form submit
                const form = document.getElementById("productForm");
                if (form)
                    form.addEventListener("submit", (e) => {
                        e.preventDefault();
                        saveProductFromForm();
                    });

                // Delete modal buttons
                const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
                const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
                if (confirmDeleteBtn)
                    confirmDeleteBtn.addEventListener("click", confirmDelete);
                if (cancelDeleteBtn)
                    cancelDeleteBtn.addEventListener("click", cancelDelete);

                // Image upload handling
                const fileInput = document.getElementById("prodImageFile");
                if (fileInput) {
                    fileInput.onchange = (e) => {
                        const file = e.target.files[0];
                        if (file && file.type.startsWith("image/")) {
                            if (file.size > 2 * 1024 * 1024) {
                                alert("Image size should be less than 2MB");
                                return;
                            }
                            const reader = new FileReader();
                            reader.onload = (ev) => {
                                currentImageDataURL = ev.target.result;
                                showImagePreview(currentImageDataURL, file.name);
                            };
                            reader.readAsDataURL(file);
                        } else if (file) {
                            alert("Please select a valid image file (JPG, PNG, WEBP)");
                        }
                    };
                }

                const removeImageBtn = document.getElementById("removeImageBtn");
                if (removeImageBtn) {
                    removeImageBtn.addEventListener("click", () => {
                        currentImageDataURL = null;
                        document
                            .getElementById("imagePreviewContainer")
                            .classList.add("hidden");
                        document.getElementById("prodImageFile").value = "";
                    });
                }

                // Click outside modal to close
                window.addEventListener("click", (e) => {
                    const modal = document.getElementById("productModal");
                    if (e.target === modal) closeProductModal();
                    const deleteModal = document.getElementById("deleteModal");
                    if (e.target === deleteModal) cancelDelete();
                });
            }

            function refreshUI() {
                const container = document.getElementById("productCatalogRoot");
                container.innerHTML = renderCatalog();
                filterProducts();
                attachCatalogEvents();
            }

            // Initialize
            function init() {
                loadInitialData();
                refreshUI();
            }

            if (document.readyState === "loading")
                document.addEventListener("DOMContentLoaded", init);
            else init();
        })();
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\qwetu_links_pos\resources\views/layouts/user/products/product.blade.php ENDPATH**/ ?>