<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Reset Password <i class="fas fa-lock"></i></h2>
        <div class="card">
            <div class="card-body">
                <?php if ($this->session->flashdata('pesan')): ?>
                    <div class="alert alert-info">
                        <?php echo $this->session->flashdata('pesan'); ?>
                    </div>
                <?php endif; ?>
                <form action="<?php echo base_url('customer/reset_password?token=' . $this->input->get('token')); ?>" method="post">
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                        <?php echo form_error('new_password'); ?>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <?php echo form_error('confirm_password'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>
            </div>
        </div>
        <p class="text-center">Sudah ingat password? <a href="<?php echo base_url('customer/login'); ?>">Login di sini</a></p>
    </div>
    <br>
</body>

</html>