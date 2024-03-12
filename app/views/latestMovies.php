<?php if (isset($data['tmdbMovies']) && is_array($data['tmdbMovies'])): ?>
    <?php foreach ($data['tmdbMovies'] as $movie): ?>
        <?php if (isset($movie['title'])): // Certifique-se de que a chave 'title' existe ?>
            <div class="movie">
                <h3><?= htmlspecialchars($movie['title']); ?></h3>
                <!-- Outras informações do filme -->
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nenhum filme encontrado.</p>
<?php endif; ?>
