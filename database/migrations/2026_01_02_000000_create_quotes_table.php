<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('project_type'); // أبواب مدرعة، بوابات، درابزين...
            $table->string('dimensions')->nullable(); // الأبعاد التقريبية
            $table->text('details')->nullable(); // تفاصيل إضافية ورغبات خاصة
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};