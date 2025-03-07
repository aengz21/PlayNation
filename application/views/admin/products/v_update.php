<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-shopping-bag"></i> <?= $title; ?></h6>
                </div>

                <div class="card-body">
                    <?php
                    // Notif Data Kosong
                    echo validation_errors('<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-info"></i>', '</h5> </div>');
                    
                    // Notifikasi gagal Upload
                    if (isset($error_upload)) {
                        echo '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-info"></i>' . $error_upload . '</h5> </div>';
                    }
                    echo form_open_multipart('products/update/' . $product->id_product) ?>
                        
                        <div class="form-group">
                            <label>NAMA PRODUK</label>
                            <input type="text" name="title" value="<?= $product->title; ?>" placeholder="Masukkan Nama Produk" class="form-control">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>KATEGORI</label>
                                    <select name="kategori" class="form-control">
                                        <option value="<?= $product->id_category ?>"><?= $product->kategori ?></option>
                                        <?php foreach ($category as $key => $value) { ?>
                                            <option value="<?= $value->id ?>"><?= $value->kategori; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <select name="brand" class="form-control">
                                            <option value="<?= $product->id_brand ?>"><?= $product->brands ?></option>
                                                <?php foreach ($brands as $key => $value) { ?>
                                                    <option value="<?= $value->id ?>"><?= $value->brands; ?></option>
                                                    <?php } ?>
                                                </select>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>BERAT (gram)</label>
                                    <input type="number" name="weight" class="form-control" value="<?= $product->weight ?>" placeholder="Berat Produk (gram)">
                                    <div class="form-group">
                                        <label>Stok</label>
                                        <input type="number" name="stok" class="form-control" value="<?= $product->stock ?>" placeholder="Stok Barang">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>DESKRIPSI</label>
                            <textarea class="form-control content" name="description" rows="6" placeholder="Deskripsi Produk"><?= $product->description ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>HARGA</label>
                                    <input type="number" name="price" class="form-control" value="<?= $product->price ?>" placeholder="Harga Produk">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>DISKON (%)</label>
                                    <input type="number" name="discount" class="form-control" value="<?= $product->discount ?>" placeholder="Diskon Produk (%)">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.4/tinymce.min.js"></script>
<script>
    var editor_config = {
        selector: "textarea.content",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
    };

    tinymce.init(editor_config);
</script>