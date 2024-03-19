<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['movieDetails']['title']) ?> - Detalhes do Filme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>

        .hidden {
            display: none;
        }

        .swiper-container {
            position: relative; /* Novo estilo para posicionar os filhos absolutamente */
            width: 100%;
            height: auto; /* Isso permite que o contêiner cresça com o conteúdo */
            overflow: hidden; /* Isso impede que as imagens transbordem */
            cursor: grab;
        }

        .swiper-container:active {
            cursor: grabbing;
        }

        .swiper-button-next, .swiper-button-prev {
            position: absolute; /* Certifique-se de que estas propriedades estão definidas */
        }

        .swiper-button-next {
            right: 0; /* Posiciona o botão à direita */
        }

        .swiper-button-prev {
            left: 0; /* Posiciona o botão à esquerda */
        }


        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .swiper-slide img {
            width: 100%; /* Isso garante que a imagem preencha o slide */
            height: auto; /* Isso mantém a proporção da imagem correta */
            object-fit: cover; /* Isso cobrirá o espaço disponível, cortando o excesso */
        }

        .swiper-button-next, .swiper-button-prev {
            color: #fff;
            display: block;
        }

    </style>

</head>
<body>

<?php require 'header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/4">
            <?php if($data['movieDetails']['poster_path']) : ?>
            <img src="https://image.tmdb.org/t/p/w500<?= htmlspecialchars($data['movieDetails']['poster_path']) ?>" alt="<?= htmlspecialchars($data['movieDetails']['title']) ?>" class="rounded shadow-md">
            <?php else: ?>
              <img src="/images/sem-imagem.jpg" alt="<?= htmlspecialchars($data['movieDetails']['title']) ?>" class="rounded shadow-md">  
            <?php endif; ?>

        </div>
        <div class="md:w-3/4 md:ml-4">
            <h1 class="text-4xl font-bold mt-2 md:mt-0"><?= htmlspecialchars($data['movieDetails']['title']) ?></h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php
                    // Inicialize a variável $isInWatchlist como false
                    $isInWatchlist = false;

                    // Verifica se o filme está na watchlist do usuário
                    foreach ($data['watchlistMovies'] as $watchlistmovie) {
                        // Assumindo que $data['movieDetails']['id'] é uma string ou um número,
                        // e $watchlistmovie é um objeto com a propriedade tmdb_movie_id.
                        if ($data['movieDetails']['id'] == $watchlistmovie->tmdb_movie_id) {
                            $isInWatchlist = true;
                            break; // Sai do loop se o filme já está na watchlist
                        }
                    }

                    $buttonText = $isInWatchlist ? "Excluir da watchlist" : "Adicionar à minha watchlist";
                    $formAction = $isInWatchlist ? "/delete-from-watchlist" : "/add-to-watchlist";
                ?>
                <!-- Início do formulário para adicionar à Watchlist -->
                <form action="<?= $formAction; ?>/<?= $data['movieDetails']['id'] ?>" method="post">
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 watchlist-button" data-movie-id="<?= $data['movieDetails']['id'] ?>" data-action="<?= $isInWatchlist ? 'delete' : 'add' ?>">
                        <?= $buttonText; ?>
                    </button>
                </form>
            <?php endif; ?>   
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
                                <?php if (!is_null($crew['profile_path'])): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?= $crew['profile_path'] ?>" alt="<?= htmlspecialchars($crew['name']) ?>" class="rounded shadow-md">
                                <?php else: ?>
                                <img src="/images/sem-imagem.jpg" alt="<?= htmlspecialchars($crew['name']) ?>" class="rounded shadow-md">
                                <?php endif; ?>
                                <p class="text-center"><?= htmlspecialchars($crew['name']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

                        <!-- Botão de alternância -->
            <button id="toggle-cast" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                Mostrar todo o elenco
            </button>

            <!-- Seção Elenco -->
            <div class="mt-4">
                <h2 class="text-2xl font-bold">Elenco</h2>
                <div class="flex flex-wrap -mx-1 overflow-hidden" id="cast-list">
                    <?php
                    $count = 0;
                    foreach ($data['movieDetails']['credits']['cast'] as $index => $cast):
                        // Defina a classe 'hidden' para atores além dos 12 primeiros
                        $hiddenClass = $count >= 12 ? 'hidden' : '';
                    ?>
                    <div class="my-1 px-1 w-1/2 overflow-hidden md:w-1/6 lg:w-1/6 xl:w-1/6 <?= $hiddenClass ?> cast-member">
                        <?php if ($cast['profile_path']): ?>
                            <img src="https://image.tmdb.org/t/p/w500<?= $cast['profile_path'] ?>" alt="<?= htmlspecialchars($cast['name']) ?>" class="rounded shadow-md">
                        <?php else: ?>
                            <img src="/images/sem-imagem.jpg" alt="<?= htmlspecialchars($cast['name']) ?>" class="rounded shadow-md">
                        <?php endif; ?>
                        <p class="text-center"><?= htmlspecialchars($cast['name']) ?> (<?= htmlspecialchars($cast['character']) ?>)</p>
                    </div>
                    <?php
                        $count++;
                    endforeach;
                    ?>
                </div>
            </div>

            <div class="mt-4">
                <h2 class="text-2xl font-bold">Galeria de fotos</h2>
                <div class="swiper-container gallery-top">
                    <div class="swiper-wrapper">
                        <?php foreach ($data['movieImages']['backdrops'] as $image): ?>
                        <div class="swiper-slide">
                            <?php if ($image['file_path']): ?>
                            <img src="https://image.tmdb.org/t/p/original<?= htmlspecialchars($image['file_path']) ?>" alt="Imagem do filme" class="object-contain max-h-96">
                            <?php else: ?>
                            <img src="/images/sem-imagem.jpg" alt="Imagem do filme" class="object-contain max-h-96">
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>       

            <div class="mt-8">
                <h2 class="text-2xl font-bold">Reviews</h2>
                <!-- Botão para criar uma review -->
                <?php if (isset($_SESSION['user_id']) && !$data['userReview']): ?>
                    <a href="/create-review/<?= $data['movieDetails']['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Criar Review</a>
                <?php elseif ($data['userReview']): ?>
                    <h3 class="text-xl font-bold">Sua Review</h3>
                    <div class="review bg-gray-100 p-4 rounded-lg shadow mb-4">
                        <?php if (!is_null($data['userReview']->rating)): ?>
                            <div class="review-rating font-bold text-xl"><?= htmlspecialchars($data['userReview']->rating) ?>/10</div>
                        <?php endif; ?>
                        <div class="review-text mb-2"><?= nl2br(htmlspecialchars($data['userReview']->comment)) ?></div>
                        <div class="review-date text-gray-600 text-sm"><?= htmlspecialchars($data['userReview']->created_at) ?></div>
                    </div>
                <?php endif; ?>

                <div class="reviews mt-4">
                    <?php if (!empty($data['reviews'])): ?>
                        <h3 class="text-xl font-bold">Todas as Reviews</h3>
                        <?php foreach ($data['reviews'] as $review): ?>
                            <div class="review bg-gray-100 p-4 rounded-lg shadow mb-4">
                                <?php if (!is_null($review->rating)): ?>
                                    <div class="review-rating font-bold text-xl"><?= htmlspecialchars($review->rating) ?>/10</div>
                                <?php endif; ?>
                                <div class="review-text mb-2"><?= nl2br(htmlspecialchars($review->comment)) ?></div>
                                <div class="review-user">Por: <?= htmlspecialchars($review->user_name) ?></div>
                                <div class="review-date text-gray-600 text-sm"><?= htmlspecialchars($review->created_at) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma review ainda. Seja o primeiro a escrever uma!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var watchlistButton = document.querySelector('.watchlist-button');
    
    watchlistButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        var movieId = this.getAttribute('data-movie-id');
        var action = this.getAttribute('data-action');
        var url = action === 'add' ? '/add-to-watchlist/' : '/delete-from-watchlist/';

        fetch(url + movieId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', // Correção: Header para dados de formulário
            },
            body: 'movie_id=' + movieId // Dados enviados no formato de URL-encoded form
        })
        .then(response => {
            console.log(response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Garanta que o servidor está retornando JSON
        })
        .then(data => {
            console.log(data); // Veja o objeto de dados para entender o que está sendo retornado
            if(data.success) {
                var newText = action === 'add' ? 'Excluir da watchlist' : 'Adicionar à minha watchlist';
                var newAction = action === 'add' ? 'delete' : 'add';

                watchlistButton.textContent = newText;
                watchlistButton.setAttribute('data-action', newAction);
            } else {
                alert('Não foi possível modificar a watchlist.');
            }
        })
        .catch(error => {
            console.error('Houve um erro na requisição:', error);
        });
    });
});
</script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    var toggleButton = document.getElementById('toggle-cast');
    var castList = document.getElementById('cast-list');

    toggleButton.addEventListener('click', function() {
        var castMembers = castList.querySelectorAll('.cast-member'); // Use uma classe CSS nos membros do elenco
        var showAll = toggleButton.innerText === 'Mostrar todo o elenco';
        
        Array.from(castMembers).forEach(function(member, index) {
            if (index >= 12) {
                if (showAll) {
                    member.classList.remove('hidden');
                } else {
                    member.classList.add('hidden');
                }
            }
        });
        
        // Alternar o texto do botão
        toggleButton.innerText = showAll ? 'Não mostrar todo o elenco' : 'Mostrar todo o elenco';
    });
});

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var galleryTop = new Swiper('.gallery-top', {
        spaceBetween: 10,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        preloadImages: false, // Ativa o lazy loading
        lazy: true, // Configurações do lazy loading
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        mousewheel: true,
        breakpoints: {
            // Quando a largura da tela é >= 640px
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            // Quando a largura da tela é >= 768px
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
        on: {
            init: function () {
                this.slides.forEach(slide => {
                    slide.style.display = 'block'; // Garante que todos os slides são visíveis inicialmente
                });
            },
            slideChange: function () {
                this.slides[this.activeIndex].style.display = 'block';
            },
        },
    });
});

</script>

</body>
</html>
