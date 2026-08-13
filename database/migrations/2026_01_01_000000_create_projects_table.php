<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->json('materials')->nullable();
            $table->json('specs')->nullable();
            $table->json('images')->nullable();
            $table->json('client_testimonial')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
