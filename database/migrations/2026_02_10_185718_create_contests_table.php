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
            $table->integer('form_id');
            $table->integer('user_id');
            $table->boolean('is_active')->default(false);
            // $table->string('regulations');
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
