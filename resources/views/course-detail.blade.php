<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - MDS Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .materials-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .materials-scroll::-webkit-scrollbar-thumb {
            background-color: #3b82f6;
            border-radius: 4px;
        }

        .materials-scroll::-webkit-scrollbar-track {
            background-color: #f1f5f9;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/home" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">MDS Academy</a>
            <a href="/home" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Back Home
            </a>
        </div>
    </nav>

    <!-- Course Hero -->
    <section class="py-12 bg-blue-50">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">
            <img src="{{ $course->cover }}" alt="{{ $course->name }}" class="w-full h-64 object-cover">
            <div class="p-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">{{ $course->name }}</h1>
                <p class="text-gray-600 mb-6">{{ \Illuminate\Support\Str::limit($course->description, 100) }}</p>
                <a href="#materials"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    Start Learning
                </a>
            </div>
        </div>
    </section>

    <!-- Course Materials -->
    <section id="materials" class="py-12">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Sidebar -->
            <div class="col-span-1 bg-white rounded-2xl shadow-md p-4 h-[600px] overflow-y-auto materials-scroll">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Materials</h2>
                <div class="space-y-2">
                    @php
                        $completedIds = auth()->user()->completedMaterials->pluck('id')->toArray();
                    @endphp

                    @foreach ($course->materials as $material)
                        @php
                            $isCompleted = in_array($material->id, $completedIds);
                        @endphp
                        <button
                            class="w-full text-left p-3 rounded-lg transition border material-btn
                            {{ $isCompleted ? 'bg-green-100 border-green-300' : 'bg-white hover:bg-blue-50' }}"
                            data-id="{{ $material->id }}" data-video="{{ $material->file }}"
                            data-title="{{ $material->title }}" data-desc="{{ $material->description }}">
                            {{ $material->title }}
                            @if ($isCompleted)
                                ✅
                            @endif
                        </button>
                    @endforeach

                    <!-- Final Exam Button -->
                    <div id="final-exam-container" class="mt-4">
                        <a href="/course/{{ $course->id }}/final-exam" id="final-exam-btn"
                            class="w-full block text-center px-4 py-3 bg-yellow-400 text-white rounded-lg font-semibold cursor-not-allowed opacity-50 pointer-events-none">
                            Take Final Exam 🏆
                        </a>
                    </div>

                    <!-- Certificate Button -->
                    @php
                        $lastExam = auth()->user()->examResults()->where('course_id', $course->id)->latest()->first();
                        $canDownload = $lastExam && $lastExam->score >= 80;
                    @endphp

                    <div class="mt-4">
                        <a href="{{ $canDownload ? route('certificate.download', $course->id) : '#' }}"
                            class="w-full block text-center px-4 py-3 rounded-lg font-semibold
              {{ $canDownload ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-400 text-gray-200 cursor-not-allowed' }}">
                            Download Certificate 🏆
                        </a>
                    </div>


                </div>
            </div>

            <!-- Video Player -->
            <div class="col-span-3 bg-white rounded-2xl shadow-md overflow-hidden flex flex-col">
                <div class="w-full h-64 md:h-96 bg-gray-900 flex items-center justify-center">
                    @if ($course->materials->count() > 0)
                        <iframe id="video-player" class="w-full h-full" src="{{ $course->materials->first()->file }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @else
                        <p class="text-gray-400">No materials available.</p>
                    @endif
                </div>

                <!-- Material Info -->
                <div class="p-6 border-t border-gray-200">
                    <h3 id="video-title" class="text-xl font-semibold text-gray-800 mb-2">
                        {{ $course->materials->first()->title ?? 'No title available' }}
                    </h3>
                    <p id="video-desc" class="text-gray-600">
                        {{ $course->materials->first()->description ?? 'No description available' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Script -->
    <script>
        function markCompleted(materialId) {
            return fetch(`/material/${materialId}/complete`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            }).then(res => res.json());
        }

        function checkAllCompleted() {
            const buttons = document.querySelectorAll('.material-btn');
            const finalExamBtn = document.getElementById('final-exam-btn');

            let allCompleted = true;
            buttons.forEach(btn => {
                if (!btn.classList.contains('bg-green-100')) {
                    allCompleted = false;
                }
            });

            if (allCompleted) {
                finalExamBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            } else {
                finalExamBtn.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.material-btn');
            const player = document.getElementById('video-player');
            const titleEl = document.getElementById('video-title');
            const descEl = document.getElementById('video-desc');
            const finalExamBtn = document.getElementById('final-exam-btn');

            // cek awal semua materi
            checkAllCompleted();

            buttons.forEach(btn => {
                btn.addEventListener('click', async () => {
                    const videoUrl = btn.dataset.video;
                    const title = btn.dataset.title;
                    const desc = btn.dataset.desc;
                    const materialId = btn.dataset.id;

                    // ganti video
                    player.src = videoUrl;
                    titleEl.textContent = title;
                    descEl.textContent = desc;

                    // update backend
                    const data = await markCompleted(materialId);

                    if (data.status === "success") {
                        btn.classList.remove('bg-white', 'hover:bg-blue-50');
                        btn.classList.add('bg-green-100', 'border-green-300');

                        if (!btn.querySelector('.material-check')) {
                            const checkSpan = document.createElement('span');
                            checkSpan.classList.add('material-check');
                            checkSpan.textContent = " ✅";
                            btn.appendChild(checkSpan);
                        }

                        // cek final exam setelah update
                        checkAllCompleted();
                    }

                    // highlight active button
                    buttons.forEach(b => b.classList.remove('bg-blue-50', 'border-blue-300'));
                    btn.classList.add('bg-blue-50', 'border-blue-300');
                });
            });

            // set first material active
            if (buttons.length > 0) {
                buttons[0].classList.add('bg-blue-50', 'border-blue-300');
            }

            // fullscreen final exam
            finalExamBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (finalExamBtn.classList.contains('pointer-events-none')) return;

                const url = finalExamBtn.href;

                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen().then(() => {
                        window.location.href = url;
                    });
                } else {
                    window.location.href = url;
                }
            });

        });
    </script>

</body>

</html>
