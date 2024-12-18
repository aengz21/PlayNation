<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukkan Kode OTP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Masukkan Kode OTP</h2>
        <p>Kode OTP telah dikirim via e-mail ke <strong><?php echo $email; ?></strong></p>
        <form action="<?php echo base_url('customer/verify_otp'); ?>" method="post">
            <div class="form-group">
                <label for="otp">Kode OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" maxlength="6" required>
            </div>
            <button type="submit" class="btn btn-primary">LANJUT</button>
        </form>
        <p class="mt-3">Tidak menerima Kode OTP? <a href="<?php echo base_url('customer/forgot_password'); ?>">Kirim Ulang</a></p>
    </div>
</body>
</html> 