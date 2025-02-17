<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .navbar { background-color: #f8f9fa; }
        .navbar-brand img { height: 100px; }
        .carousel-item img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }
        .side-menu {
            border: 2px solid #e0e0e0; padding: 15px; border-radius: 10px; background-color: #f8f9fa;
        }
        .side-menu h5 { font-size: 1.2em; font-weight: bold; text-align: center; }
        .side-menu a { text-decoration: none; color: #333; padding: 10px; display: block; transition: 0.3s; }
        .side-menu a:hover { background-color: #e9ecef; border-radius: 5px; }
        
        .product-card {
            position: relative; cursor: pointer; transition: all 0.3s; border: 1px solid #e0e0e0;
            border-radius: 10px; padding: 15px; background-color: #fff; box-sizing: border-box; margin-bottom: 20px;
        }
        .product-card img { width: 100%; height: 200px; object-fit: cover; }
        .product-card .lihat-produk { display: none; position: absolute; bottom: 15px; left: 15px; right: 15px; }
        .product-card:hover .lihat-produk { display: block; }
        .product-info { padding-bottom: 50px; }
        .price { font-size: 1.2em; font-weight: bold; color: #47b04b; margin-top: 10px; }
        .stok-habis-overlay {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8); color: red; padding: 10px 50px;
            font-size: 1.5em; font-weight: bold; border-radius: 5px; text-align: center;
        }
        
        /* Responsive styling */
        @media (max-width: 1200px) { .product-card { flex: 1 1 calc(33.33% - 20px); } }
        @media (max-width: 768px) { .side-menu { width: 100%; margin-bottom: 20px; } .product-card { flex: 1 1 calc(50% - 20px); } }
        @media (max-width: 480px) { .product-card { flex: 1 1 100%; } }
        .carousel {
            margin-top: 50px; /* Sesuaikan dengan tinggi header */
        }
        .wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        border: none;
        border-radius: 50%;
        padding: 8px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }
    .text-red {
        color: red;
    }

    .wishlist-btn i {
        color: gray;
        font-size: 16px;
    }

    .wishlist-btn:hover {
        background-color: red;
    }

    .wishlist-btn:hover i {
        color: white;
    }

    /* Tooltip */
    .wishlist-btn .tooltip-text {
        visibility: hidden;
        background-color: black;
        color: white;
        text-align: center;
        padding: 5px 8px;
        border-radius: 4px;
        position: absolute;
        top: 100%;
        right: 0;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        font-size: 12px;
    }

    .wishlist-btn:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
    </style>

</head>
<body>
    <!-- Slider Section -->
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($slider as $key => $value) : ?>
                <div class="carousel-item <?= ($key == 0) ? 'active' : ''; ?>">
                    <a href="<?= $value->link ?>">
                        <img src="<?= base_url('assets/sliders/' . $value->img) ?>" alt="Slider">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

    <!-- Main Content: Category, Promos, and Latest Products -->
    <div class="container mt-5">
        <div class="row">
            <!-- Category Menu -->
            <div class="col-md-3">
                <div class="side-menu">
                    <h5><i class="fa fa-list"></i> KATEGORI</h5>
                    <?php foreach ($category as $cat) : ?>
                        <a href="<?= base_url('store/kategori/' . $cat->id); ?>"><?= $cat->kategori; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php $is_logged_in = isset($_SESSION['id_customer']); ?>
            <!-- Promo Products Section -->
               <!-- Produk Terbaru -->
               <div class="col-md-9">
            <h4 class="font-weight-bold"><i class="fa fa-shopping-bag"></i> PRODUK TERBARU</h4>
            <hr style="border-top: 5px solid rgb(154 155 156);border-radius:.5rem">
                
                <div class="row">
                    <?php foreach ($product as $key => $value) { ?>
                        <div class="col-md-4 mt-4">
                            <div class="card h-100 border-0 shadow rounded-md product-card" data-url="<?= base_url('store/detail_product/' . $value->id_product) ?>">
                                <!-- Gambar Produk -->
                                <div class="card-img text-center position-relative">
                                    <?php if ($value->stock == 0) { ?>
                                        <div class="stok-habis-overlay">
                                            Stok Kosong
                                        </div>
                                    <?php } ?>
                                    
                                    <!-- Cek apakah produk baru -->
                                    <?php 
                                    $isNew = isset($value->date_added) && (strtotime($value->date_added) >= strtotime('-1 day')); 
                                    ?>
                                    <?php if ($isNew) { ?>
                                        <span class="badge badge-warning position-absolute" style="top: 10px; left: 10px;">New</span>
                                    <?php } ?>
                                    
                                    <img src="<?= base_url('assets/products_img/' . $value->img); ?>" class="img-fluid">
                                    <button class="wishlist-btn fa fa-heart" data-id="<?= $value->id_product ?>">

                        </button>
                                </div>
                                
                                <!-- Informasi Produk -->
                                <div class="card-body product-info text-center">
                                    <h5 class="card-title font-weight-bold" style="font-size:20px">
                                        <?= $value->title; ?>
                                    </h5>

                                    <!-- Diskon -->
                                    <?php if ($value->discount > 0) { ?>
                                        <div class="discount mt-2">
                                            <span class="original-price" style="text-decoration: line-through; opacity: 0.7; color: #999;">
                                                Rp. <?= number_format($value->price); ?>
                                            </span>
                                            <span style="background-color: darkorange" class="badge badge-pill badge-success text-white">
                                                DISKON <?= $value->discount ?> %
                                            </span>
                                        </div>
                                    <?php } ?>

                                    <!-- Harga setelah diskon -->
                                    <div class="price font-weight-bold mt-3" style="color: #47b04b;font-size:20px">
                                        Rp. <?= number_format($value->price - ($value->price * $value->discount) / 100); ?>
                                    </div>
                                </div>

                                <!-- Button Lihat Produk -->
                                <a href="<?= base_url('store/detail_product/' . $value->id_product) ?>" 
                                   class="btn btn-primary btn-md shadow-md lihat-produk mt-3">
                                   LIHAT PRODUK
                                </a>

                                
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bagian Diskon -->
    <div class="container mt-5 border border-warning rounded p-3" style="background-color: #e9f7ef;">
        <div class="discount-section">
            <h4 class="font-weight-bold text-center">Kejar Diskon Spesial</h4>
            <div class="row">
                <?php 
                // Mengurutkan produk berdasarkan tanggal ditambahkan dan mengambil 3 produk terakhir
                usort($product, function($a, $b) {
                    $dateA = isset($a->date_added) ? strtotime($a->date_added) : 0;
                    $dateB = isset($b->date_added) ? strtotime($b->date_added) : 0;
                    return $dateB - $dateA;
                });
                $latestProducts = array_slice(array_filter($product, function($value) {
                    return $value->discount > 0;
                }), 0, 3); // Ambil hanya 3 produk terbaru dengan diskon

                foreach ($latestProducts as $key => $value) { ?>
                    <div class="col-md-4 mt-4">
                        <div class="card h-100 border-0 shadow rounded-md product-card" data-url="<?= base_url('store/detail_product/' . $value->id_product) ?>">
                            <!-- Gambar Produk -->
                            <div class="card-img text-center">
                                <img src="<?= base_url('assets/products_img/' . $value->img); ?>" class="img-fluid rounded-top">
                                <a href="<?= base_url('store/detail_product/' . $value->id_product) ?>
                            </div>
                            
                            <!-- Informasi Produk -->
                            <div class="card-body product-info text-center">
                                <h5 class="card-title font-weight-bold" style="font-size:20px">
                                    <?= $value->title; ?>
                                </h5>

                               <!-- Diskon dengan border -->
                               <div class="discount mt-2 ">
                                    <span class="original-price" style="text-decoration: line-through; opacity: 0.7; color: #999;">
                                        Rp. <?= number_format($value->price); ?>
                                    </span>
                                    <span style="background-color: darkorange" class="badge badge-pill badge-success text-white">
                                        DISKON <?= $value->discount ?> %
                                    </span>
                               </div>

                                <!-- Harga setelah diskon -->
                                <div class="price font-weight-bold mt-3" style="color: #47b04b;font-size:20px">
                                    Rp. <?= number_format($value->price - ($value->price * $value->discount) / 100); ?>
                                </div>
                            </div>

                            <!-- Button Lihat Produk -->
                            <a href="<?= base_url('store/detail_product/' . $value->id_product) ?>" 
                               class="btn btn-primary btn-md shadow-md lihat-produk mt-3">
                               LIHAT PRODUK
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- Button untuk melihat semua produk diskon -->
            <div class="text-center mt-4">
                <a href="<?= base_url('store/promo') ?>" class="btn btn-warning">Lihat Semua Produk Diskon</a>
            </div>
        </div>
    </div>
    <br>
    <br>


    <!-- Script untuk Menampilkan Tombol Lihat Produk saat Hover -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      
        // Klik card masuk ke detail produk
        $(".product-card").on("click", function() {
            var url = $(this).data("url");
            window.location.href = url;
        });

        $(document).ready(function() {
            // Cek status wishlist dan ubah warna tombol
            $('.wishlist-btn').each(function() {
                let id_product = $(this).data('id');
                let button = $(this);
                $.ajax({
                    url: "<?= base_url('customer/check_wishlist_status') ?>",
                    type: "POST",
                    data: { id_product: id_product },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "in_wishlist") {
                            button.addClass('text-red');
                        } else {
                            button.removeClass('text-red');
                        }
                    }
                });
            });

            // Klik tombol wishlist
            $('.wishlist-btn').on('click', function(e) {
                e.stopPropagation(); // Mencegah event click pada card
                let id_product = $(this).data('id');
                let button = $(this);

                $.ajax({
                    url: "<?= base_url('customer/toggle_wishlist') ?>",
                    type: "POST",
                    data: { id_product: id_product },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "added") {
                            button.addClass('text-red');
                            alert('Produk ditambahkan ke wishlist.');
                        } else if (response.status === "removed") {
                            button.removeClass('text-red');
                            alert('Produk dihapus dari wishlist.');
                        } else if (response.status === "not_logged_in") {
                            window.location.href = "<?= base_url('customer/login') ?>";
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
