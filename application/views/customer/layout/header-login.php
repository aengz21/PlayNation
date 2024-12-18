<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlayNation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        /* Gaya untuk header login */
        .header-login {
            background-color: #000000;
            padding: 0px 30px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-login .logo {
            display: flex;
            align-items: center;
            margin-right: auto;
        }
        .header-login .logo img {
            height: 6rem; /* Ubah ukuran logo */
            width: 10rem; /* Ubah ukuran logo */
            margin-right: 20px; /* Jarak antara logo dan teks */
            margin-left: 20px;
        }
        .header-login .logo span {
            font-size: 1.2rem; /* Ubah ukuran font */
            margin-left: 10px; /* Jarak antara logo dan teks */
            align-self: center; /* Pastikan teks sejajar dengan logo */
        }
        .header-login .login-button {
            background-color: #ff5722; /* Warna tombol */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-left: 20px;
            position: relative;
            top: 0;
        }
    </style>
</head>
<body>
    <!-- Header Login -->
    <header class="header-login">
        <div class="logo">
            <a href="<?= base_url('store') ?>">
            <img src="<?= base_url('assets/favicon/icon2.png') ?>" alt="logo">
        </a>
            <span>Login</span>
        </div>
        <a href="<?= base_url('#') ?>">Pusat Bantuan</a>
    </header>

  



    <!-- Script Bootstrap, jQuery, Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
