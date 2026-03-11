<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->text('features')->nullable();
            $table->text('requirements')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->boolean('is_enterprise')->default(false);
            $table->string('demo_url')->nullable();
            $table->string('demo_video_url')->nullable();
            $table->string('version')->nullable();
            $table->string('file_path')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('download_count')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
