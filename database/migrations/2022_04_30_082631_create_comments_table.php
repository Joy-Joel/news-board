<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                    ->constrained('users')
                    ->onDelete('cascade');
            $table->string('content');
            $table->foreignId('post_id')
                    ->constrained('posts')
                    ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
