<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'video_path',
        'price',
        'uploaded_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
