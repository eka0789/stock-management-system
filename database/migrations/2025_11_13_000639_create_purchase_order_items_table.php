<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('items');

            $table->decimal('qty_requested', 14, 4);  // dari Request
            $table->decimal('qty_ordered', 14, 4);    // quantity dalam PO
            $table->decimal('qty_received', 14, 4)->default(0); // goods receipt
            
            $table->decimal('price', 14, 2)->nullable(); // optional
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('purchase_order_items');
    }
};
