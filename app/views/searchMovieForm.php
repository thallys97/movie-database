<form action="/" method="get" class="text-center mb-4">
        <input 
            type="search" 
            name="search" 
            placeholder="Digite o nome do filme..." 
            class="mt-1 p-2 border rounded"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >
        <button 
            type="submit" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Buscar
        </button>
        <?php if ($data['movieIsSearched']): ?>
            <button type="button" onclick="window.location.href = '/'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded sm:mt-0 mt-4">     
                    Limpar busca
            </button>

        <?php endif; ?>
    </form>