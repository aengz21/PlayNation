<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | Toko Game</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Frequently Asked Questions</h1>
        <div class="accordion" id="faqAccordion">
            <?php foreach ($faqs as $faq): ?>
                <div class="card">
                    <div class="card-header" id="heading<?= $faq->id ?>">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $faq->id ?>" aria-expanded="true" aria-controls="collapse<?= $faq->id ?>">
                                <?= $faq->question ?>
                            </button>
                        </h2>
                    </div>
                    <div id="collapse<?= $faq->id ?>" class="collapse" aria-labelledby="heading<?= $faq->id ?>" data-parent="#faqAccordion">
                        <div class="card-body">
                            <?= $faq->answer ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 