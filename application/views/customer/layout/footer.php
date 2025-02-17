<footer style="background: #0b0b45; color: #ffffff;" class="footer pt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="font-weight-bold">About PlayNation</h4>
                <hr style="border-top: 3px solid rgb(226 232 240);border-radius:.5rem">
                <p>
                    PlayNation adalah toko online khusus yang menyediakan berbagai produk gaming berkualitas seperti konsol, controller, dan game. Kami menghadirkan pengalaman belanja yang cepat, aman, dan terpercaya, dengan pilihan produk terbaik untuk memaksimalkan pengalaman bermain Anda.
                </p>
                <div class="social">
                    <a href="https://www.facebook.com/profile.php?id=100012887618576" class="mr-2"> <i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="mr-2" style="color:#00c4ff"> <i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://www.instagram.com/aengz21/" class="mr-2" style="color: #de2fb8;"> <i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="mr-2" style="color: #25d366;"> <i class="fab fa-whatsapp fa-2x"></i></a>
                    <a href="#" class="mr-2" style="color: #0077b5;"> <i class="fab fa-linkedin fa-2x"></i></a>
                    <a href="#" style="color: red;"> <i class="fab fa-youtube fa-2x"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="font-weight-bold">Resources</h4>
                <hr style="border-top: 3px solid rgb(226 232 240);border-radius:.5rem">
                <ul class="list-unstyled">
                    <li><a href=<?= base_url('About/how_to_buy') ?> style="color: #ffffff;">How to Buy</a></li>
                    <li><a href=<?= base_url('about/tutorial') ?> style="color: #ffffff;">Tips & Tutorials</a></li>
                    <li><a href=<?= base_url('about/faq')?> style="color: #ffffff;">Faq</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="font-weight-bold">Visit Us</h4>
                <hr style="border-top: 3px solid rgb(226 232 240);border-radius:.5rem">
                <p>
                    <?= strip_tags($settings->alamat_toko); ?>
                </p>
                <h4 class="font-weight-bold">Store Hours</h4>
                <p>
                    Senin-Sabtu: 11:00 AM - 6:00 PM<br>
                    Minggu: 11:00 AM - 6:00 PM
                </p>
                <p>
                    Untuk pemesanan pada hari minggu atau hari besar akan di proses pada keesokan harinya.
                </p>
            </div>
        </div>
        <div class="row text-center mt-3 pb-3">
            <div class="col-md-12">
                <hr>
                <h4 class="font-weight-bold">MARKETPLACE</h4>
                <div class="d-flex justify-content-center">
                    <div class="row">
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/BCA.png" style="width: 50px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/BNI.png" style="width: 45px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/BRI.png" style="width: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/GOPAY.png" style="width: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/indomaret-logo.png" style="width: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/atm-bersama.jpg" style="width: 40px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/ovo.png" style="width: 60px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <div class="card h-100 border-0 rounded shadow">
                                <div class="card-body p-2 text-center">
                                    <img src="<?= base_url() ?>/assets/payment/dana.png" style="width: 60px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                © <strong>PlayNation</strong> <?= date('Y') ?> •
            </div>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>