<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['movieDetails']['title']) ?> - Detalhes do Filme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php require 'header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/4">
            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($data['movieDetails']['poster_path']) ?>" alt="<?= htmlspecialchars($data['movieDetails']['title']) ?>" class="rounded shadow-md">
        </div>
        <div class="md:w-3/4 md:ml-4">
            <h1 class="text-4xl font-bold mt-2 md:mt-0"><?= htmlspecialchars($data['movieDetails']['title']) ?></h1>
            <p class="text-sm my-2">
                <strong>Gêneros:</strong> <?= implode(', ', array_map(function ($genre) use ($data) { return htmlspecialchars($data['genresMap'][$genre['id']] ?? 'Gênero Desconhecido'); }, $data['movieDetails']['genres'])) ?>
            </p>
            <p class="text-sm my-2">
                <strong>Data de Lançamento:</strong> <?= htmlspecialchars($data['movieDetails']['release_date']) ?>
            </p>
            <p class="text-sm my-2">
                <strong>Duração:</strong> <?= htmlspecialchars($data['movieDetails']['runtime']) ?> minutos
            </p>
            <p class="text-sm my-2">
                <strong>Avaliação:</strong> <?= htmlspecialchars($data['movieDetails']['vote_average']) ?>/10
            </p>
            <p class="text-sm my-2">
                <strong>Orçamento:</strong> $<?= htmlspecialchars(number_format($data['movieDetails']['budget'])) ?>
            </p>
            <p class="text-sm my-2">
                <strong>Bilheteria:</strong> $<?= htmlspecialchars(number_format($data['movieDetails']['revenue'])) ?>
            </p>
            <div class="mt-4">
                <h2 class="text-2xl font-bold">Descrição</h2>
                <p><?= htmlspecialchars($data['movieDetails']['overview']) ?></p>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl font-bold">Diretor(es)</h2>
                <div class="flex flex-wrap -mx-1 overflow-hidden">
                    <?php foreach ($data['movieDetails']['credits']['crew'] as $crew): ?>
                        <?php if ($crew['job'] === 'Director'): ?>
                            <div class="my-1 px-1 w-1/2 overflow-hidden md:w-1/6 lg:w-1/6 xl:w-1/6">
                                <img src="https://image.tmdb.org/t/p/w500<?= $crew['profile_path'] ?>" alt="<?= htmlspecialchars($crew['name']) ?>" class="rounded shadow-md">
                                <p class="text-center"><?= htmlspecialchars($crew['name']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-4">
                <h2 class="text-2xl font-bold">Elenco</h2>
                <div class="flex flex-wrap -mx-1 overflow-hidden">
                    <?php foreach ($data['movieDetails']['credits']['cast'] as $index => $cast): ?>
                        
                            <div class="my-1 px-1 w-1/2 overflow-hidden md:w-1/6 lg:w-1/6 xl:w-1/6">
                                <img src="https://image.tmdb.org/t/p/w500<?= $cast['profile_path'] ?>" alt="<?= htmlspecialchars($cast['name']) ?>" class="rounded shadow-md">
                                <p class="text-center"><?= htmlspecialchars($cast['name']) ?> (<?= htmlspecialchars($cast['character']) ?>)</p>
                            </div>
                        
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
