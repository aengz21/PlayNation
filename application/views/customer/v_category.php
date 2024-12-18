<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .category-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .category-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            padding: 20px;
            width: 200px;
            transition: transform 0.3s;
        }
        .category-card img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .category-card:hover {
            transform: scale(1.05);
        }
        .category-card h5 {
            font-size: 1em;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4 class="font-weight-bold text-center mt-5"><i class="fa fa-tags"></i> Brand</h4>
        <hr style="border-top: 5px solid rgb(154 155 156);border-radius:.5rem">
        <div class="category-grid">
            <?php foreach ($category as $cat) { ?>
                <div class="category-card">
                    <img src="<?= base_url('assets/category_img/' . $cat->img); ?>" alt="<?= $cat->kategori; ?>">
                    <h5><?= $cat->kategori; ?></h5>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
