<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('request_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('request_id')
                ->constrained('requests')
                ->onDelete('cascade');

            $table->foreignId('item_id')
                ->constrained('items')
                ->onDelete('cascade');

            // Kolom utama:
            $table->integer('quantity')->default(1);

            // Opsional jika kamu ingin versi advanced:
            $table->decimal('qty_requested', 14, 4)->nullable();
            $table->decimal('qty_approved', 14, 4)->nullable();

            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_items');
    }
};
