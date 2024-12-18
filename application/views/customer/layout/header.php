<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayNation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /* Dropdown Menu */
        .dropdown-menu {
            background-color: #333333;
            width: 700px; /* Adjusted width */
            padding: 20px;
            border: none;
        }

        /* Grid System for dropdown */
        .dropdown-menu .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Dropdown Item Styles */
        .dropdown-item {
            padding: 5px 10px;
            color: #ffffff;
            font-size: 14px;
            text-align: left;
            transition: background-color 0.3s ease;
        }
        .dropdown:hover .dropdown-menu {
    display: block;
}

        .dropdown-item:hover {
            background-color: #555555;
        }

        /* Section Header */
        .dropdown-header {
            font-size: 1.1rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 8px;
        }

        /* Adjust padding and margin */
        .dropdown-section {
            margin-bottom: 20px;
        }

        /* Navbar styles */
        .nav-link {
            color: #ffffff !important;
        }

        .nav-item:hover .nav-link {
            color: #CCCCCC !important;
        }

        .dropdown-divider {
            border-color: #666666;
        }

        /* General improvements */
        .navbar-nav .nav-item {
            padding-left: 20px;
        }
        .header .logo img {
            height: 6rem; /* Ubah ukuran logo */
            width: 10rem; /* Ubah ukuran logo */
            margin-right: 20px; /* Jarak antara logo dan teks */
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="section-header header-login">
        <section class="header-main border-bottom">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-md-3 col-7">
                        <a href="<?= base_url() ?>" class="text-decoration-none d-flex flex-column align-items-center">
                            <img src="<?= base_url('assets/favicon/icon2.png') ?>" alt="logo" class="img-fluid" style="width: 50%; height: auto;">
                        </a>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-5 d-none d-md-block">
                        <form action="<?= site_url('store/search') ?>" method="post" class="search-wrap">
                            <div class="input-group w-100">
                                <input type="text" class="form-control search-form" style="width:55%;border: 1px solid #666666" name="search_title" placeholder="Cari di <?= $settings->nama_toko; ?>...">
                                <div class="input-group-append">
                                    <button class="btn search-button" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Cart and Account -->
                    <div class="col-md-4 col-5">
                        <div class="d-flex justify-content-end">
                            <?php 
                            $keranjang = $this->cart->contents();
                            $item = 0;
                            $total = 0;

                            foreach ($keranjang as $key => $value){
                                $item = $item + $value['qty'];
                                $total = $total + $value['subtotal'];
                            }
                            ?>
                            <div class="cart-header">
                                <a href="<?= base_url('shopping'); ?>" class="btn search-button btn-md" style="color: #CCCCCC;background-color: #333333;border-color: #333333;">
                                    <i class="fa fa-shopping-cart"></i> <?= $item; ?> | Rp. <?= number_format($total); ?>
                                </a>
                            </div>

                            <div class="account">
                                <?php if ($this->session->userdata('logged_in')): ?>
                                    <a href="<?= base_url('customer/account') ?>" class="btn search-button btn-md d-none d-md-block ml-4" style="color: #333333;background-color: #CCCCCC;border-color: #CCCCCC;">
                                        <i class="fa fa-user-circle"></i> ACCOUNT
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('customer/login') ?>" class="btn search-button btn-md d-none d-md-block ml-4" style="color: #333333;background-color: #CCCCCC;border-color: #CCCCCC;">
                                        <i class="fa fa-sign-in-alt"></i> LOGIN
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg" style="background-color: #222222;">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon" style="color: #ffffff;"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url() ?>" style="color: #ffffff;">Home</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="shopAllDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #ffffff;">
                                        Shop All
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="shopAllDropdown">
                                    <div class="row">
                                            <div class="col-md-4 dropdown-section">
                                                <h6 class="dropdown-header">Categories</h6>
                                                <?php foreach ($category as $cat) { ?>
                                                 <a class="dropdown-item" href="<?= base_url('store/kategori/' . $cat->id); ?>">
                                                <?= $cat->kategori; ?>
                                                 </a>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4 dropdown-section">
                                                <h6 class="dropdown-header">GAMES</h6>
                                                <?php foreach($brand as $br) { ?>
                                                    <a class="dropdown-item" href="<?= base_url('store/brands/' . $br->id); ?>">
                                                        <?= $br->brands; ?>
                                                    </a>
                                               <?php } ?>
                                            </div>
                                            <div class="col-md-4 dropdown-section">
                                                <h6 class="dropdown-header">ACCESSORIES</h6>
                                                <a class="dropdown-item" href="<?= base_url('store/accessories'); ?>">All Accessories</a>
                                                <a class="dropdown-item" href="<?= base_url('store/accessories/steering'); ?>">Steering Wheels</a>
                                                <a class="dropdown-item" href="<?= base_url('store/accessories/chairs'); ?>">Gaming Chairs</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('store/promo') ?>" style="color: #ffffff;">Promo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('minibanner/index') ?>" style="color: #ffffff;">Category</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
    </header>

    <!-- Script Bootstrap, jQuery, Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Menampilkan dropdown saat hover
            $('.dropdown').hover(
                function() {
                    $(this).find('.dropdown-menu').stop(true, true).slideDown(200);
                },
                function() {
                    $(this).find('.dropdown-menu').stop(true, true).slideUp(200);
                }
            );

            // Redirect saat klik pada "Shop All"
            $('#shopAllDropdown').click(function(e) {
                e.preventDefault();
                window.location.href = '<?= base_url('store/all_products'); ?>'; // Ganti dengan URL yang sesuai
            });
        });
    </script>
</body>
</html>
