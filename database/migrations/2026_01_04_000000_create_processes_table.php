<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->integer('step_number'); // من 1 إلى 6
            $table->string('title');
            $table->text('description');
            $table->string('media_path')->nullable(); // مسار رفع الصورة أو الفيديو
            $table->string('media_type')->nullable(); // 'image' أو 'video'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('processes');
    }
};