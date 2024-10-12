<?php

namespace App\Http\Controllers;

use App\Models\ShareLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShareLinkController extends Controller
{
    public function access($token)
    {
        $shareLink = ShareLink::where('token', $token)->firstOrFail();
        $video = $shareLink->video;

        if ($video->price > 0) {
            return redirect()->route('purchase', $video);
        }

        return Storage::disk('public')->download($video->video_path);
    }
}
