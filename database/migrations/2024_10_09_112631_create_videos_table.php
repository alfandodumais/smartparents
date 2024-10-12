<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('videos', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('thumbnail');
        $table->string('video_path');
        $table->decimal('price', 8, 2)->default(0.00);
        $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('videos');
}

};
