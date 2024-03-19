<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Review - <?= htmlspecialchars($data['movieDetails']['title']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/review.css">
</head>
<body>

<?php require 'header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="review-card bg-white shadow-lg rounded-lg p-4">
        <div class="review-header flex flex-col-reverse md:flex-row md:justify-between md:items-center mb-4">
            <h1 class="text-4xl font-bold"><?= htmlspecialchars($data['movieDetails']['title']) . ' (' . htmlspecialchars(date('Y', strtotime($data['movieDetails']['release_date']))) . ')' ?></h1>
            <div class="flex gap-2">
                <a href="/edit-review/<?= $data['review']->id ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Editar</a>
                <form action="/delete-review/<?= $data['review']->id ?>" method="post">
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Deletar</button>
                </form>
            </div>
        </div>
        <?php if (!is_null($data['review']->rating)): ?>
            <p class="review-rating font-bold text-xl">Avaliação: <?= htmlspecialchars($data['review']->rating) ?>/10</p>
        <?php endif; ?>
        <div class="review-content mb-4">
            <p class="review-text"><?= nl2br(htmlspecialchars($data['review']->comment)) ?></p>
        </div>
    </div>
</div>

</body>
</html>
