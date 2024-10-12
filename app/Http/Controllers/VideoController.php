<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(12);
        return view('videos.index', compact('videos'));
    }

    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    public function download(Video $video)
    {
        if ($video->price > 0) {
            return redirect()->route('purchase', $video);
        }

        // Cek apakah file ada
        if (!Storage::disk('public')->exists($video->video_path)) {
            return redirect()->back()->with('error', 'File video tidak ditemukan.');
        }

        // Mendapatkan path absolut ke file
        $filePath = Storage::disk('public')->path($video->video_path);

        // Cek apakah file dapat diakses
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File video tidak dapat diakses.');
        }

        try {
            return response()->download($filePath);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat mendownload video: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendownload video.');
        }
    }
}
