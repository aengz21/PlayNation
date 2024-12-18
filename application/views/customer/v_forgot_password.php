<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e9ecef; /* Warna latar belakang yang lebih lembut */
        }
        .forgot-password-container {
            max-width: 400px; /* Lebar maksimum form */
            margin: 100px auto; /* Pusatkan form */
            padding: 30px; /* Padding dalam form */
            background-color: #ffffff; /* Warna latar belakang form */
            border-radius: 10px; /* Sudut melengkung */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Bayangan yang lebih halus */
        }
        .forgot-password-title {
            text-align: center; /* Pusatkan judul */
            margin-bottom: 30px; /* Jarak bawah judul */
            font-size: 24px; /* Ukuran font yang lebih besar */
            color: #343a40; /* Warna teks judul */
        }
        .form-group label {
            font-weight: bold; /* Tebalkan label */
            color: #495057; /* Warna label */
        }
        .btn-primary {
            background-color: #007bff; /* Warna tombol */
            border-color: #007bff; /* Warna border tombol */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Warna tombol saat hover */
            border-color: #0056b3; /* Warna border tombol saat hover */
        }
    </style>
</head>
<body>
    <div class="forgot-password-container "> <!-- Kontainer untuk form lupa password -->
        <h2 class="forgot-password-title">LUPA PASSWORD</h2>
        <?php if ($this->session->flashdata('pesan')): ?>
            <div class="alert alert-info">
                <?php echo $this->session->flashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo base_url('customer/forgot_password'); ?>" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required>
                <?php echo form_error('email'); ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Kirim Link Reset Password</button>
        </form>
    </div>
</body>
</html>