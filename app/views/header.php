<nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="font-bold"><a href="/">Movie App</a></div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/watchlist" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Watchlist</a>
                <a href="/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
            <?php else: ?>
                <a href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
                <a href="/register" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Registro</a>
            <?php endif; ?>
        </div>
    </nav>