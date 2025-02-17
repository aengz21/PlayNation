<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Accessoris</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Accessoris</h6>
            <div class="card-tools">
                <button type="button" data-toggle="modal" data-target="#addAccessoris" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Accessoris</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($accessoris as $item) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $item['nama']; ?></td>
                                <td>
                                    <a href="<?= base_url('accessoris/edit/' . $item['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('accessoris/delete/' . $item['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Accessoris -->
<div class="modal fade" id="addAccessoris">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Accessoris</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                echo form_open('accessoris/add');
                ?>
                <div class="form-group">
                    <label for="nama">Nama Accessoris</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Accessoris" required>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div> 