<style>
    .form-container {
        max-width: 400px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    .form-container h2 {
        text-align: center;
    }
    .form-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .form-container button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .form-container button:hover {
        background-color: #0056b3;
    }
</style>

<div class="form-container">
    <h2>Reset Password</h2>
    <form method="post" action="<?= base_url('adminauth/process_reset_password/'.$token); ?>">
    <input type="hidden" name="token" value="<?= $token ?>">
    <?php if ($valid_token): ?>
        <div class="input-field">
            <input type="password" name="password" required>
            <label for="password">Password Baru</label>
        </div>
        <button type="submit" class="btn">Reset Password</button>
    <?php else: ?>
        <p>Token tidak valid atau telah kedaluwarsa.</p>
    <?php endif; ?>
    </form>
</div>
