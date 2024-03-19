<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<?php require 'header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold">Escreva sua Review</h1>
    <form action="/submit-review/<?= $data['movieDetails']['id']; ?>" method="post">
        <div class="mt-4">
            <label for="rating" class="block text-sm font-medium text-gray-700">Nota</label>
            <input type="number" id="rating" name="rating" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Nota de 0 a 10" min="0" max="10" step="0.1">
        </div>
        <div class="mt-4">
            <label for="comment" class="block text-sm font-medium text-gray-700">Comentário</label>
            <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" placeholder="Escreva sua review aqui..." required></textarea>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Publicar Review</button>
        </div>
    </form>
</div>

</body>
</html>
