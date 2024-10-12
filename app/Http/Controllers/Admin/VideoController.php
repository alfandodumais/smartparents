<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ShareLink;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'required|mimetypes:video/mp4,video/avi,video/mpeg|max:2000000',
            'price' => 'required|numeric|min:0',
        ]);

        // Upload thumbnail
        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        // Upload video
        $videoPath = $request->file('video')->store('videos', 'public');

        Video::create([
            'title' => $request->title,
            'thumbnail' => $thumbnailPath,
            'video_path' => $videoPath,
            'price' => $request->price,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diupload.');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:200000',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama
            Storage::disk('public')->delete($video->thumbnail);
            // Upload thumbnail baru
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $video->thumbnail = $thumbnailPath;
        }

        if ($request->hasFile('video')) {
            // Hapus video lama
            Storage::disk('public')->delete($video->video_path);
            // Upload video baru
            $videoPath = $request->file('video')->store('videos', 'public');
            $video->video_path = $videoPath;
        }

        $video->update([
            'title' => $request->title,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        // Hapus file thumbnail dan video
        Storage::disk('public')->delete([$video->thumbnail, $video->video_path]);
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }

    public function generateLink(Video $video)
{
    $token = Str::random(32);
    ShareLink::create([
        'video_id' => $video->id,
        'token' => $token,
    ]);

    $link = route('share.link', $token);
    return redirect()->back()->with('success', 'Share link generated: ' . $link);
}
}
