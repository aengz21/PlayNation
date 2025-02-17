<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin: 20px 0;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL ORDER <?= $details[0]->no_order; ?></h1>
        <hr>
    </div>
    <div class="details">
        <table>
            <tr>
                <td>NO. INVOICE</td>
                <td><?= $details[0]->no_order; ?></td>
            </tr>
            <tr>
                <td>NAMA LENGKAP</td>
                <td><?= strtoupper($details[0]->nama_penerima); ?></td>
            </tr>
            <tr>
                <td>NO. TELP / WA</td>
                <td><?= $details[0]->no_telp; ?></td>
            </tr>
            <tr>
                <td>KURIR / SERVICE / COST</td>
                <td><?= strtoupper($details[0]->courier); ?> / <?= strtoupper($details[0]->layanan_courier); ?> / Rp. <?= number_format($details[0]->ongkir); ?></td>
            </tr>
            <tr>
                <td>ALAMAT LENGKAP</td>
                <td><?= $details[0]->alamat; ?></td>
            </tr>
            <tr>
                <td>TOTAL PEMBELIAN</td>
                <td>Rp. <?= number_format($details[0]->total_bayar); ?></td>
            </tr>
            <tr>
                <td>METODE PEMBAYARAN</td>
                <td><?= strtoupper($details[0]->provider); ?></td>
            </tr>
        </table>
    </div>
    <div class="details">
        <h5>Produk Yang Dibeli</h5>
        <table>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Qty</th>
            </tr>
            <?php foreach ($details as $value): ?>
            <tr>
                <td><?= $value->product_name; ?></td>
                <td>Rp. <?= number_format($value->price - ($value->price * $value->discount / 100)); ?></td>
                <td><?= $value->qty; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html> 