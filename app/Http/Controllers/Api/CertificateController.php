<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function downloadCertificate(Course $course)
    {
        $user = Auth::user();
        $lastExam = $user->examResults()
            ->where('course_id', $course->id)
            ->latest()
            ->first();

        if (!$lastExam || $lastExam->score < 80) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not eligible for the certificate. Minimum score: 80'
            ], 403);
        }

        // Generate PDF
        $pdf = Pdf::loadView('certificate', [
            'user' => $user,
            'course' => $course,
            'score' => $lastExam->score
        ]);

        $filename = 'certificate-' . $course->id . '-' . $user->id . '.pdf';
        $path = 'certificates/' . $filename;

        // Simpan ke storage/app/public/certificates
        Storage::disk('public')->put($path, $pdf->output());

        return response()->json([
            'status' => 'success',
            'message' => 'Certificate generated successfully',
            'download_url' => asset('storage/' . $path)
        ]);
    }
}
