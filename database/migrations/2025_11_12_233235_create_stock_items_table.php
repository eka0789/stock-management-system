<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->integer('quantity')->default(0);   // support decimals
            $table->timestamps();
            $table->unique(['item_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('stock_items');
    }
};
