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
    <?php if (empty($data['watchlistMovies'])): ?>
        <div class="mt-4">
            <p class="text-xl">Nenhum filme foi adicionado na watchlist.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" id="watchlist-grid">
            <?php foreach ($data['watchlistMovies'] as $movie): ?>
                
                    <div class="card" id="movie-<?= $movie['id']; ?>">
                    <a href="/movie/<?= $movie['id']; ?>" >
                        <img src="https://image.tmdb.org/t/p/w500<?= $movie['poster_path'] ?>" alt="<?= $movie['title'] ?>" class="card-img-top">
                    </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                            <p class="card-text"><?= implode(', ', array_column($movie['genres'], 'name')) ?></p>
                            <p class="card-text">Avaliação: <?= htmlspecialchars($movie['vote_average']) ?>/10</p>
                            <button class="remove-from-watchlist bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-movie-id="<?= $movie['id']; ?>">
                                Remover
                            </button>
                        </div>
                    </div>
                
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-from-watchlist').forEach(button => {
        button.addEventListener('click', function() {
            var movieId = this.getAttribute('data-movie-id');
            fetch('/delete-from-watchlist/' + movieId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'movie_id=' + movieId
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    var cardToRemove = document.getElementById('movie-' + movieId);
                    cardToRemove.parentNode.removeChild(cardToRemove);
                } else {
                    alert('Não foi possível remover o filme da watchlist.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        });
    });
});
</script>

</body>
</html>
