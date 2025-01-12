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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id')->index();
            $table->string('name');
            $table->text('content')->nullable();
            $table->string('type')->default('text');
            $table->json('options')->nullable();
            $table->string('column_span')->default('full');
            $table->integer('order');
            $table->string('placeholder')->nullable();
            $table->text('helper_text')->nullable();
            $table->boolean('required')->default(false);
            $table->integer('rows')->nullable();
            $table->boolean('multiple')->default(false);
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->dateTime('min_date')->nullable();
            $table->dateTime('max_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
