<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Últimos Filmes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclua a CDN do Tailwind CSS aqui -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div class="container mx-auto px-4">

    <h1 class="text-2xl font-bold mb-4">Filmes em exibição nos cinemas</h1>
    <?php if (isset($data['tmdbMovies']) && is_array($data['tmdbMovies'])): ?>
        <div class="grid grid-cols-5 gap-4">
            <?php foreach ($data['tmdbMovies'] as $movie): ?>
                 
                <a href="/movie/<?= $movie['id']; ?>"  class="movie bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']); ?>" alt="<?= htmlspecialchars($movie['title']); ?>" class="w-full">
                    <div class="p-4">
                        <h3 class="font-bold"><?= htmlspecialchars($movie['title']); ?></h3>
                        <div class="text-gray-700 text-sm">
                            <?php foreach ($movie['genre_ids'] as $genre_id): ?>
                                <span><?= htmlspecialchars($data['genresMap'][$genre_id] ?? 'Gênero Desconhecido'); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-yellow-500 text-xs mt-2">
                            ⭐ <?= htmlspecialchars(number_format($movie['vote_average'], 1)); ?>/10
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Nenhum filme encontrado.</p>
    <?php endif; ?>
</div>

</body>
</html>