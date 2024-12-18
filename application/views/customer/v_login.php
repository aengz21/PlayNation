<div class="container-fluid mb-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <?php
            echo validation_errors('<div class="mt-2 alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>', '</div>');

            if ($this->session->flashdata('error')) {
                echo '<div class="mt-2 alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Alert!</h5>';
                echo $this->session->flashdata('error');
                echo '</div>';
            }

            if ($this->session->flashdata('pesan')) {
                echo '<div class="mt-2 alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Maaf!</h5>';
                echo $this->session->flashdata('pesan');
                echo '</div>';
            } 
            if ($this->session->flashdata('berhasil')) {
                echo '<div class="mt-2 alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Selamat!</h5>';
                echo $this->session->flashdata('berhasil');
                echo '</div>';
            } ?>
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <h4 class="text-center font-weight-bold">LOGIN</h4>
                    <hr>
                    <?php echo form_open('customer/login') ?>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ingatkan Saya</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                    <div class="text-center mt-3">
                        <a href="<?= base_url('customer/forgot_password') ?>" class="btn btn-link">Lupa Password?</a>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="register mt-3 text-center">
                <p>
                    Belum punya akun? <a href="<?= base_url('customer/register') ?>" class="font-weight-bold">Daftar Sekarang!</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>template/vendor/jquery/jquery.min.js"></script>
<script>
    window.setTimeout(() => {
        $(".alert").fadeTo(500, 0).slideUp(500, () => {
            $(this).remove();
        })
    }, 2500)
</script>