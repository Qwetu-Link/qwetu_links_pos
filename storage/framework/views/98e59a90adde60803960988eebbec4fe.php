





<?php $__env->startSection('content'); ?>
    <!-- MAIN PRODUCT CATALOG MODULE WRAPPER (fully independent, ready for Laravel blade include) -->
    <div class="main-content-scroll" id="mainScrollArea">

        

        <div id="productCatalogRoot" class="max-w-7xl mx-auto"></div>

        <!-- Product Modal (Add/Edit with local image upload) -->
        <div id="productModal"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center z-50 overflow-y-auto py-8 modal-transition">
            <div class="bg-white rounded-2xl max-w-3xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto scrollbar-custom">
                <div
                    class="sticky top-0 bg-white border-b border-gray-100 px-6 py-5 rounded-t-2xl flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-800" id="modalTitle">
                        <i class="fas fa-plus-circle text-emerald-600 mr-2"></i>Add New
                        Product / Variants
                    </h3>
                    <button id="closeProductModalBtn"
                        class="text-gray-400 hover:text-gray-600 w-8 h-8 rounded-full hover:bg-gray-100">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-6">
                    <form id="productForm" class="space-y-5">
                        <input type="hidden" id="productId" value="" />

                        <!-- Step indicator -->
                        <div class="step-indicator mb-6">
                            <div class="step active" id="step1Indicator">1</div>
                            <span class="text-sm">Product Info</span>
                            <div class="w-8 h-px bg-gray-300 mx-1"></div>
                            <div class="step" id="step2Indicator">2</div>
                            <span class="text-sm">Variants</span>
                        </div>

                        <div id="step1Content" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Product Name
                                        <span class="text-red-500">*</span></label><input type="text" id="prodName"
                                        required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Category <span
                                            class="text-red-500">*</span></label><select id="prodCategory"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl">
                                        <option>Men's Clothing</option>
                                        <option>Women's Clothing</option>
                                        <option>Accessories</option>
                                        <option>Footwear</option>
                                        <option>Kids Wear</option>
                                        <option>Outerwear</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Supplier/Brand<span
                                            class="text-red-500">*</span></label><input type="text" id="prodBrand"
                                        required placeholder="e.g., Fashion Hub Ltd"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Product Image
                                        <span class="text-emerald-600">(Upload)</span></label>
                                    <div class="file-upload-area relative bg-gray-50 p-4 rounded-xl text-center">
                                        <input type="file" id="prodImageFile"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                        <div class="flex flex-col items-center justify-center py-2">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-emerald-500 mb-2"></i>
                                            <p class="text-sm text-gray-600">
                                                Click or drag to upload
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                JPG, PNG up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                    <div id="imagePreviewContainer" class="mt-3 hidden">
                                        <div
                                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                                            <img id="imagePreviewLocal" class="image-preview-circle" alt="Preview" />
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-700" id="previewFileName">
                                                    image.jpg
                                                </p>
                                                <button type="button" id="removeImageBtn"
                                                    class="text-xs text-red-500 hover:text-red-700 mt-1 transition">
                                                    <i class="fas fa-trash-alt mr-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                                <textarea id="prodDesc" rows="3" placeholder="Product details, features, care instructions..."
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" id="nextToVariantsBtn"
                                    class="bg-emerald-600 text-white px-6 py-2 rounded-xl">
                                    Next: Add Variants →
                                </button>
                            </div>
                        </div>
                        <!-- Step 2: Variants management -->
                        <div id="step2Content" class="hidden space-y-5">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-bold text-lg">Product Variants</h4>
                                <button type="button" id="openAddVariantModalBtn"
                                    class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg text-sm">
                                    <i class="fas fa-plus"></i> Add Variant
                                </button>
                            </div>
                            <div id="variantsListContainer"
                                class="space-y-3 max-h-96 overflow-y-auto border rounded-xl p-3 bg-gray-50">
                            </div>
                            <div class="flex justify-between gap-3 pt-4">
                                <button type="button" id="backToInfoBtn" class="px-6 py-2.5 border rounded-xl">
                                    ← Back
                                </button>
                                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl">
                                    Save Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Variant Modal (Step inside product modal) -->
        <div id="addVariantModal"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[60] p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6">
                <h3 class="text-xl font-bold mb-4">
                    <i class="fas fa-cubes text-emerald-600"></i> Add New Variant
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="font-semibold">Color<span class="text-red-500">*</span></label><input
                            type="text" id="newVariantColor" class="w-full p-2 border rounded"
                            placeholder="e.g., Red, Blue" required />
                    </div>
                    <div>
                        <label class="font-semibold">Size<span class="text-red-500">*</span></label>
                        <div id="newVariantSizeContainer"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label>Buy Price (KES)<span class="text-red-500">*</span></label><input type="number"
                                id="newVariantBuyPrice" class="w-full p-2 border rounded" value="0" required />
                        </div>
                        <div>
                            <label>Sell Price (KES)<span class="text-red-500">*</span></label><input type="number"
                                id="newVariantSellPrice" class="w-full p-2 border rounded" value="0" required />
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold">Initial Stock (Main Store)<span
                                class="text-red-500">*</span></label><input type="number" id="newVariantMainStock"
                            class="w-full p-2 border rounded" value="0" min="0" />
                        <p class="text-xs text-gray-500 mt-1">
                            Warehouse A and Outlet will be set to 0 by default (stock can be
                            transferred later).
                        </p>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button id="confirmAddVariantBtn" class="flex-1 bg-emerald-600 text-white py-2 rounded-xl">
                        Add Variant</button><button id="closeAddVariantModalBtn" class="flex-1 border py-2 rounded-xl">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Delete Product Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 text-center shadow-2xl">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Delete Product</h3>
                <p class="text-gray-500 mb-6" id="deleteName">
                    Are you sure you want to delete this product? This action cannot be
                    undone.
                </p>
                <div class="flex gap-3">
                    <button id="confirmDeleteBtn"
                        class="flex-1 bg-red-600 text-white py-2.5 rounded-xl font-medium hover:bg-red-700 transition">
                        Delete</button><button id="cancelDeleteBtn"
                        class="flex-1 border border-gray-300 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.products.product', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\qwetu_links_pos\resources\views/user/elements/products/product.blade.php ENDPATH**/ ?>