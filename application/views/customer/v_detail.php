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
                    <div class="zoom-container">
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
                    <h3 class="font-weight-bold text-primary">KETERANGAN</h3>
                    <hr>
                    <div class="ket" style="font-size: 1.2rem; line-height: 1.7; color: #34495e;">
                        <?= $product->description; ?>
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
</script>
