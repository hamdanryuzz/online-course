<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDS Academy - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-xl font-bold text-blue-600">MDS Academy</a>
                    <a href="#courses" class="text-gray-700 hover:text-blue-600">Courses</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600">About</a>
                    @auth
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-semibold">
                                Dashboard
                            </a>
                        @endif
                    @endauth

                </div>
                <div class="flex items-center space-x-2">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Login
                        </a>
                    @endguest

                    @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-blue-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 mb-4">Learn From the Best Courses Online</h1>
            <p class="text-gray-600 mb-8">Explore thousands of courses from top instructors and start learning today!
            </p>
            <a href="#courses"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-lg font-semibold">
                Get Started
            </a>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Popular Courses</h2>

            <!-- Category Tabs -->
            <div class="flex justify-center mb-8 space-x-4">
                <button class="category-tab px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold"
                    data-category="all">
                    All
                </button>
                @foreach ($categories as $category)
                    <button
                        class="category-tab px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-blue-600 hover:text-white"
                        data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Courses Grid -->
            <div id="courses-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($courses as $course)
                    <div class="course-card bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition"
                        data-category="{{ $course->category_id }}">
                        <img src="{{ $course->cover }}" alt="{{ $course->name }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $course->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 40) }}</p>
                            <a href="{{ route('course-detail', $course->id) }}"
                                class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Learn
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="bg-gray-100 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Why Choose MDS Academy?</h2>
            <p class="text-gray-600 text-lg">We provide high-quality courses with expert instructors, interactive
                lessons, and practical projects to help you achieve your learning goals quickly and efficiently.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-6 mt-10 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-600">
            &copy; 2025 MDS Academy. All rights reserved.
        </div>
    </footer>

</body>

<script>
    const tabs = document.querySelectorAll('.category-tab');
    const courses = document.querySelectorAll('.course-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Hapus style aktif dari semua tab
            tabs.forEach(t => t.classList.remove('bg-blue-600', 'text-white'));
            tabs.forEach(t => t.classList.add('bg-gray-200', 'text-gray-700'));

            // Set tab aktif
            tab.classList.add('bg-blue-600', 'text-white');
            tab.classList.remove('bg-gray-200', 'text-gray-700');

            const categoryId = tab.getAttribute('data-category');

            courses.forEach(course => {
                if (categoryId === 'all' || course.getAttribute('data-category') ===
                    categoryId) {
                    course.classList.remove('hidden');
                } else {
                    course.classList.add('hidden');
                }
            });
        });
    });
</script>

</html>
