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
            $table->string('author_name');
            $table->string('content');
            $table->foreignId('post_id')
                    ->constrained('posts')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamp('creation_date');
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
