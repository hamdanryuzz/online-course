<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ExamResult;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan ini import yang benar
use Illuminate\Support\Facades\Auth; // <-- perbaikan di sini

class CertificateController extends Controller
{
    public function downloadCertificate(Course $course)
    {
        $user = Auth::user(); // <-- dapat user login
        $lastExam = $user->examResults()->where('course_id', $course->id)->latest()->first();

        if (!$lastExam || $lastExam->score < 80) {
            abort(403, 'You are not eligible for the certificate.');
        }

        $pdf = Pdf::loadView('certificate', [
            'user' => $user,
            'course' => $course,
            'score' => $lastExam->score
        ]);

        $filename = 'Certificate - ' . $course->name . ' - ' . $user->name . '.pdf';

        return $pdf->download($filename);
    }
}
