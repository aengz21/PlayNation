<style>
    .border {
        border: 1px solid #ddd;
    }
    .rounded {
        border-radius: 8px;
    }
    .p-3 {
        padding: 16px;
    }
    .conten {
        padding-top: 60px;
    }
    .product-card {
        position: relative;
        cursor: pointer;
    }
    .btn-view {
        display: none;
        position: absolute;
        bottom: 10px;
        left: 10px;
        right: 10px;
    }
    .product-card:hover .btn-view {
        display: block;
    }
</style>

<div class="container-fluid mb-5 mt-4 conten">
    <div class="row">
        <!-- Sidebar Pencarian -->
        <div class="col-md-3">
            <div class="p-3 border rounded">
                <h5 class="font-weight-bold">Search for a Product</h5>
                <form action="<?= base_url('store/search'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search_title" placeholder="Search here...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                    <h5 class="font-weight-bold">Search by Price</h5>
                    <div class="form-group">
                        <input type="number" class="form-control mb-2" name="min_price" placeholder="Min Price">
                        <input type="number" class="form-control" name="max_price" placeholder="Max Price">
                    </div>

                    <button class="btn btn-primary btn-block" type="submit">Filter</button>
                </form>
            </div>
        </div>

        <!-- Data Produk -->
        <div class="col-md-9">
            <div class="row">
                <?php foreach ($product as $key => $value) { ?>
                    <div class="col-md-4 mt-4">
                        <div class="card h-100 border-0 shadow rounded-md product-card" data-url="<?= base_url('store/detail_product/' . $value->id_product) ?>">
                            <div class="card-img text-center">
                                <img src="<?= base_url('assets/products_img/' . $value->img); ?>" class="img-fluid" style="height: 15em;object-fit:cover;border-top-left-radius: .25rem;border-top-right-radius: .25rem;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold" style="font-size:20px">
                                    <?= $value->title; ?>
                                </h5>

                                <div class="price font-weight-bold mt-3 mb-4" style="color: #47b04b;font-size:20px">
                                    Rp. <?= number_format($value->price); ?>
                                </div>
                            </div>
                            <a href="<?= base_url('store/detail_product/' . $value->id_product) ?>" class="btn btn-primary btn-md btn-view shadow-md">LIHAT PRODUK</a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <?= $pagination; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Klik card masuk ke detail produk
    $(".product-card").on("click", function() {
        var url = $(this).data("url");
        window.location.href = url;
    });
</script>

