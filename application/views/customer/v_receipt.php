<!DOCTYPE html>
<html>
<head>
    <title>Resi Pesanan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resi Pesanan</h1>
        <p>No. Invoice: <?= $details[0]->no_order; ?></p>
        <p>Nama: <?= strtoupper($details[0]->nama_penerima); ?></p>
        <p>Alamat: <?= $details[0]->alamat; ?></p>
        <p>No. Telp: <?= $details[0]->no_telp; ?></p>
        <p>Total Pembelian: Rp. <?= number_format($details[0]->total_bayar); ?></p>
        <h2>Detail Produk</h2>
        <table>
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
            </tr>
            <?php foreach ($details as $item): ?>
            <tr>
                <td><?= $item->product_name; ?></td>
                <td><?= $item->qty; ?></td>
                <td>Rp. <?= number_format($item->price - ($item->price * $item->discount / 100)); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html> 