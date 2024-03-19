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