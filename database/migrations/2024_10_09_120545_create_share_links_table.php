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
    Schema::create('share_links', function (Blueprint $table) {
        $table->id();
        $table->foreignId('video_id')->constrained()->onDelete('cascade');
        $table->string('token')->unique();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('share_links');
}


};
