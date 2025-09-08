<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Final Exam - {{ $course->name }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    html, body {
        height: 100%;
        margin: 0;
        background-color: #f3f4f6;
        font-family: sans-serif;
        /* overflow hidden dihapus supaya bisa scroll */
    }
    .exam-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* biar scroll dari atas */
        align-items: center;
        width: 100vw;
        height: 100vh;
        padding: 2rem;
        overflow-y: auto; /* scroll vertical */
        box-sizing: border-box;
    }
    .question-box {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        width: 100%;
        max-width: 800px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    #examForm {
        width: 100%;
        max-width: 800px;
    }
    #startExamBtn {
        padding: 1rem 2rem;
        font-size: 1.25rem;
        background-color: #facc15;
        color: white;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: background 0.3s;
    }
    #startExamBtn:hover {
        background-color: #eab308;
    }
</style>

</head>
<body>
<div class="exam-wrapper" id="examWrapper">
    <h1 class="text-3xl font-bold mb-8">Final Exam - {{ $course->name }}</h1>

    <button id="startExamBtn">Start Exam 🏆</button>

    <form method="POST" action="{{ route('exam.submit', $course->id) }}" id="examForm" class="hidden">
        @csrf
        @foreach($exams as $exam)
        <div class="question-box">
            <h2 class="font-semibold mb-4">{{ $loop->iteration }}. {{ $exam->question }}</h2>
            @foreach($exam->options as $option)
            <label class="block mb-2">
                <input type="radio" name="answers[{{ $exam->id }}]" value="{{ $option }}" class="mr-2">
                {{ $option }}
            </label>
            @endforeach
        </div>
        @endforeach

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-lg">Submit Exam</button>
    </form>
</div>

<script>
const startBtn = document.getElementById('startExamBtn');
const examForm = document.getElementById('examForm');

startBtn.addEventListener('click', async () => {
    // request fullscreen
    if (document.documentElement.requestFullscreen) {
        await document.documentElement.requestFullscreen();
    }

    // sembunyikan tombol start
    startBtn.classList.add('hidden');
    // tampilkan form exam
    examForm.classList.remove('hidden');

    // deteksi keluar window
    let focusLostCount = 0;
    window.addEventListener('blur', () => {
        focusLostCount++;
        alert('You switched windows! Please stay on the exam. Attempt #' + focusLostCount);
        // opsional: submit otomatis jika keluar lebih dari 2x
        // if(focusLostCount >= 2) examForm.submit();
    });
});
</script>
</body>
</html>
