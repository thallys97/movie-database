<?php foreach($data['movies'] as $movie): ?>
    <div class="movie">
        <h3><?= $movie->title; ?></h3>
        <!-- Outras informações do filme -->
    </div>
<?php endforeach; ?>
