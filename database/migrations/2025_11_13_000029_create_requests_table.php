<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // RQ-20250001
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', [
                'pending',       // dibuat leader
                'approved',      // disetujui admin → menunggu finance
                'rejected',      // ditolak admin
                'forwarded',     // admin sudah teruskan ke finance
                'completed'      // item diterima & selesai
            ])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('requests');
    }
};
