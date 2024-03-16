<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minhas Reviews</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php require 'header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold">Minhas Reviews</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($data['myReviews'] as $review): ?>
            <div class="review-card bg-white shadow-lg rounded-lg p-4">
                <?php foreach ($data['reviewMoviesDetails'] as $movieDetail): ?>
                    <?php if ($movieDetail['id'] == $review->tmdb_movie_id): ?>
                        <!-- <img src="https://image.tmdb.org/t/p/w500<?= $movieDetail['poster_path'] ?>" alt="Poster" class="rounded-lg"> -->
                        
                        <h2 class="text-xl font-bold">
                            <?= $movieDetail['title'] . ' (' . date('Y', strtotime($movieDetail['release_date'])) . ')' ?>
                        </h2>
                    <?php endif; ?> 
                <?php endforeach; ?>        
                <div class="review-content p-4">
                    <?php if (!is_null($review->rating)): ?>
                        <p>Minha Avaliação: <?= htmlspecialchars($review->rating) ?>/10</p>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($review->comment) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>