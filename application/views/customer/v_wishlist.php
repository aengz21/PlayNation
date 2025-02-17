<style>
    .conten {
        padding-top: 90px;
    }
</style>

<div class="container-fluid mb-5 mt-4 conten">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 rounded shadow">
                <div class="card-body">
                    <h5 class="font-weight-bold">MAIN MENU</h5>
                    <hr>
                    <ul class="list-group">
                        <a href="<?= base_url('customer/account') ?>" class="list-group-item text-decoration-none text-dark text-uppercase">
                            <i class="fas fa-user-circle"></i> Account
                        </a>
                        <a href="<?= base_url('customer/my_orders') ?>" class="list-group-item text-decoration-none text-dark text-uppercase">
                            <i class="fas fa-shopping-cart"></i> My Order
                        </a>
                        <a href="<?= base_url('customer/wishlist') ?>" class="list-group-item text-decoration-none text-dark text-uppercase active">
                            <i class="fas fa-heart"></i> Wishlist
                        </a>
                        <a href="<?= base_url('customer/logout') ?>" style="cursor:pointer" class="list-group-item text-decoration-none text-dark text-uppercase">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9 mb-4">
            <div class="card border-0 rounded shadow">
                <div class="card-body">
                    <h5 class="font-weight-bold"><i class="fas fa-heart"></i> MY WISHLIST</h5>
                    <hr>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">PRODUCT</th>
                                <th scope="col">NAME</th>
                                <th scope="col">PRICE</th>
                                <th scope="col">OPTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($wishlist)) {
                                foreach ($wishlist as $item) { ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('uploads/products/'.$item->img) ?>" width="50" height="50" class="rounded">
                                        </td>
                                        <td><?= $item->title ?></td>
                                        <td>Rp. <?= number_format($item->price) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('store/detail_product/'.$item->id_product) ?>" class="btn btn-sm btn-primary">VIEW</a>
                                            <button class="btn btn-sm btn-danger remove-wishlist" data-id="<?= $item->id_product ?>">REMOVE</button>
                                        </td>
                                    </tr>
                            <?php } } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">Your wishlist is empty.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.remove-wishlist', function() {
        let id_product = $(this).data('id');
        let row = $(this).closest('tr');

        $.ajax({
            url: "<?= base_url('customer/remove_wishlist') ?>",
            type: "POST",
            data: { id_product: id_product },
            dataType: "json",
            success: function(response) {
                if (response.status === "removed") {
                    row.fadeOut(500, function() { $(this).remove(); });
                    alert(response.message);
                }
            }
        });
    });
</script>
