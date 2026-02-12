<?php $__env->startSection('title', $product->name . ' - ' . config('app.name')); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('products.all')); ?>">Produk</a></li>
                <?php if($product->tefa): ?>
                <li class="breadcrumb-item"><a href="<?php echo e(route('tefa.show', $product->tefa->slug)); ?>"><?php echo e($product->tefa->name); ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<div class="product-detail-section">
    <div class="container">
        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-images">
                    <div class="main-image-wrapper">
                        <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="main-product-image" id="mainImage">
                        <?php if($product->stock <= 0): ?>
                        <div class="out-of-stock-badge">Stok Habis</div>
                        <?php elseif($product->stock < 10): ?>
                        <div class="low-stock-badge">Stok Terbatas</div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <?php
                        $images = [];
                        if($product->image) $images[] = $product->image_url;
                        if($product->image_2) $images[] = $product->image_2_url;
                        if($product->image_3) $images[] = $product->image_3_url;
                        if($product->image_4) $images[] = $product->image_4_url;
                    ?>
                    
                    <?php if(count($images) > 1): ?>
                    <div class="thumbnail-gallery">
                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $imgUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="thumbnail-item <?php echo e($key == 0 ? 'active' : ''); ?>" onclick="changeImage(this, '<?php echo e($imgUrl); ?>')">
                            <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($product->name); ?>">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Category & TEFA -->
                    <div class="product-meta">
                        <?php if($product->tefa): ?>
                        <a href="<?php echo e(route('tefa.show', $product->tefa->slug)); ?>" class="tefa-badge">
                            <i class="fas fa-industry"></i> <?php echo e($product->tefa->name); ?>

                        </a>
                        <?php endif; ?>
                        <?php if($product->category): ?>
                        <span class="category-badge">
                            <i class="fas fa-tag"></i> <?php echo e(ucfirst($product->category)); ?>

                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Product Name -->
                    <h1 class="product-title"><?php echo e($product->name); ?></h1>

                    <!-- Price -->
                    <div class="product-price">
                        <span class="current-price"><?php echo e($product->formatted_price); ?></span>
                    </div>

                    <!-- Stock Info -->
                    <div class="stock-info">
                        <?php if($product->stock > 0): ?>
                        <span class="in-stock">
                            <i class="fas fa-check-circle"></i> Tersedia (<?php echo e($product->stock); ?> <?php echo e($product->unit); ?>)
                        </span>
                        <?php else: ?>
                        <span class="out-of-stock">
                            <i class="fas fa-times-circle"></i> Stok Habis
                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <div class="product-description">
                        <h3>Deskripsi Produk</h3>
                        <p><?php echo e($product->description ?? 'Produk berkualitas dari ' . ($product->tefa->name ?? 'BLUD SMKN 1 CIAMIS')); ?></p>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <!-- Quantity & Order Actions -->
                    <div class="product-actions">
                        <?php if($product->stock > 0): ?>
                        <?php
                            // Temporarily hardcoded number as requested
                            $whatsappNumber = '6287790984032';
                        ?>
                        <div class="d-grid gap-2 w-100">
<button type="button" class="btn-whatsapp w-100" data-bs-toggle="modal" data-bs-target="#orderModal">
                                <i class="fab fa-whatsapp me-2"></i> Pesan Sekarang
                            </button>
                        </div>
                        <?php else: ?>
                        <button class="btn-add-to-cart disabled w-100" disabled>
                            <i class="fas fa-ban"></i>
                            <span>Stok Habis</span>
                        </button>
                        <?php endif; ?>
                    </div>

                    <!-- Product Features -->
                    <div class="product-features">
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Produk Original</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-truck"></i>
                            <span>Pengiriman Cepat</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-headset"></i>
                            <span>Customer Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products Section -->
<?php if($relatedProducts && $relatedProducts->count() > 0): ?>
<div class="related-products-section">
    <div class="container">
        <div class="section-header">
            <h2>Produk Terkait</h2>
            <p>Produk lainnya dari <?php echo e($product->tefa->name ?? 'kategori yang sama'); ?></p>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-3">
                <div class="product-card" onclick="window.location.href='<?php echo e(route('products.show', $relatedProduct->slug)); ?>'">
                    <div class="product-card-image">
                        <img src="<?php echo e($relatedProduct->image_url); ?>" alt="<?php echo e($relatedProduct->name); ?>">
                        <?php if($relatedProduct->stock <= 0): ?>
                        <div class="product-badge out-of-stock">Habis</div>
                        <?php elseif($relatedProduct->is_featured): ?>
                        <div class="product-badge featured">Unggulan</div>
                        <?php endif; ?>
                    </div>
                    <div class="product-card-content">
                        <h3 class="product-card-title"><?php echo e($relatedProduct->name); ?></h3>
                        <p class="product-card-price"><?php echo e($relatedProduct->formatted_price); ?></p>
                        <div class="product-card-footer">
                            <?php if($relatedProduct->stock > 0): ?>
                            <span class="stock-available">
                                <i class="fas fa-check-circle"></i> Tersedia
                            </span>
                            <?php else: ?>
                            <span class="stock-unavailable">
                                <i class="fas fa-times-circle"></i> Habis
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
/* Breadcrumb Section */
.breadcrumb-section {
    background: linear-gradient(135deg, #4A90E2 0%, #2a5298 100%);
    padding: 1.5rem 0;
    margin-bottom: 3rem;
}

.breadcrumb {
    background: transparent;
    margin: 0;
    padding: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #fff;
}

.breadcrumb-item.active {
    color: #fff;
    font-weight: 600;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

/* Product Detail Section */
.product-detail-section {
    padding: 3rem 0;
}

/* Product Images */
.product-images {
    position: sticky;
    top: 100px;
}

.main-image-wrapper {
    position: relative;
    background: #f8f9fa;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
}

.main-product-image {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.5s ease, opacity 0.2s ease;
}

.main-image-wrapper:hover .main-product-image {
    transform: scale(1.05);
}

.out-of-stock-badge,
.low-stock-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
}

.out-of-stock-badge {
    background: rgba(220, 53, 69, 0.9);
    color: white;
}

.low-stock-badge {
    background: rgba(255, 193, 7, 0.9);
    color: #000;
}

.thumbnail-gallery {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.thumbnail-item {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-item.active {
    border-color: #4A90E2;
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Info */
.product-info {
    padding: 1rem 0;
}

.product-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.tefa-badge,
.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.tefa-badge {
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    color: white;
}

.tefa-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
    color: white;
}

.category-badge {
    background: #f8f9fa;
    color: #495057;
    border: 2px solid #dee2e6;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.product-price {
    margin-bottom: 1.5rem;
}

.current-price {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stock-info {
    margin-bottom: 2rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    display: inline-block;
}

.in-stock {
    color: #28a745;
    font-weight: 600;
    font-size: 1.1rem;
}

.out-of-stock {
    color: #dc3545;
    font-weight: 600;
    font-size: 1.1rem;
}

.stock-info i {
    margin-right: 0.5rem;
}

.product-description {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #f0f0f0;
}

.product-description h3 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 1rem;
}

.product-description p {
    color: #6c757d;
    line-height: 1.8;
    font-size: 1.05rem;
}

/* Product Actions */
.product-actions {
    margin-bottom: 2rem;
}

.btn-whatsapp {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
    width: 100%;
}

.btn-whatsapp:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(37, 211, 102, 0.6);
    color: white;
}

.btn-add-to-cart.disabled {
    padding: 1rem 2rem;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: not-allowed;
    box-shadow: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

/* Product Features */
.product-features {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #495057;
    font-weight: 500;
}

.feature-item i {
    font-size: 1.5rem;
    color: #4A90E2;
}

/* Related Products Section */
.related-products-section {
    padding: 5rem 0;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
}

.section-header p {
    color: #6c757d;
    font-size: 1.1rem;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.product-card-image {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: #f8f9fa;
}

.product-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-card-image img {
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.product-badge.featured {
    background: rgba(255, 193, 7, 0.9);
    color: #000;
}

.product-badge.out-of-stock {
    background: rgba(220, 53, 69, 0.9);
    color: white;
}

.product-card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-card-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 0.75rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-card-price {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.product-card-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.stock-available {
    color: #28a745;
    font-weight: 600;
    font-size: 0.9rem;
}

.stock-unavailable {
    color: #dc3545;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 991px) {
    .product-images {
        position: static;
        margin-bottom: 2rem;
    }
    
    .product-title {
        font-size: 2rem;
    }
    
    .current-price {
        font-size: 2rem;
    }
}

@media (max-width: 767px) {
    .product-features {
        grid-template-columns: 1fr;
    }
    
    .section-header h2 {
        font-size: 2rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-detail-section {
    animation: fadeInUp 0.6s ease;
}
</style>

<!-- Modal Pemesanan -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-light border-0" style="border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <h5 class="modal-title fw-bold text-dark" id="orderModalLabel">Formulir Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm border">
                    <img src="<?php echo e($product->image_url); ?>" alt="Product" class="rounded me-3" style="width: 70px; height: 70px; object-fit: cover;">
                    <div>
                        <h6 class="mb-1 fw-bold text-dark"><?php echo e($product->name); ?></h6>
                        <p class="mb-0 text-primary fw-bold" id="basePrice" data-price="<?php echo e($product->price); ?>"><?php echo e($product->formatted_price); ?></p>
                        <small class="text-muted">Stok: <?php echo e($product->stock); ?></small>
                    </div>
                </div>

                <form id="orderForm">
                    <div class="mb-3">
                        <label for="buyerName" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="buyerName" placeholder="Contoh: Budi Santoso" required style="border-radius: 10px; padding: 10px;">
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="buyerPhone" class="form-label fw-semibold">No. WhatsApp</label>
                            <input type="tel" class="form-control" id="buyerPhone" placeholder="08..." required style="border-radius: 10px; padding: 10px;">
                        </div>
                        <div class="col-6">
                            <label for="orderQty" class="form-label fw-semibold">Jumlah</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQty(-1)" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">-</button>
                                <input type="number" class="form-control text-center" id="orderQty" value="1" min="1" max="<?php echo e($product->stock); ?>" onchange="updateTotal()" style="border-left: 0; border-right: 0;">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQty(1)" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="buyerAddress" class="form-label fw-semibold">Alamat Pengiriman / Info</label>
                        <textarea class="form-control" id="buyerAddress" rows="2" placeholder="Alamat lengkap atau keterangan ambil di sekolah" style="border-radius: 10px; padding: 10px;"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="buyerNotes" class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea class="form-control" id="buyerNotes" rows="2" placeholder="Warna, ukuran, atau request khusus..." style="border-radius: 10px; padding: 10px;"></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4">
                        <span class="text-muted fw-medium">Total Estimasi:</span>
                        <h3 class="fw-bold text-primary mb-0" id="totalPriceDisplay"><?php echo e($product->formatted_price); ?></h3>
                    </div>
                    
                    <div class="alert alert-info mt-3 mb-0 py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Harga belum termasuk ongkos kirim (jika ada).
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light py-2 px-4 rounded-pill fw-semibold" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-whatsapp flex-grow-1 py-2 rounded-pill fw-bold shadow-sm" onclick="submitOrder()">
                    <i class="fab fa-whatsapp me-2"></i>Kirim Pesanan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Initial setup
    document.addEventListener('DOMContentLoaded', function() {
        updateTotal();
    });

    function updateQty(change) {
        const qtyInput = document.getElementById('orderQty');
        let currentQty = parseInt(qtyInput.value);
        let maxQty = parseInt(qtyInput.getAttribute('max'));
        
        let newQty = currentQty + change;
        
        if (newQty >= 1 && newQty <= maxQty) {
            qtyInput.value = newQty;
            updateTotal();
        }
    }

    function updateTotal() {
        const price = parseFloat(document.getElementById('basePrice').getAttribute('data-price'));
        const qty = parseInt(document.getElementById('orderQty').value);
        
        const total = price * qty;
        
        // Format to Indonesian Rupiah
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });
        
        document.getElementById('totalPriceDisplay').innerText = formatter.format(total);
    }

    function changeImage(element, src) {
        // Update main image
        const mainImage = document.getElementById('mainImage');
        mainImage.style.opacity = '0';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 200);
        
        // Update active class
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
    }

    function submitOrder() {
        const productName = <?php echo json_encode($product->name, 15, 512) ?>;
        const productUnit = <?php echo json_encode($product->unit ?? 'pcs', 15, 512) ?>;
        const tefaName = <?php echo json_encode($product->tefa->name ?? 'SMKN 1 Ciamis', 15, 512) ?>;
        const buyerName = document.getElementById('buyerName').value;
        const buyerPhone = document.getElementById('buyerPhone').value;
        const qty = document.getElementById('orderQty').value;
        const address = document.getElementById('buyerAddress').value;
        const notes = document.getElementById('buyerNotes').value;
        const totalPrice = document.getElementById('totalPriceDisplay').innerText;
        
        if (!buyerName || !buyerPhone) {
            alert('Mohon lengkapi Nama dan No. WhatsApp Anda');
            return;
        }
        
        let message = `*Halo Admin TEFA ${tefaName}* 👋\n\n`;
        message += `Saya ingin memesan produk berikut:\n`;
        message += `🛍️ *Produk:* ${productName}\n`;
        message += `📦 *Jumlah:* ${qty} ${productUnit}\n`;
        message += `💰 *Total Estimasi:* ${totalPrice}\n\n`;
        message += `📋 *Data Pemesan:*\n`;
        message += `👤 Nama: ${buyerName}\n`;
        message += `📱 No. HP: ${buyerPhone}\n`;
        
        if (address) {
            message += `📍 Alamat/Info: ${address}\n`;
        }
        
        if (notes) {
            message += `📝 Catatan: ${notes}\n`;
        }
        
        message += `\nMohon konfirmasi ketersediaan stok dan total pembayaran. Terima kasih!`;
        
        const encodedMessage = encodeURIComponent(message);
        const whatsappNumber = "<?php echo e($whatsappNumber ?? '6287790984032'); ?>"; // Fallback if variable not set
        
        window.open(`https://wa.me/${whatsappNumber}?text=${encodedMessage}`, '_blank');
        
        // Optional: Close modal after sending
        const modalEl = document.getElementById('orderModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/product/show.blade.php ENDPATH**/ ?>