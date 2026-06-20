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
            margin: 0;
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
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            color: #0f172a;
        }

        .overlay-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
            display: none;
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

            .overlay-backdrop.active {
                display: block;
            }
        }

        .nav-item {
            transition: all 0.2s;
            cursor: pointer;
            border-radius: 0.75rem;
        }

        .nav-item.active {
            background-color: #ecfdf5;
            color: #047857;
            font-weight: 600;
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

        .product-card {
            transition: all 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
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

        .variant-item {
            transition: all 0.2s;
        }
    </style>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>

    <script>
        // --------------------------------------------------------------
        // 1) PRODUCT CATALOG MODULE (FULL CRUD)
        // --------------------------------------------------------------
        let productsDB = [];
        let editingProductId = null;
        let tempVariants = [];
        let tempImageDataURL = null;
        const API_BASE = "<?php echo e(config('app.api_url')); ?>";

        const seedProducts = async () => {
            try {
                const res = await fetch(`${API_BASE}/products`);

                if (!res.ok) {
                    productsDB = []; // fallback empty
                    return;
                }

                const data = await res.json();

                productsDB = (data.data || []).map(product => ({
                    id: product.product_id,
                    name: product.name,
                    // category: product.category?.name ?? null,
                    category: product.category_id,
                    brand: product.brand,
                    description: product.description,
                    imageData: product.image_url ?
                        `http://localhost/storage/${product.image_url}` :
                        "https://placehold.co/400x300",

                    variants: (product.variants || []).map(v => ({
                        id: v.variant_id,
                        sku: v.sku,
                        color: v.color,
                        size: v.size,
                        buyPrice: v.buy_price,
                        sellPrice: v.sell_price,
                        // inventory: {
                        //     totalStock: v.instock ?? 0,
                        //     locations: v.locations ?? []
                        // }
                    }))
                }));

            } catch (e) {
                // ❌ silently fail (no console, no UI error)
                productsDB = [];
            }
        };

        seedProducts();

        // const seedProducts = () => {
        //     productsDB = [{
        //             id: "PRD-001",
        //             name: "Classic Denim Jacket",
        //             category: "Outerwear",
        //             brand: "Raw Denim Co.",
        //             description: "Classic blue denim jacket, button closure, premium cotton.",
        //             imageData: "https://placehold.co/400x300/e2e8f0/2d3748?text=Denim+Jacket",
        //             variants: [{
        //                     id: "v1",
        //                     sku: "DNM-S-BLU",
        //                     color: "Blue",
        //                     size: "S",
        //                     buyPrice: 4800,
        //                     sellPrice: 7200,
        //                     inventory: {
        //                         totalStock: 12,
        //                         locations: [{
        //                             name: "Main Store",
        //                             stock: 12
        //                         }],
        //                     },
        //                 },
        //                 {
        //                     id: "v2",
        //                     sku: "DNM-M-BLU",
        //                     color: "Blue",
        //                     size: "M",
        //                     buyPrice: 4800,
        //                     sellPrice: 7200,
        //                     inventory: {
        //                         totalStock: 18
        //                     },
        //                 },
        //                 {
        //                     id: "v3",
        //                     sku: "DNM-L-BLU",
        //                     color: "Blue",
        //                     size: "L",
        //                     buyPrice: 4800,
        //                     sellPrice: 7200,
        //                     inventory: {
        //                         totalStock: 12
        //                     },
        //                 },
        //             ],
        //         },
        //         {
        //             id: "PRD-002",
        //             name: "Air Max Sneakers",
        //             category: "Footwear",
        //             brand: "SportStyle",
        //             description: "Breathable mesh, Air cushion sole.",
        //             imageData: "https://placehold.co/400x300/e2e8f0/2d3748?text=Air+Max",
        //             variants: [{
        //                     id: "v4",
        //                     sku: "AMX-40-BLK",
        //                     color: "Black",
        //                     size: "40",
        //                     buyPrice: 7800,
        //                     sellPrice: 12500,
        //                     inventory: {
        //                         totalStock: 3
        //                     },
        //                 },
        //                 {
        //                     id: "v5",
        //                     sku: "AMX-42-BLK",
        //                     color: "Black",
        //                     size: "42",
        //                     buyPrice: 7800,
        //                     sellPrice: 12500,
        //                     inventory: {
        //                         totalStock: 5
        //                     },
        //                 },
        //             ],
        //         },
        //         {
        //             id: "PRD-003",
        //             name: "Organic Cotton T-Shirt",
        //             category: "Men's Clothing",
        //             brand: "EcoWear",
        //             description: "100% organic cotton, soft fabric.",
        //             imageData: "https://placehold.co/400x300/e2e8f0/2d3748?text=T-Shirt",
        //             variants: [{
        //                     id: "v6",
        //                     sku: "COT-S-WHT",
        //                     color: "White",
        //                     size: "S",
        //                     sellPrice: 2450,
        //                     buyPrice: 1200,
        //                     inventory: {
        //                         totalStock: 20
        //                     },
        //                 },
        //                 {
        //                     id: "v7",
        //                     sku: "COT-M-WHT",
        //                     color: "White",
        //                     size: "M",
        //                     sellPrice: 2450,
        //                     buyPrice: 1200,
        //                     inventory: {
        //                         totalStock: 18
        //                     },
        //                 },
        //                 {
        //                     id: "v8",
        //                     sku: "COT-L-WHT",
        //                     color: "White",
        //                     size: "L",
        //                     sellPrice: 2450,
        //                     buyPrice: 1200,
        //                     inventory: {
        //                         totalStock: 16
        //                     },
        //                 },
        //             ],
        //         },
        //         {
        //             id: "PRD-004",
        //             name: "Premium Leather Belt",
        //             category: "Accessories",
        //             brand: "LuxeTannery",
        //             description: "Genuine leather, sleek buckle.",
        //             imageData: "https://placehold.co/400x300/e2e8f0/2d3748?text=Leather+Belt",
        //             variants: [{
        //                 id: "v9",
        //                 sku: "BELT-OS-BLK",
        //                 color: "Black",
        //                 size: "One Size",
        //                 sellPrice: 3200,
        //                 buyPrice: 1800,
        //                 inventory: {
        //                     totalStock: 22
        //                 },
        //             }, ],
        //         },
        //         {
        //             id: "PRD-005",
        //             name: "Summer Floral Dress",
        //             category: "Women's Clothing",
        //             brand: "BloomStyle",
        //             description: "Lightweight viscose, floral pattern.",
        //             imageData: "https://placehold.co/400x300/e2e8f0/2d3748?text=Floral+Dress",
        //             variants: [{
        //                     id: "v10",
        //                     sku: "FLR-S-PNK",
        //                     color: "Pink",
        //                     size: "S",
        //                     sellPrice: 4850,
        //                     buyPrice: 2500,
        //                     inventory: {
        //                         totalStock: 2
        //                     },
        //                 },
        //                 {
        //                     id: "v11",
        //                     sku: "FLR-M-PNK",
        //                     color: "Pink",
        //                     size: "M",
        //                     sellPrice: 4850,
        //                     buyPrice: 2500,
        //                     inventory: {
        //                         totalStock: 4
        //                     },
        //                 },
        //             ],
        //         },
        //         {
        //             id: "PRD-006",
        //             name: "Kids Adventure Backpack",
        //             category: "Kids Wear",
        //             brand: "TinyTrek",
        //             description: "Water-resistant, padded straps.",
        //             imageData: "https://placehold.co/400x300/e2e8f0/2d3748?text=Kids+Bag",
        //             variants: [{
        //                 id: "v12",
        //                 sku: "KBP-OS-BLU",
        //                 color: "Blue",
        //                 size: "One Size",
        //                 sellPrice: 2890,
        //                 buyPrice: 1400,
        //                 inventory: {
        //                     totalStock: 15
        //                 },
        //             }, ],
        //         },
        //     ];
        // };
        // seedProducts();

        function computeStats() {
            let totalValue = 0,
                totalSellSum = 0,
                productCount = productsDB.length,
                lowStockCount = 0;
            productsDB.forEach((p) => {
                let productSellPrice = p.variants.length ?
                    p.variants[0].sellPrice :
                    0;
                totalSellSum += productSellPrice;
                p.variants.forEach((v) => {
                    let stock = v.inventory?.totalStock || 0;
                    totalValue += (v.sellPrice || 0) * stock;
                    if (stock < 10) lowStockCount++;
                });
            });
            let avgPrice = productCount ?
                Math.round(totalSellSum / productCount) :
                0;
            return {
                totalProducts: productCount,
                inventoryValue: totalValue,
                avgPrice,
                lowStockCount,
            };
        }

        function escapeHtml(str) {
            if (!str) return "";
            return str.replace(/[&<>]/g, (m) =>
                m === "&" ? "&amp;" : m === "<" ? "&lt;" : "&gt;",
            );
        }

        function renderProductGrid() {
            const gridContainer = document.getElementById("dynamicProductsGrid");
            if (!gridContainer) return;
            const stats = computeStats();
            document.getElementById("statTotalProducts").innerText =
                stats.totalProducts;
            document.getElementById("statInventoryValue").innerText =
                `KES ${stats.inventoryValue.toLocaleString()}`;
            document.getElementById("statAvgPrice").innerText =
                `KES ${stats.avgPrice.toLocaleString()}`;
            document.getElementById("statLowStock").innerText = stats.lowStockCount;
            if (productsDB.length === 0) {
                gridContainer.innerHTML =
                    `<div class="col-span-full text-center py-12 bg-white rounded-xl border"><i class="fas fa-box-open text-4xl text-gray-300 mb-2"></i><p class="text-gray-500">No products. Click "Add Product" to start.</p></div>`;
                return;
            }
            gridContainer.innerHTML = productsDB
                .map((prod) => {
                    const totalStock = prod.variants.reduce(
                        (sum, v) => sum + (v.inventory?.totalStock || 0),
                        0,
                    );
                    const lowStockFlag = prod.variants.some(
                        (v) => (v.inventory?.totalStock || 0) < 10,
                    );
                    const primaryPrice = prod.variants.length ?
                        prod.variants[0].sellPrice :
                        0;
                    const sizeOptions = prod.variants
                        .slice(0, 3)
                        .map(
                            (v) =>
                            `<span class="text-xs bg-gray-100 px-2 py-1 rounded-full border border-white">${v.size}</span>`,
                        )
                        .join("");
                    return `
        <div class="product-card bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition-all">
          <div class="relative h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
            <img src="${prod.imageData || "https://placehold.co/400x300/e2e8f0/2d3748?text=No+Image"}" alt="${prod.name}" class="w-full h-full object-cover">
            <div class="absolute top-2 right-2 ${lowStockFlag ? "bg-amber-100 text-amber-800" : "bg-green-100 text-green-800"} text-xs px-2 py-1 rounded-full">
              <i class="fas ${lowStockFlag ? "fa-exclamation-triangle" : "fa-check-circle"} mr-1"></i>${lowStockFlag ? "Low Stock" : "In Stock"}
            </div>
          </div>
          <div class="p-4">
            <div class="flex justify-between items-start mb-2"><h3 class="font-bold text-gray-800 text-lg">${escapeHtml(prod.name)}</h3><div class="flex -space-x-2">${sizeOptions || '<span class="text-xs text-gray-400">No variants</span>'}</div></div>
            <p class="text-sm text-gray-500 mb-2">${escapeHtml(prod.category)} • ${escapeHtml(prod.brand)}</p>
            <div class="flex items-center justify-between mb-4"><div class="flex items-center gap-1"><i class="fas fa-boxes text-gray-400 text-sm"></i><span class="text-sm font-medium ${lowStockFlag ? "text-amber-600" : "text-gray-700"}">Stock: ${totalStock} units</span></div><span class="text-emerald-700 font-semibold">KES ${primaryPrice.toLocaleString()}</span></div>
            <div class="flex gap-2"><button class="editProductDynamic flex-1 px-3 py-2 text-sm text-blue-500 border border-blue-500 rounded-lg hover:bg-blue-100 transition font-medium" data-id="${prod.id}"><i class="fas fa-edit mr-1"></i> Edit</button><button class="deleteProductDynamic flex-1 px-3 py-2 text-sm border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition font-medium" data-id="${prod.id}" data-name="${escapeHtml(prod.name)}"><i class="fas fa-trash-alt mr-1"></i> Delete</button></div>
          </div>
        </div>
      `;
                })
                .join("");
            document.querySelectorAll(".editProductDynamic").forEach((btn) =>
                btn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    openEditProductModal(btn.dataset.id);
                }),
            );
            document.querySelectorAll(".deleteProductDynamic").forEach((btn) =>
                btn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    showDeleteModal(btn.dataset.id, btn.dataset.name);
                }),
            );
        }

        // Modal management
        function openEditProductModal(productId) {
            const product = productsDB.find((p) => p.id === productId);
            if (!product) return;
            editingProductId = productId;
            document.getElementById("modalTitle").innerHTML =
                '<i class="fas fa-edit text-emerald-600 mr-2"></i>Edit Product';
            document.getElementById("productId").value = productId;
            document.getElementById("prodName").value = product.name;
            document.getElementById("prodCategory").value = product.category;
            document.getElementById("prodBrand").value = product.brand || "";
            document.getElementById("prodDesc").value = product.description || "";
            tempImageDataURL = product.imageData || null;
            if (tempImageDataURL) {
                document.getElementById("imagePreviewLocal").src = tempImageDataURL;
                document
                    .getElementById("imagePreviewContainer")
                    .classList.remove("hidden");
                document.getElementById("previewFileName").innerText =
                    "Product image";
            } else {
                document
                    .getElementById("imagePreviewContainer")
                    .classList.add("hidden");
            }
            tempVariants = JSON.parse(JSON.stringify(product.variants || []));
            renderVariantsListInModal();
            showStep1();
            document.getElementById("productModal").classList.remove("hidden");
        }

        function openAddModal() {
            editingProductId = null;
            document.getElementById("productId").value = "";
            document.getElementById("modalTitle").innerHTML =
                '<i class="fas fa-plus-circle text-emerald-600 mr-2"></i>Add New Product';
            document.getElementById("productFormModal").reset();
            document.getElementById("prodCategory").value = "Men's Clothing";
            tempImageDataURL = null;
            document
                .getElementById("imagePreviewContainer")
                .classList.add("hidden");
            tempVariants = [];
            renderVariantsListInModal();
            showStep1();
            document.getElementById("productModal").classList.remove("hidden");
        }

        function showDeleteModal(id, name) {
            document.getElementById("deleteProductId").value = id;
            document.getElementById("deleteNameSpan").innerText = name;
            document.getElementById("deleteModal").classList.remove("hidden");
            document.getElementById("deleteModal").classList.add("flex");
        }

        function renderVariantsListInModal() {
            const container = document.getElementById("variantsListContainer");
            if (!container) return;
            if (tempVariants.length === 0) {
                container.innerHTML =
                    '<div class="text-center text-gray-400 py-8"><i class="fas fa-cubes text-3xl mb-2"></i><p>No variants yet. Click "Add Variant".</p></div>';
                return;
            }
            container.innerHTML = tempVariants
                .map(
                    (v, idx) => `
      <div class="variant-item bg-white border rounded-xl p-4 flex flex-wrap justify-between items-center">
        <div><span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">${v.sku || "SKU"}</span><div class="mt-1"><span class="font-medium">${v.color} / ${v.size}</span> | Buy: KES ${v.buyPrice} Sell: KES ${v.sellPrice}</div><div class="text-xs text-gray-500">Main stock: ${v.inventory?.locations?.[0]?.stock || v.inventory?.totalStock || 0}</div></div>
        <button class="deleteTempVariantModalBtn text-red-600 px-2 py-1 rounded" data-idx="${idx}"><i class="fas fa-trash-alt"></i> Delete</button>
      </div>
    `,
                )
                .join("");
            document.querySelectorAll(".deleteTempVariantModalBtn").forEach((btn) =>
                btn.addEventListener("click", (e) => {
                    let idx = parseInt(btn.dataset.idx);
                    tempVariants.splice(idx, 1);
                    renderVariantsListInModal();
                }),
            );
        }

        // function saveProductFromModal() {
        //     const name = document.getElementById("prodName").value.trim();
        //     if (!name) {
        //         alert("Product name required");
        //         return;
        //     }
        //     const category = document.getElementById("prodCategory").value;
        //     const brand = document.getElementById("prodBrand").value;
        //     const description = document.getElementById("prodDesc").value;
        //     if (tempVariants.length === 0) {
        //         alert("Please add at least one variant (color/size/price)");
        //         return;
        //     }
        //     const newProduct = {
        //         id: editingProductId || generateId(),
        //         name,
        //         category,
        //         brand,
        //         description,
        //         imageData: tempImageDataURL || null,
        //         variants: tempVariants,
        //     };
        //     if (editingProductId) {
        //         let index = productsDB.findIndex((p) => p.id === editingProductId);
        //         if (index !== -1) productsDB[index] = newProduct;
        //     } else {
        //         productsDB.push(newProduct);
        //     }
        //     renderProductGrid();
        //     closeProductModal();
        // }
        async function saveProductFromModal() {
            const name = document.getElementById("prodName").value.trim();

            if (!name) {
                alert("Product name required");
                return;
            }

            const category = document.getElementById("prodCategory").value;
            const brand = document.getElementById("prodBrand").value;
            const description = document.getElementById("prodDesc").value;

            if (tempVariants.length === 0) {
                alert("Please add at least one variant (color/size/price)");
                return;
            }

            // Build payload for API
            const payload = {
                product_id: editingProductId || null,
                name,
                category_id: category,
                brand,
                description,
                image_url: tempImageDataURL, // or file upload later
                variants: tempVariants
            };

            try {
                const res = await fetch(`${API_BASE}/products`, {
                    method: editingProductId ? "PUT" : "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(payload)
                });

                if (!res.ok) {
                    // silent fail (no alert spam if you want)
                    return;
                }

                const data = await res.json();

                // refresh products from API instead of local array
                await seedProducts();

                renderProductGrid();
                closeProductModal();

            } catch (e) {
                // silent fail
            }
        }

        function closeProductModal() {
            document.getElementById("productModal").classList.add("hidden");
            editingProductId = null;
        }

        function showStep1() {
            document.getElementById("step1Content").classList.remove("hidden");
            document.getElementById("step2Content").classList.add("hidden");
            document.getElementById("step1Indicator").classList.add("active");
            document.getElementById("step2Indicator").classList.remove("active");
        }

        function showStep2() {
            if (!document.getElementById("prodName").value.trim()) {
                alert("Enter product name first");
                return;
            }
            document.getElementById("step1Content").classList.add("hidden");
            document.getElementById("step2Content").classList.remove("hidden");
            document.getElementById("step1Indicator").classList.remove("active");
            document.getElementById("step2Indicator").classList.add("active");
            renderVariantsListInModal();
        }

        function addVariantFromModal() {
            const color = document.getElementById("newVariantColor").value.trim();
            const sizeSelect = document.getElementById("newVariantSizeSelect");
            if (!sizeSelect) return;
            const size = sizeSelect.value;
            const buyPrice =
                parseFloat(document.getElementById("newVariantBuyPrice").value) || 0;
            const sellPrice =
                parseFloat(document.getElementById("newVariantSellPrice").value) || 0;
            const mainStock =
                parseInt(document.getElementById("newVariantMainStock").value) || 0;
            if (!color || !size) {
                alert("Color and size required");
                return;
            }
            const sku = `VAR-${color.substring(0, 2)}-${size}`.toUpperCase();
            const newVar = {
                id: "var_" + Date.now() + Math.random(),
                sku,
                color,
                size,
                buyPrice,
                sellPrice,
                inventory: {
                    totalStock: mainStock,
                    locations: [{
                        name: "Main Store",
                        stock: mainStock
                    }],
                },
            };
            tempVariants.push(newVar);
            renderVariantsListInModal();
            document.getElementById("addVariantModal").classList.add("hidden");
            document.getElementById("newVariantColor").value = "";
            document.getElementById("newVariantMainStock").value = 0;
        }

        function updateSizeOptionsByCategory() {
            const cat = document.getElementById("prodCategory").value;
            const container = document.getElementById("newVariantSizeContainer");
            if (!container) return;
            if (cat === "Footwear") {
                let select = `<select id="newVariantSizeSelect" class="w-full p-2 border rounded">`;
                for (let i = 32; i <= 46; i++)
                    select += `<option value="${i}">${i}</option>`;
                select += `</select>`;
                container.innerHTML = select;
            } else {
                const sizes = ["XS", "S", "M", "L", "XL", "XXL", "One Size"];
                let select = `<select id="newVariantSizeSelect" class="w-full p-2 border rounded">`;
                sizes.forEach(
                    (sz) => (select += `<option value="${sz}">${sz}</option>`),
                );
                select += `</select>`;
                container.innerHTML = select;
            }
        }

        // Catalog HTML (embedded modals)
        function getCatalogHTML() {
            return `
      <div class="fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
          <div><h1 class="text-3xl font-bold text-gray-800"><i class="fas fa-tags text-emerald-600 mr-2"></i>Product Catalog</h1><p class="text-gray-500 mt-1">Manage inventory • variants • pricing (live demo)</p></div>
          <div class="flex gap-2"><button id="addProductMasterBtn" class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-5 py-2.5 rounded-xl hover:shadow-lg transition flex items-center gap-2"><i class="fas fa-plus-circle"></i> Add Product</button><button id="exportCatalogCsvBtn" class="px-4 py-2.5 border border-gray-300 rounded-xl hover:bg-gray-50 transition"><i class="fas fa-download"></i> Export CSV</button></div>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-blue-600 mb-2"><i class="fas fa-box"></i><p class="text-sm font-medium">Total Products</p></div><p class="text-2xl font-bold" id="statTotalProducts">0</p></div>
          <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-emerald-600 mb-2"><i class="fas fa-chart-line"></i><p class="text-sm font-medium">Inventory Value</p></div><p class="text-2xl font-bold" id="statInventoryValue">KES 0</p></div>
          <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-purple-600 mb-2"><i class="fas fa-receipt"></i><p class="text-sm font-medium">Avg. Price (sell)</p></div><p class="text-2xl font-bold" id="statAvgPrice">KES 0</p></div>
          <div class="bg-white rounded-xl border p-5 shadow-sm"><div class="flex items-center gap-2 text-amber-600 mb-2"><i class="fas fa-exclamation-triangle"></i><p class="text-sm font-medium">Low Stock Items</p></div><p class="text-2xl font-bold text-amber-600" id="statLowStock">0</p></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="dynamicProductsGrid"></div>
      </div>
      <!-- Modals -->
      <div id="productModal" class="fixed flex align-center inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 overflow-y-auto py-4"><div class="bg-white rounded-2xl max-w-3xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto scrollbar-custom"><div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between"><h3 class="text-2xl font-bold text-gray-800" id="modalTitle"><i class="fas fa-plus-circle text-emerald-600 mr-2"></i>Product</h3><button id="closeProductModalBtnModal" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button></div><div class="p-5"><form id="productFormModal" class="space-y-2"><input type="hidden" id="productId"/><div class="step-indicator flex items-center gap-2 mb-4"><div class="step active" id="step1Indicator">1</div><span class="text-sm">Product Info</span><div class="w-8 h-px bg-gray-300 mx-1"></div><div class="step" id="step2Indicator">2</div><span class="text-sm">Variants</span></div><div id="step1Content" class="space-y-5"><div class="grid md:grid-cols-2 gap-5"><div><label class="block text-sm font-semibold">Product Name *</label><input type="text" id="prodName" class="w-full px-4 py-2.5 border rounded-xl"/></div><div><label class="block text-sm font-semibold">Category</label><select id="prodCategory" class="w-full px-4 py-2.5 border rounded-xl"><option>Men's Clothing</option><option>Women's Clothing</option><option>Accessories</option><option>Footwear</option><option>Kids Wear</option><option>Outerwear</option></select></div><div><label>Supplier/Brand</label><input type="text" id="prodBrand" class="w-full px-4 py-2.5 border rounded-xl"/></div><div><label>Product Image</label><div class="file-upload-area relative bg-gray-50 p-4 rounded-xl text-center"><input type="file" id="prodImageFileModal" accept="image/jpeg,image/png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/><div class="flex flex-col items-center"><i class="fas fa-cloud-upload-alt text-3xl text-emerald-500 mb-2"></i><p class="text-sm">Click to preview</p></div></div><div id="imagePreviewContainer" class="mt-3 hidden"><div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl"><img id="imagePreviewLocal" class="image-preview-circle"/><div class="flex-1"><p id="previewFileName" class="text-sm font-medium">image.jpg</p><button type="button" id="removeImageBtnModal" class="text-xs text-red-500"><i class="fas fa-trash-alt mr-1"></i> Remove</button></div></div></div></div></div><div><label>Description</label><textarea id="prodDesc" rows="3" class="w-full px-4 py-2.5 border rounded-xl"></textarea></div><div class="flex justify-end"><button type="button" id="nextToVariantsBtnModal" class="bg-emerald-600 text-white px-6 py-2 rounded-xl">Next: Add Variants →</button></div></div><div id="step2Content" class="hidden space-y-5"><div class="flex justify-between"><h4 class="font-bold text-lg">Variants</h4><button type="button" id="openAddVariantMasterBtn" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg text-sm"><i class="fas fa-plus"></i> Add Variant</button></div><div id="variantsListContainer" class="space-y-3 max-h-96 overflow-y-auto border rounded-xl p-3 bg-gray-50"></div><div class="flex justify-between gap-3"><button type="button" id="backToInfoBtnModal" class="px-6 py-2.5 border rounded-xl">← Back</button><button type="submit" id="saveProductFinalBtn" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl">Save Product</button></div></div></form></div></div></div>
      <div id="addVariantModal" class="fixed flex align-center inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[60] p-4"><div class="bg-white rounded-2xl max-w-lg w-full p-6"><h3 class="text-xl font-bold mb-4"><i class="fas fa-cubes text-emerald-600"></i> Add Variant</h3><div class="space-y-4"><div><label class="font-semibold">Color*</label><input type="text" id="newVariantColor" class="w-full p-2 border rounded" placeholder="e.g., Red"/></div><div><label class="font-semibold">Size*</label><div id="newVariantSizeContainer"></div></div><div class="grid grid-cols-2 gap-3"><div><label>Buy Price (KES)</label><input type="number" id="newVariantBuyPrice" class="w-full p-2 border rounded" value="0"/></div><div><label>Sell Price (KES)</label><input type="number" id="newVariantSellPrice" class="w-full p-2 border rounded" value="0"/></div></div><div><label>Initial Stock</label><input type="number" id="newVariantMainStock" class="w-full p-2 border rounded" value="0"/></div></div><div class="flex gap-3 mt-6"><button id="confirmAddVariantBtnModal" class="flex-1 bg-emerald-600 text-white py-2 rounded-xl">Add Variant</button><button id="closeAddVariantModalBtnModal" class="flex-1 border py-2 rounded-xl">Cancel</button></div></div></div>
      <div id="deleteModal" class="fixed flex align-center inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50"><div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 text-center"><div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i></div><h3 class="text-xl font-bold text-gray-800 mb-2">Delete Product</h3><p class="text-gray-500 mb-6">Are you sure you want to delete "<span id="deleteNameSpan"></span>"?</p><input type="hidden" id="deleteProductId"/><div class="flex gap-3"><button id="confirmDeleteModalBtn" class="flex-1 bg-red-600 text-white py-2.5 rounded-xl">Confirm Delete</button><button id="cancelDeleteModalBtn" class="flex-1 border border-gray-300 py-2.5 rounded-xl">Cancel</button></div></div></div>
    `;
        }

        function initCatalogInteractions() {
            document
                .getElementById("addProductMasterBtn")
                ?.addEventListener("click", openAddModal);
            document
                .getElementById("closeProductModalBtnModal")
                ?.addEventListener("click", closeProductModal);
            document
                .getElementById("nextToVariantsBtnModal")
                ?.addEventListener("click", showStep2);
            document
                .getElementById("backToInfoBtnModal")
                ?.addEventListener("click", showStep1);
            document
                .getElementById("openAddVariantMasterBtn")
                ?.addEventListener("click", () => {
                    updateSizeOptionsByCategory();
                    document
                        .getElementById("addVariantModal")
                        .classList.remove("hidden");
                    document.getElementById("addVariantModal").classList.add("flex");
                });
            document
                .getElementById("confirmAddVariantBtnModal")
                ?.addEventListener("click", addVariantFromModal);
            document
                .getElementById("closeAddVariantModalBtnModal")
                ?.addEventListener("click", () =>
                    document.getElementById("addVariantModal").classList.add("hidden"),
                );
            document
                .getElementById("saveProductFinalBtn")
                ?.addEventListener("click", saveProductFromModal);
            document
                .getElementById("productFormModal")
                ?.addEventListener("submit", (e) => {
                    e.preventDefault();
                    saveProductFromModal();
                });
            document
                .getElementById("confirmDeleteModalBtn")
                ?.addEventListener("click", () => {
                    const id = document.getElementById("deleteProductId").value;
                    if (id) {
                        productsDB = productsDB.filter((p) => p.id !== id);
                        renderProductGrid();
                    }
                    document.getElementById("deleteModal").classList.add("hidden");
                });
            document
                .getElementById("cancelDeleteModalBtn")
                ?.addEventListener("click", () =>
                    document.getElementById("deleteModal").classList.add("hidden"),
                );
            const fileInput = document.getElementById("prodImageFileModal");
            if (fileInput)
                fileInput.onchange = (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (ev) => {
                            tempImageDataURL = ev.target.result;
                            document.getElementById("imagePreviewLocal").src =
                                tempImageDataURL;
                            document
                                .getElementById("imagePreviewContainer")
                                .classList.remove("hidden");
                            document.getElementById("previewFileName").innerText =
                                file.name;
                        };
                        reader.readAsDataURL(file);
                    }
                };
            document
                .getElementById("removeImageBtnModal")
                ?.addEventListener("click", () => {
                    tempImageDataURL = null;
                    document
                        .getElementById("imagePreviewContainer")
                        .classList.add("hidden");
                    if (fileInput) fileInput.value = "";
                });
            document
                .getElementById("exportCatalogCsvBtn")
                ?.addEventListener("click", () =>
                    alert("📄 CSV export: product data export simulation."),
                );
            document
                .getElementById("prodCategory")
                ?.addEventListener("change", updateSizeOptionsByCategory);
            renderProductGrid();
        }

        // --------------------------------------------------------------
        // 2) SIDEBAR NAVIGATION (only catalog is fully built)
        // --------------------------------------------------------------
        const pageMap = {
            dashboard: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-6"><i class="fas fa-chart-line text-emerald-600 mr-2"></i>Executive Dashboard</h1><div class="bg-white rounded-xl p-6 border shadow-sm"><p class="text-gray-600">Welcome to QwetuLinks Admin – real‑time KPIs and alerts.</p></div></div>`,
            catalog: () => getCatalogHTML(),
            variants: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-cubes text-emerald-600 mr-2"></i>Product Variants</h1><div class="bg-white rounded-xl p-6 border"><p>Manage SKU, color, size, stock per variant.</p></div></div>`,
            category: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-folder-tree text-emerald-600 mr-2"></i>Product Variants</h1><div class="bg-white rounded-xl p-6 border"><p>Manage Category.</p></div></div>`,
            inventory: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-boxes text-emerald-600 mr-2"></i>Inventory Intelligence</h1><div class="bg-white rounded-xl p-6 border"><p>Multi‑location stock levels, low stock alerts, and reorder triggers.</p></div></div>`,
            orders: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-tasks text-emerald-600 mr-2"></i>Orders Pipeline</h1><div class="bg-white rounded-xl p-6 border"><p>Track and manage orders.</p></div></div>`,
            customers: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-users text-emerald-600 mr-2"></i>Customers Hub</h1><div class="bg-white rounded-xl p-6 border"><p>Customer profiles & segments.</p></div></div>`,
            transactions: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-usd text-emerald-600 mr-2"></i>Transactions Hub</h1><div class="bg-white rounded-xl p-6 border"><p>Payment reconciliations.</p></div></div>`,
            installments: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-hand-holding-usd text-emerald-600 mr-2"></i>Lipa Mdogo Core</h1><div class="bg-white rounded-xl p-6 border"><p>Installment plans & collections.</p></div></div>`,
            analytics: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-chart-pie text-emerald-600 mr-2"></i>Analytics Engine</h1><div class="bg-white rounded-xl p-6 border"><p>Revenue trends & insights.</p></div></div>`,
            reports: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-file-alt text-emerald-600 mr-2"></i>Reports Center</h1><div class="bg-white rounded-xl p-6 border"><p>Export business reports.</p></div></div>`,
            settings: () =>
                `<div class="fade-in"><h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-cog text-emerald-600 mr-2"></i>Settings</h1><div class="bg-white rounded-xl p-6 border"><p>System preferences.</p></div></div>`,
        };
        let currentTab = "catalog";

        function renderCurrentTab() {
            const container = document.getElementById("pageRenderer");
            const renderer = pageMap[currentTab];
            if (container && renderer) {
                container.innerHTML = renderer();
                if (currentTab === "catalog") initCatalogInteractions();
            }
        }

        function initNavigation() {
            const navItems = document.querySelectorAll(".nav-item");
            navItems.forEach((item) => {
                item.addEventListener("click", () => {
                    const tab = item.getAttribute("data-tab");
                    if (tab && pageMap[tab]) {
                        navItems.forEach((nav) =>
                            nav.classList.remove(
                                "active",
                                "bg-emerald-50",
                                "text-emerald-700",
                                "font-semibold",
                            ),
                        );
                        item.classList.add(
                            "active",
                            "bg-emerald-50",
                            "text-emerald-700",
                            "font-semibold",
                        );
                        currentTab = tab;
                        renderCurrentTab();
                        if (window.innerWidth <= 768) closeMobileSidebar();
                    }
                });
            });
            // Set catalog as active by default
            const catalogNav = document.querySelector(
                '.nav-item[data-tab="catalog"]',
            );
            if (catalogNav)
                catalogNav.classList.add(
                    "active",
                    "bg-emerald-50",
                    "text-emerald-700",
                    "font-semibold",
                );
            renderCurrentTab();
        }

        function initMobileSidebar() {
            const sidebar = document.getElementById("fixedSidebar"),
                toggleBtn = document.getElementById("mobileMenuToggleBtn"),
                overlay = document.getElementById("mobileOverlay");
            if (!sidebar || !toggleBtn) return;
            window.closeMobileSidebar = () => {
                sidebar.classList.remove("mobile-open");
                overlay?.classList.remove("active");
                document.body.style.overflow = "";
            };
            toggleBtn.addEventListener("click", () => {
                sidebar.classList.add("mobile-open");
                overlay?.classList.add("active");
                document.body.style.overflow = "hidden";
            });
            overlay?.addEventListener("click", window.closeMobileSidebar);
            document
                .querySelectorAll(".nav-item")
                .forEach((link) =>
                    link.addEventListener("click", window.closeMobileSidebar),
                );
        }

        document
            .getElementById("logoutBtn")
            ?.addEventListener("click", () =>
                alert("Demo logout — integrate your auth."),
            );
        document.addEventListener("DOMContentLoaded", () => {
            initNavigation();
            initMobileSidebar();
        });
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\qwetu_links_pos\resources\views/layouts/admin.blade.php ENDPATH**/ ?>