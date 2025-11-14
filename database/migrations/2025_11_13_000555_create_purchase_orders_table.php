<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // PO-2025xxxx
            $table->foreignId('request_id')->nullable()->constrained('requests')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users'); // finance user
            $table->enum('status', [
                'draft',      // dibuat finance, belum dikirim ke supplier
                'sent',       // PO dikirim ke supplier
                'received',   // barang diterima sebagian/semua
                'completed'   // transaksi selesai
            ])->default('draft');

            $table->string('supplier_name')->nullable();
            $table->string('supplier_contact')->nullable();
            $table->date('due_date')->nullable(); // tanggal PO dibutuhkan

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('purchase_orders');
    }
};
