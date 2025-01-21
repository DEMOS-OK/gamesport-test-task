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
        Schema::create('files', static function (Blueprint $table) {
            $table->id();
            $table->string('source_title');
            $table->string('result_title')
                ->nullable();
            $table->boolean('is_private')
                ->default(false);
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('status');

            $table->timestamp('created_at')
                ->nullable()
                ->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrentOnUpdate()
                ->nullable()
                ->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
