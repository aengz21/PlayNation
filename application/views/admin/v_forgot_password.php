<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ asset('assets/img/company.png') }}" type="image/x-icon">
    <title>Lupa Password - Admin</title>
    <link href="<?= base_url() ?>template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url() ?>template/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body style="background-color: #e2e8f0;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card o-hidden border-0 shadow-lg mb-3 mt-5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="h5 text-gray-900 mb-3">Lupa Password</h1>
                        </div>
                        <form method="post" action="<?= base_url('adminauth/send_reset_email'); ?>">
                            <div class="form-group">
                                <label class="font-weight-bold text-uppercase">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Kirim Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>template/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url() ?>template/js/sb-admin-2.min.js"></script>
</body>

</html>
