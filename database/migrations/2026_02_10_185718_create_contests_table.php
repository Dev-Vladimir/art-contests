<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->mediumText('title');
            $table->mediumText('nominations')->nullable();
            $table->mediumText('groups')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->boolean('open')->default(false);
            
            // Компактный вариант - сразу создает поле и ключ
            $table->foreignId('form_id')
                ->nullable()
                ->constrained('forms')  // автоматически создает внешний ключ
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
