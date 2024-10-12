<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'token',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
