<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minha Watchlist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php require 'header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mt-2 md:mt-0">Minha Watchlist</h1>
    <?php if (empty($data['watchlist'])): ?>
        <div class="mt-4">
            <p class="text-xl">Nenhum filme foi adicionado na watchlist.</p>
        </div>
    <?php else: ?>
        <div>
            <!-- Aqui você irá listar os filmes da watchlist -->
            <?php foreach ($data['watchlist'] as $movie): ?>
                <!-- Exemplo simples apenas mostrando o ID do filme -->
                <p>Filme TMDB ID: <?= htmlspecialchars($movie->tmdb_movie_id) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
