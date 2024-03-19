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