<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar untuk desktop dan mobile -->
    <aside id="sidebar"
        class="w-64 bg-white shadow-md min-h-screen p-6 fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200 z-30">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-blue-600">MDS Admin</h1>
            <button id="close-sidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition text-gray-700 hover:text-blue-600">
                <i class="fas fa-chart-line mr-3"></i>
                Dashboard
            </a>
            <a href="{{ route('home') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition text-gray-700 hover:text-blue-600">
                <i class="fas fa-chart-line mr-3"></i>
                Home
            </a>
            <a href="{{ route('manage-course.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition text-gray-700 hover:text-blue-600">
                <i class="fas fa-book mr-3"></i>
                Manage Courses
            </a>
            <a href="{{ route('manage-exam.index') }}"
                class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition text-gray-700 hover:text-blue-600">
                <i class="fas fa-book mr-3"></i>
                Manage Exam
            </a>

            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('manage-category.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition text-gray-700 hover:text-blue-600">
                        <i class="fas fa-book mr-3"></i>
                        Manage Category
                    </a>
                    <a href="{{ route('manage-user.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 transition text-gray-700 hover:text-blue-600">
                        <i class="fas fa-book mr-3"></i>
                        Manage Users
                    </a>
                @endif
            @endauth
            <form action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- Overlay untuk mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col md:ml-0">

        <!-- Top Navbar -->
        <nav class="bg-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center">
                <button id="sidebar-toggle"
                    class="md:hidden px-3 py-2 mr-2 border rounded text-gray-600 hover:text-gray-800">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-bold text-blue-600">@yield('title', 'Admin Dashboard')</h1>
            </div>
            @php
                $user = auth()->user();
                $initials = collect(explode(' ', $user->name))
                    ->map(fn($n) => strtoupper($n[0]))
                    ->take(2)
                    ->join('');
            @endphp

            <div class="flex items-center">
                <span class="text-sm text-gray-600 mr-4 hidden md:block">{{ $user->name }}</span>
                <span class="text-sm text-gray-600 mr-4 hidden md:block">{{ $user->role }}</span>
                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm">
                    {{ $initials }}
                </div>
            </div>

        </nav>

        <main class="p-6 flex-1">
            @yield('content')
        </main>
    </div>

    <script>
        // Toggle sidebar untuk mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const closeBtn = document.getElementById('close-sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        toggleBtn?.addEventListener('click', toggleSidebar);
        closeBtn?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Menutup sidebar ketika window di-resize ke ukuran desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>

</body>

</html>
