<!-- <nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="font-bold"><a href="/">Movie App</a></div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/my-reviews" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Reviews</a>
                <a href="/watchlist" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Watchlist</a>
                <a href="/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
            <?php else: ?>
                <a href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
                <a href="/register" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Registro</a>
            <?php endif; ?>
        </div>
    </nav> -->

    <nav class="bg-gray-800 p-4 text-white">
    <div class="flex items-center justify-between flex-wrap">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <span class="font-semibold text-xl tracking-tight"><a href="/">Movie App</a></span>
        </div>
        <div class="block md:hidden">
            <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0zM0 9h20v2H0zM0 15h20v2H0z"/></svg>
            </button>
        </div>
        <div id="nav-content" class="hidden w-full block flex-grow md:flex md:items-center md:w-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="text-sm md:flex-grow md:flex md:justify-end">
                    <a href="/my-reviews" class="block mt-4 md:inline-block md:mt-0 text-teal-200 hover:text-white font-bold mr-4">Reviews</a>
                    <a href="/watchlist" class="block mt-4 md:inline-block md:mt-0 text-teal-200 hover:text-white font-bold mr-4">Watchlist</a>
                    <a href="/logout" class="block mt-4 md:inline-block md:mt-0 text-teal-200 font-bold hover:text-white">Logout</a>
                </div>
            <?php else: ?>
                <div class="text-sm md:flex-grow md:flex md:justify-end">
                    <a href="/login" class="block mt-4 md:inline-block md:mt-0 text-teal-200 hover:text-white font-bold mr-4">Login</a>
                    <a href="/register" class="block mt-4 md:inline-block md:mt-0 text-teal-200 hover:text-white font-bold">Registro</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.getElementById('nav-toggle').addEventListener('click', function(){
            var navContent = document.getElementById('nav-content');
            navContent.classList.toggle('hidden');
        });
    });
</script>
