<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('purchase_order_items', function (Blueprint $table) {
        if (!Schema::hasColumn('purchase_order_items', 'quantity')) {
            $table->decimal('quantity', 14, 4)->default(0)->after('item_id');
        }
    });
}

public function down()
{
    Schema::table('purchase_order_items', function (Blueprint $table) {
        $table->dropColumn('quantity');
    });
}

};
