<div class="container mt-5 mb-5" style="background: linear-gradient(135deg, #f1f2f6, #dfe4ea); padding: 30px; border-radius: 15px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
    <?php 
        echo form_open('shopping/add');
        echo form_hidden('id', $product->id_product);
        echo form_hidden('name', $product->title);
        echo form_hidden('qty', 1);
        echo form_hidden('price', $product->price - ($product->price * $product->discount) / 100);
        echo form_hidden('discount', $product->discount);
        echo form_hidden('weight', $product->weight);
        echo form_hidden('stok', $product->stock);
        echo form_hidden('img', $product->img);
        echo form_hidden('redirect_page', current_url());    
    ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 rounded shadow-lg" style="background-color: #fff;">
                <div class="card-body p-0">
                    <div class="zoom-container" style="position: relative;">
                        <img src="<?= base_url('assets/products_img/' . $product->img); ?>" class="w-100 rounded" style="object-fit: cover; height: 300px; border-radius: 10px;">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 rounded shadow-lg" style="background-color: #fff;">
                
                <div class="card-body">
                    <h2 class="font-weight-bold text-primary"><?= $product->title; ?></h2>
                    
                    <hr>
                    <div class="price-product" id="price-product" style="font-size: 1.5rem; color: #27ae60;">
                        <span class="font-weight-bold mr-4">Rp. <?= number_format($product->price - ($product->price * $product->discount) / 100); ?></span>
                        <s class="font-weight-bold text-muted">Rp. <?= number_format($product->price); ?></s>
                    </div>
                    <table class="table table-borderless mt-3" style="font-size: 1.2rem;">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">DISKON</td>
                                <td>:</td>
                                <td>
                                    <span class="badge badge-pill badge-danger" style="border-radius: 20px;">
                                        DISKON <?= $product->discount; ?> %
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">BERAT</td>
                                <td>:</td>
                                <td>
                                    <span class="badge badge-pill badge-success" style="font-size: 1rem;"><?= $product->weight; ?> gram</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">STOK</td>
                                <td>:</td>
                                <td>
                                    <span class="badge badge-pill badge-info" style="font-size: 1rem;"><?= $product->stock > 0 ? $product->stock . ' item' : 'Stok kosong'; ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if ($product->stock > 0): ?>
                    <button id="swalDefaultSuccess" class="btn btn-lg btn-block" style="background-color: #3498db; color: #fff; font-size: 1.2rem; border-radius: 50px;">
                        <i class="fa fa-shopping-cart"></i> TAMBAH KE KERANJANG
                        </button>
                        <?php else: ?>
                            <p class="text-danger" style="font-size: 1.2rem;">Stok produk sekarang kosong <span role="img" aria-label="memohon">🙏</span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card border-0 rounded shadow-lg" style="background-color: #fff;">
                <div class="card-body">
                    <h3 class="font-weight-bold text-primary no-strike">KETERANGAN</h3>
                    <hr>
                    <div class="ket" style="font-size: 1.2rem; line-height: 1.7; color: #34495e;">
                        <?= $product->description; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
    <div class="col-md-12">
        <div class="card border-0 rounded shadow-lg" style="background-color: #fff;">
            <div class="card-body">
                <h3 class="font-weight-bold text-primary">Komentar & Rating</h3>
                <hr>
                <div class="existing-comments">
                    <?php if (!empty($comments)) : ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment-box">
                                <div class="comment-avatar">
                                    <img src="<?= base_url('assets/avatars/' . (isset($comment->avatar) ? $comment->avatar : 'default.png')); ?>" alt="Avatar">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <strong><?= $comment->user_name; ?></strong> - 
                                        <span class="comment-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fa fa-star <?= $i <= $comment->rating ? 'rated' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </span>
                                    </div>
                                    <p class="comment-text"><?= $comment->comment; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-muted">Belum ada komentar.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



                    </div>
                </div>
            </div>
        </div>
    </div> 
    <?php echo form_close(); ?>
</div>

<style>
    .zoom-container {
        overflow: hidden; /* Menyembunyikan bagian gambar yang melampaui batas */
        position: relative;
    }
    .zoom-container img {
        transition: transform 0.5s ease; /* Animasi zoom */
    }
    .zoom-container:hover img {
        transform: scale(1.1); /* Zoom effect */
    }
    .conten {
        padding-top: 90px; /* Sesuaikan dengan tinggi header */
    }
    .heart-icon {
        color: #fff; /* Default warna ikon putih */
        transition: color 0.3s ease; /* Animasi transisi warna */
    }
    .text-red .heart-icon {
        color: #e74c3c; /* Warna ikon merah jika di wishlist */
    }
    .comment-box {
    display: flex;
    align-items: flex-start;
    padding: 15px;
    border-bottom: 1px solid #ddd;
    background: #f9f9f9;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
}

.comment-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.comment-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.comment-content {
    flex-grow: 1;
}

.comment-header {
    font-size: 1rem;
    font-weight: bold;
    color: #2c3e50;
}

.comment-rating {
    color: #f39c12;
    font-size: 1rem;
}

.comment-rating .fa-star {
    margin-left: 3px;
}

.comment-rating .rated {
    color: #f1c40f;
}

.comment-text {
    font-size: 1rem;
    color: #34495e;
    margin-top: 5px;
    line-height: 1.5;
}

    
</style>

<script>
    document.getElementById('swalDefaultSuccess').addEventListener('click', function() {
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Produk Berhasil Di Tambahkan Ke Keranjang Anda!',
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            background: '#27ae60',
            iconColor: '#fff',
            color: '#fff',
            timerProgressBar: true
        });
    });

    $(document).ready(function() {
        // Cek status wishlist dan ubah warna ikon
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
            e.preventDefault();
            e.stopPropagation();
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
