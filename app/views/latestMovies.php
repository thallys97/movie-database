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

<?php require 'header.php'; ?>

<div class="container mx-auto px-4">

    <?php require 'searchMovieForm.php'; ?>

    <?php if (!$data['movieIsSearched']): ?>
    <h1 class="text-2xl font-bold mb-4">Filmes em Destaque</h1>
    <?php endif; ?> 

    <?php if (isset($data['tmdbMovies']) && is_array($data['tmdbMovies'])): ?>
         <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <?php foreach ($data['tmdbMovies'] as $movie): ?>
                 
                <a href="/movie/<?= $movie['id']; ?>"  class="movie bg-white shadow-lg rounded-lg overflow-hidden">
                    <?php if ($movie['poster_path']): ?>
                        <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($movie['poster_path']); ?>" alt="<?= htmlspecialchars($movie['title']); ?>" class="w-full">
                    <?php else: ?>
                        <img src="/images/sem-imagem.jpg" alt="<?= htmlspecialchars($movie['title']); ?>" class="w-full">
                    <?php endif; ?>
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

    <?php
    $currentPage = $data['currentPage'];
    $totalPages = $data['totalPages'];
    ?>

    <?php if (!$data['movieIsSearched']): ?>
        <div class="pagination-container flex flex-wrap justify-center mt-8 space-x-1">
            <?php if ($currentPage > 1): ?>
                <a href="/?page=<?= $currentPage - 1 ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded-l">
                    &#8592; Anterior
                </a>
            <?php endif; ?>

            <?php if ($currentPage > 3): ?>
                <a href="/?page=1" class="hidden sm:inline bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded">1</a>
                <span class="hidden sm:inline py-2 px-3">...</span>
            <?php endif; ?>

            <?php for ($i = max($currentPage - 1, 1); $i <= min($currentPage + 1, $totalPages); $i++): ?>
                <a href="/?page=<?= $i; ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded <?= $i === $currentPage ? 'bg-blue-500' : ''; ?>">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages - 2): ?>
                <span class="hidden sm:inline py-2 px-3">...</span>
                <a href="/?page=<?= $totalPages; ?>" class="hidden sm:inline bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded"><?= $totalPages; ?></a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="/?page=<?= $currentPage + 1 ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded-r">
                    Próximo &#8594;
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>                
</div>

</body>
</html>